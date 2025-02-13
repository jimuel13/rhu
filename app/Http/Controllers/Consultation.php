<?php

namespace App\Http\Controllers;

use App\Models\RhuUser;
use App\Models\RhuClient;
use App\Models\RhuAnnouncement;
use App\Models\RhuAppointment;
use App\Models\RhuSupply;
use App\Models\RhuTest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RhuBloodType;
use App\Models\Logs;

use Illuminate\Support\Facades\Http;
use App\Models\Notification;

use Mail;
use App\Mail\DemoMail;


class Consultation extends Controller
{
    protected $currentDepartment;
    protected $currentRole;

    public function __construct()
    {
        $this->currentDepartment = session('currentDepartment');
        $this->currentRole = session('currentRole');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|string|max:255',
            'sub_type' => 'required|string|max:255',
            'date' => 'required|string',
            'reason' => 'required|string|max:255',
            // 'contactNo' => 'required|string|max:15',
        ]);

        // Convert the date to the proper format
        $formattedDate = Carbon::createFromFormat('Y-m-d h:i A', $request->date)->format('Y-m-d H:i:s');

        // Check if the appointment with the same user (auth->id) and type already exists
        $existingAppointment = RhuAppointment::where('client_id', Auth::id())
            ->where('type', $request->type)
            ->where('sub_type', $request->sub_type)
            ->whereIn('status', ['Pending', 'Approved'])
            ->exists();

        // if you want to restrict to one appointment per departmnet
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

        // Find the client with the department matching the appointment type
        $notificationClient = RhuUser::where('department', $request->type)->first();
        // Create a notification for the client
        Notification::create([
            'client_id' => $notificationClient->id,
            'content' => "New appointment for {$client->type} ({$client->sub_type}) has been created.",
            'status' => 'unread',
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Appointment created successfully.');
    }

    public function consultation()
    {
        if (auth()->user()->department !== 'CONSULTATION') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            // Get the count of appointments with status 'Pending' or 'Approved'
            $totalMedicines = RhuSupply::where('type', 'Medicines')->count();
            $totalSupplies = RhuSupply::where('type', 'Medical Supplies')->count();
            $totalEquipments = RhuSupply::where('type', 'Medical Equipments')->count();
            $totalVaccines = RhuSupply::where('type', 'Vaccines')->count();


           $pendingCount = RhuAppointment::where('status', 'Pending')
               ->where('type', 'consultation')
               ->count();
           $approvedCount = RhuAppointment::where('status', 'Approved')
               ->where('type', 'consultation')
               ->count();

           $totalCount = $pendingCount + $approvedCount;
           $completedCount = RhuClient::where('status', 'Completed')
               ->where('type', 'consultation')
               ->count();


            // Pass the counts and total to the view
            return view('consultation.homepage', [
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

   public function display_con_appointments()
   {
       if (auth()->user()->department !== 'CONSULTATION') {
           return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
       } else{
           $con_appointments = RhuAppointment::Where('type', 'consultation')
               ->whereIn('status', ['Pending', 'Approved', 'Rejected'])
               ->get();
           return view('consultation.display_appointments', compact('con_appointments'));
       }
   }

    public function con_refer_reject(Request $request, $pId)
    {
        $client = RhuAppointment::findOrFail($pId);

        // Validate the input
        $validatedData = $request->validate([
            'refer' => 'nullable|string|max:255',
        ]);

        $validatedData['status'] = "Rejected";
        $client->update($validatedData);

        $client_email = RhuUser::where('id', $client->client_id)->first();

        $userEmail = $client_email->email;


        $mailData = [
            'title' => 'Rural Health Unit',
            'client' => "{$client->name}",
            'body' => "Your appointment for {$client->sub_type} consultation has been rejected this time due to some reasons. 
            We apologize for the inconvenience. As an alternative, we are referring you to the following healthcare provider: {$client->refer}.
            Please reach out to them directly to book an appointment. ",
        ];


        // Mail::to('emer22297@gmail.com')->send(new DemoMail($mailData));
        Mail::to($userEmail)->send(new DemoMail($mailData));
        session()->flash('success', 'Client information updated successfully.');

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = "Deleted {$client->name} appointment from Department: " . ucfirst($client->department) . " - {$client->sub_type}.";

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


             // Format the contact number to start with '639'
             $formattedContactNo = '639' . ltrim($client->contactNo, '0');
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
                  "message" => "Your appointment for " . strtoupper($client->type) . " {$client->sub_type} consultation has been rejected this time due to some reasons.\n\nWe apologize for the inconvenience. As an alternative, we are referring you to the following healthcare provider:\n {$client->refer} \n\nPlease reach out to them directly to book an appointment.",
              ]);
              // Check if SMS was sent successfully
              if ($smsResponse->successful()) {
                  \Log::info('SMS sent successfully to ' . $client->contactNo);
              } else {
                  \Log::error('SMS sending failed: ' . $smsResponse->body());
              }

        return redirect()->back();
    }

   public function reports()
   {
       if (auth()->user()->department !== 'CONSULTATION') {
           return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
       } else{

           $patients = RhuClient::where('type', 'consultation')->get();
           $blood_appointments = RhuAppointment::where('type', 'consultation')->get();

           return view('consultation.reports', compact('patients', 'blood_appointments'));
       }

   }

   public function con_staff_management()
   {
       if (auth()->user()->department !== 'CONSULTATION') {
           return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
       } else {

           $staffs = RhuUser::where('role', 'Admin')
               ->where('department', 'CONSULTATION')
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
           return view('consultation.staff_account', compact('staffs'));
       }

   }

       // for patient record
      public function con_patient_records()
      {
          if (auth()->user()->department !== 'CONSULTATION') {
              return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
          } else {
               $patients = RhuClient::where('type', 'consultation')
                   ->whereIn('status', ['Completed', 'Rejected'])
                   ->get();

               $appointments = RhuAppointment::where('type', 'consultation')
                   ->where('status', 'Approved')
                   ->get();

               return view('consultation.lab_patient_records', compact('patients','appointments'));
          }
      }

      public function add_con_patient_records(Request $request)
      {
          // Validate the form data without reason
          $validatedAttributes = $request->validate([
              'name'      => 'required|string|max:255',
              'sub_type'  => 'required|string|max:255',
              'doctor'    => 'required|string|max:255',
              'analysis'  => 'required|string|max:255',
              'status'    => 'required|string|in:Completed,Rejected',
          ]);
      
          // Fetch the corresponding appointment to get the reason
          $appointment = RhuAppointment::where('name', $request->name)
                            ->where('type', 'consultation')
                            ->first();
      
          // If the appointment is found, use its reason; otherwise, set a default message
          $validatedAttributes['reason'] = $appointment ? $appointment->reason : 'No reason provided';
      
          $validatedAttributes['date'] = now();
          $validatedAttributes['type'] = 'consultation';
      
          // Save the record including the reason
          $client = RhuClient::create($validatedAttributes);
      
          // Update matching appointments to mark them as Completed
          RhuAppointment::where('type', 'consultation')
              ->where('sub_type', $request->sub_type)
              ->whereIn('status', ['Pending', 'Approved'])
              ->update(['status' => 'Completed']);
      
          // Create activity log
          $user = Auth::user();
          $activityMessage = "Added {$client->name} appointment to Department: " . 
                              ucfirst($user->department) . " - {$client->sub_type}.";
      
          Logs::create([
              'user_id'    => $user->id,
              'name'       => $user->f_name . " " . $user->l_name,
              'department' => $user->department,
              'position'   => $user->role,
              'time_in'    => now(),
              'time_out'   => null,
              'activity'   => $activityMessage,
              'date'       => now(),
          ]);
      
          return redirect()->back()->with('success', 'Record added successfully!');
      }
      

      public function getSubType($name)
       {
           $appointment = RhuAppointment::where('name', $name)
               ->where('type', 'consultation')
               ->first();
           if ($appointment) {
            return response()->json([
                'sub_type' => $appointment->sub_type,
                'reason' => $appointment->reason,
            ]);

           }
           return response()->json(['error' => 'No data found'], 404);
       }


}
