<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\RhuUser;
use App\Models\RhuClient;
use App\Models\RhuAnnouncement;
use App\Models\RhuAppointment;
use App\Models\RhuSupply;
use App\Models\Logs;
use App\Models\RhuTest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RhuBloodType;
use App\Services\SemaphoreService;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpWord\IOFactory;
use NumberFormatter;
use Illuminate\Support\Facades\Http;

use Mail;
use App\Mail\DemoMail;

class Laboratory extends Controller
{

    protected $semaphoreService;
    protected $currentDepartment;
    protected $currentRole;

    public function __construct(SemaphoreService $semaphoreService)
    {
        $this->semaphoreService = $semaphoreService;
        $this->currentDepartment = session('currentDepartment');
        $this->currentRole = session('currentRole');
    }

    public function reports()
    {
        if (auth()->user()->department !== 'LABORATORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{

            $patients = RhuClient::where('type', 'laboratory')->get();
            $blood_appointments = RhuAppointment::where('type', 'laboratory')->get();
            $tests = RhuTest::all();

            return view('laboratory.reports', compact('patients', 'blood_appointments', 'tests'));
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|string|max:255',
            'sub_type' => 'required|string|max:255',
            'date' => 'required|string',
            // 'contactNo' => 'required|string|max:15',
        ]);

        // Convert the date to the proper format
        $formattedDate = Carbon::createFromFormat('Y-m-d h:i A', $request->date)->format('Y-m-d H:i:s');

        // Check if the appointment with the same user (auth->id) and type already exists
        $existingAppointment = RhuAppointment::where('client_id', Auth::id())
            ->where('type', $request->type)
            ->where('sub_type', $request->sub_type)
            // ->where('status', 'Pending')
            ->whereIn('status', ['Pending', 'Approved'])
            ->exists();

            if ($existingAppointment) {
                return redirect()->back()->with('error', 'You have a pending appointment for ' . $request->sub_type);
            }

        // Update the request data with the formatted date
        $requestData = $request->all();
        $requestData['date'] = $formattedDate;
        $requestData['client_id'] = Auth::id();
        $requestData['status'] = "Pending";
        $requestData['email'] = auth()->user()->email;
        $requestData['contactNo'] = auth()->user()->contactNo;

        $client = RhuAppointment::create($requestData);


        // Find the client with the department matching the appointment type
        $notificationClient = RhuUser::where('department', $request->type)->first();
        // Create a notification for the client
        Notification::create([
           'client_id' => $notificationClient->id,
            'content' => "New appointment for {$client->type} ({$client->sub_type}) has been created.",
            'status' => 'unread',
            'date' => now(),
        ]);



        $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = "{$client->name} Added new appointment to Department: " . ucfirst($client->department) . " - {$client->sub_type}.";

                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => $activityMessage,
                    'date' => now(),
                ]);



        return redirect()->back()->with('success', 'Appointment created successfully.');
    }

     public function laboratory()
     {
         if (auth()->user()->department !== 'LABORATORY') {
             return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
         } else{
             // Get the count of appointments with status 'Pending' or 'Approved'
             $totalMedicines = RhuSupply::where('type', 'Medicines')->count();
             $totalSupplies = RhuSupply::where('type', 'Medical Supplies')->count();
             $totalEquipments = RhuSupply::where('type', 'Medical Equipments')->count();
             $totalVaccines = RhuSupply::where('type', 'Vaccines')->count();


            $pendingCount = RhuAppointment::where('status', 'Pending')
                ->where('type', 'laboratory')
                ->count();
            $approvedCount = RhuAppointment::where('status', 'Approved')
                ->where('type', 'laboratory')
                ->count();

            $totalCount = $pendingCount + $approvedCount;
            $completedCount = RhuClient::where('status', 'Completed')
                ->where('type', 'laboratory')
                ->count();


             // Pass the counts and total to the view
             return view('laboratory.homepage', [
                 'totalMedicines' => $totalMedicines,
                 'totalSupplies' => $totalSupplies,
                 'totalEquipments' => $totalEquipments,
                 'totalVaccines' => $totalVaccines,

                 'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount,
                'totalCount' => $totalCount,
                'completedCount' => $completedCount,
                 'currentDepartment' => $this->currentDepartment
             ]);
         }

     }

    public function display_lab_appointments()
    {
        if (auth()->user()->department !== 'LABORATORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            $lab_appointments = RhuAppointment::Where('type', 'laboratory')
                ->whereIn('status', ['Pending', 'Approved'])
                ->get();
            return view('laboratory.display_appointments', compact('lab_appointments'));
        }
    }

    public function approve_appointments(Request $request, $id)
    {
        try {
            $client = RhuAppointment::findOrFail($id);
            $client->status = 'Approved';
            $client->save();

            $number = "+639566310705";
            $message = 'Your appointment approved';
            // $senderName = 'RHU';

            $response = $this->semaphoreService->sendSMS($number, $message);


            $user = Auth::user();

            // Create a descriptive activity message
            $activityMessage = "Approved {$client->name} appointment to Department: " . ucfirst($client->department) . " - {$client->sub_type}.";


                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => $activityMessage,
                    'date' => now(),
                ]);


            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function email(Request $request, $id)
    {

        $type = strtolower(auth()->user()->department);

        try {

              // Retrieve the appointment details where type is "laboratory" and status is "completed"
              $appointment = RhuAppointment::where('type', $type)
                ->where('status', 'Approved')
                ->where('client_id', $id)
                ->first();

                $r_clientId =  $appointment->client_id;



                if ($appointment->type === 'consultation') {
                    $testPrice = 0;
                }
                if ($appointment->type === 'laboratory') {
                    $testPrice = RhuTest::where('name', $appointment->sub_type)->value('price');

                }

                if ($appointment->type === 'blood') {
                    $testPrice = 1;
                }
                if ($appointment->type === 'vaccination') {
                    $testPrice = 2;
                }


                $r_date = now()->format('m/d/Y');
                $r_no = rand(100000, 999999);
                $r_series = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5));
                $r_agency =  "RURAL HEALTH OF LUCBAN";
                $r_payor =  $appointment->name;
                $r_nature = $appointment->sub_type . " " . $appointment->type;
                $r_acc_code =  rand(100000, 999999);
                $r_amount =$testPrice;
                $r_total =$testPrice;


            // Convert number to words
            $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $r_amount_words = strtoupper($formatter->format($r_total));
            $r_amount_word = $r_amount_words . "PESOS";

            $r_teller =  'Juan Dela Cruz';
            $r_officer =  'Luis Mallari';

            // Load the MS Word template
            $templatePath = storage_path('app/public/templates/receipt.docx'); // Correct path to template
            $templateProcessor = new TemplateProcessor($templatePath);

            // Replace placeholders with values
            $templateProcessor->setValue('r_date', $r_date);
            $templateProcessor->setValue('r_no', $r_no);
            $templateProcessor->setValue('r_series', $r_series);
            $templateProcessor->setValue('r_agency', $r_agency);
            $templateProcessor->setValue('r_payor', $r_payor);
            $templateProcessor->setValue('r_nature', $r_nature);
            $templateProcessor->setValue('r_acc_code', $r_acc_code);
            $templateProcessor->setValue('r_amount', number_format($r_amount, 2));
            $templateProcessor->setValue('r_total', number_format($r_total, 2));
            $templateProcessor->setValue('r_amount_word', $r_amount_word);
            $templateProcessor->setValue('r_teller', $r_teller);
            $templateProcessor->setValue('r_officer', $r_officer);

            // Generate the file name for the PDF
            $fileName = 'receipt_' . uniqid() . '.pdf'; // Use uniqid for unique file names

            // Set the file path for saving the PDF
            $filePath = 'receipts/' . $fileName; // Save in 'receipts' folder

            // Save the filled template to a temporary Word file
            $tempWordFile = storage_path('app/public/temp_receipt.docx');
            $templateProcessor->saveAs($tempWordFile);

            // Load the saved Word document
            $phpWord = IOFactory::load($tempWordFile);

            // Save the Word content to HTML (you can manipulate it if needed)
            $html = $this->wordToHtml($phpWord);

            // Generate PDF from HTML
            $pdf = PDF::loadHTML($html);

            // Save the generated PDF to the storage path
            $pdf->save(storage_path('app/public/' . $filePath));

            // Optionally, delete the temporary Word file after generating the PDF
            unlink($tempWordFile);
                $mailData = [
                    'title' => 'Rural Health Unit',
                    'client' => "{$appointment->name}",
                    'body' => "Your appointment for {$type} {$appointment->sub_type} services has been approved.
                    Please arrive at least 15 minutes early and bring any necessary documents. If you have questions or need to reschedule, contact us at rhulucban24@gmail.com.",
                    'file_path' => $filePath, // Add the PDF path
                ];


                $client_email = RhuUser::where('id', $appointment->client_id)->first();

                $userEmail = $client_email->email;

                // Send email notification to the client
                Mail::to($userEmail)->send(new DemoMail($mailData));

                // Add a notification entry to the database
                Notification::create([
                    'client_id' => $appointment->client_id,
                    'content' => "Your appointment for {$type} {$appointment->sub_type} services has been approved.",
                    'status' => 'unread',
                    'date' => now(),
                ]);


                // Format the contact number to start with '639'
                $formattedContactNo = '639' . ltrim($appointment->contactNo, '0');

               // for text message
                $smsResponse = Http::withHeaders([
                    "Authorization" => "Bearer 1304|VbjM1WjM5ZuYwClqZPo9p7dLaHWMDQAHIaTdrtdb",
                    "Content-Type" => "application/json",
                    "Accept" => "application/json",
                ])
                ->post('https://app.philsms.com/api/v3/sms/send', [
                    // "recipient" => "639566310705",
                    "recipient" => $formattedContactNo,
                    "sender_id" => "PhilSMS",
                    "type" => "plain",
                    // "message" => " contrated message", //this is for test message coz philsms not allow identical message for test pusposes
                    "message" => "Good day! Your appointment for " . strtoupper($appointment->type) . " {$appointment->sub_type} services has been approved.\nPlease arrive at least 15 minutes early and bring any necessary documents and receipts.\nIf you have questions or need to reschedule, contact us at rhulucban24@gmail.com.\n\nWe look forward to assisting you with your healthcare needs.",
                ]);

                // Check if SMS was sent successfully
                if ($smsResponse->successful()) {
                    \Log::info('SMS sent successfully to ' . $appointment->contactNo);
                } else {
                    \Log::error('SMS sending failed: ' . $smsResponse->body());
                }


                return redirect()->back();
            } catch (\Exception $e) {
                \Log::error('Error generating PDF: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while generating the PDF.');
            }
    }

    private function wordToHtml($phpWord)
    {
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlFile = storage_path('app/temp.html');
        $htmlWriter->save($htmlFile);

        return file_get_contents($htmlFile);
    }

    public function delete_appointments($id)
    {
        try {
            $client = RhuAppointment::findOrFail($id);
            $client->delete();
            // Set a session message for SweetAlert
            session()->flash('success', 'User deleted successfully.');

            $user = Auth::user();

            // Create a descriptive activity message
            $activityMessage = "Deleted {$client->name} appointment to Department: " . ucfirst($client->department) . " - {$client->sub_type}.";


                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => $activityMessage,
                    'date' => now(),
                ]);



            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function lab_staff_management()
    {
        if (auth()->user()->department !== 'LABORATORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $staffs = RhuUser::where('role', 'Admin')
                ->where('department', 'LABORATORY')
                ->get()
                ->map(function($staff) {
                    // Format 'bday' if it exists
                    if ($staff->bday) {
                        $staff->bday = Carbon::parse($staff->bday)->format('Y-m-d');
                    }
                    return $staff;
                })
                ->sortBy('created_at');  // Sorting staff by 'created_at' in ascending order

            // Return the view and pass both clients and staff data to it
            return view('laboratory.staff_account', compact('staffs'));
        }

    }


       ################ Test ########################

       public function lab_tests()
       {
           if (auth()->user()->department !== 'LABORATORY') {
               return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
           } else {

               $lab_tests = RhuTest::all();
               return view('laboratory.lab_tests', compact('lab_tests'));
           }

       }

       public function add_lab_tests(Request $request)
       {
           // Validate the form data
           $validatedAttributes = $request->validate([
               'name' => 'required|string|max:255',
               'price' => 'nullable|string',
               'status' => 'nullable|string|max:255',


               'name' => [
                   'nullable',
                   'string',
                   'max:255',
                   Rule::unique('rhu_supplies')->ignore($request->id), // Exclude current user's username
               ],

           ]);

           // Create a new user record
           $x = RhuTest::create($validatedAttributes);

           $user = Auth::user();

            // Create a descriptive activity message
            $activityMessage = "Added lab test {$x->name}.";


                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => $activityMessage,
                    'date' => now(),
                ]);



           // Redirect after creating the user
           return redirect()->back()->with('success', 'Test Added Successfully.');
       }

       public function update_lab_tests(Request $request, $pId)
       {
           $lab_test = RhuTest::findOrFail($pId);

           // Validate the input
           $validatedData = $request->validate([
               'name' => 'required|string|max:255',
               'price' => 'nullable|string',
               'status' => 'nullable|string|max:255',

               'name' => [
                   'nullable',
                   'string',
                   'max:255',
                   Rule::unique('rhu_supplies')->ignore($request->id), // Exclude current user's username
               ],

           ]);

           $lab_test->update($validatedData);

           $user = Auth::user();

           // Create a descriptive activity message
           $activityMessage = "Updated lab test {$lab_test->name}.";


               Logs::create([
                   'user_id' => $user->id,
                   'name' => $user->f_name . " " . $user->l_name,
                   'department' => $user->department,
                   'position' => $user->role,
                   'time_in' => now(),
                   'time_out' => null,
                   'activity' => $activityMessage,
                   'date' => now(),
               ]);




           session()->flash('success', 'Medical Equipments information updated successfully.');

           return redirect()->back();
       }

       public function delete_lab_tests($id)
       {
           try {
               $lab_test = RhuTest::findOrFail($id);
               $lab_test->delete();

               session()->flash('success', 'Medical Supplies delete successfully.');

               $user = Auth::user();


               // Create a descriptive activity message
               $activityMessage = "Deleted lab test {$lab_test->name}.";


                   Logs::create([
                       'user_id' => $user->id,
                       'name' => $user->f_name . " " . $user->l_name,
                       'department' => $user->department,
                       'position' => $user->role,
                       'time_in' => now(),
                       'time_out' => null,
                       'activity' => $activityMessage,
                       'date' => now(),
                   ]);


               return response()->json(['success' => true]);

           } catch (\Exception $e) {
               return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
           }
       }

        // for patient record
       public function lab_patient_records()
       {
           if (auth()->user()->department !== 'LABORATORY') {
               return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
           } else {
                $patients = RhuClient::where('type', 'laboratory')
                    ->whereIn('status', ['Completed', 'Rejected'])
                    ->get();

                $appointments = RhuAppointment::where('type', 'laboratory')
                    ->where('status', 'Approved')
                    ->get();

                return view('laboratory.lab_patient_records', compact('patients','appointments'));
           }
       }

       public function add_lab_patient_records(Request $request)
       {
           // Validate the form data
           $validatedAttributes = $request->validate([
                'name' => 'required|string|max:255',
                'sub_type' => 'required|string|max:255', // Ensure sub_type is populated
                'result' => 'required|file|mimes:pdf,docx,jpg,png|max:2048', // File validation
                'status' => 'required|string|in:Completed,Rejected',


            //    'name' => [
            //        'nullable',
            //        'string',
            //        'max:255',
            //        Rule::unique('rhu_supplies')->ignore($request->id), // Exclude current user's username
            //    ],

           ]);

        // Process the file upload if needed
            if ($request->hasFile('result')) {
                $filePath = $request->file('result')->store('test_results', 'public');
                $validatedAttributes['result'] = $filePath;

                // Fix: Combine the update fields into a single associative array
                RhuAppointment::where('type', 'laboratory')
                    ->where('sub_type', $request->sub_type)
                    ->whereIn('status', ['Pending', 'Approved'])
                    ->update([
                        'status' => 'Completed',
                        'result' => $filePath
                    ]);
            }


            $validatedAttributes['date'] = now();
            $validatedAttributes['type'] = 'laboratory';

            // Save the data to RhuTest
            $client = RhuClient::create($validatedAttributes);
           // Redirect after creating the user





            $user = Auth::user();

            // Create a descriptive activity message
            $activityMessage = "Added {$client->name} to patient record .";


                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => $activityMessage,
                    'date' => now(),
                ]);






           return redirect()->back();
       }

        public function getSubType($name)
        {
            $appointment = RhuAppointment::where('name', $name)
                ->where('type', 'laboratory')
                ->first();
            if ($appointment) {
                return response()->json(['sub_type' => $appointment->sub_type]);
            }
            return response()->json(['error' => 'No data found'], 404);
        }

        public function delete_patient_records($id)
        {
            try {
                $clients = RhuClient::findOrFail($id);
                $clients->delete();

                session()->flash('success', 'Patient Record deleted successfully.');

                $user = Auth::user();

                // Create a descriptive activity message
                $activityMessage = " Deleted {$clients->name} from patient record: ";


                    Logs::create([
                        'user_id' => $user->id,
                        'name' => $user->f_name . " " . $user->l_name,
                        'department' => $user->department,
                        'position' => $user->role,
                        'time_in' => now(),
                        'time_out' => null,
                        'activity' => $activityMessage,
                        'date' => now(),
                    ]);


                return response()->json(['success' => true]);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }


}