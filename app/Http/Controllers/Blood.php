<?php

namespace App\Http\Controllers;
use App\Models\RhuUser;
use App\Models\Logs;
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
use App\Models\RhuTurnedOver;
use App\Models\RhuBloodType;
use App\Models\RhuMedicalHistory;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;

class Blood extends Controller
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
        // for blood appointment

        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|string|max:255',
            'sub_type' => 'required|string|max:255',
            'date' => 'required|string',
            // 'contactNo' => 'required|string|max:15',
        ]);

        $formattedDate = Carbon::createFromFormat('Y-m-d h:i A', $request->date)->format('Y-m-d H:i:s');

        $existingAppointment = RhuAppointment::where('client_id', Auth::id())
            ->where('type', $request->type)
            ->where('sub_type', $request->sub_type)
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



        // for medical history
        $validatedAttributes = $request->validate([
            'well_health' => 'required|string|max:255',
            'antibiotics' => 'required|string|max:255',
            'infection_medication' => 'nullable|string|max:255',
            'medication_deferral' => 'required|string|max:255',
            'aspirin' => 'required|string|max:255',
            'vaccinations' => 'nullable|string|max:255',
            'pregnant' => 'required|string|max:255',
            'donated_recently' => 'required|string|max:255',
            'apheresis' => 'nullable|string|max:255',
            'blood_transfusion' => 'required|string|max:255',
            'transplant' => 'required|string|max:255',

            'graft' => 'required|string|max:255',
            'contact_blood' => 'required|string|max:255',
            'needlestick_injury' => 'nullable|string|max:255',
            'sexual_contact_hiv' => 'required|string|max:255',
            'prostitute_contact' => 'required|string|max:255',
            'drug_use_contact' => 'nullable|string|max:255',
            'hemophilia_contact' => 'required|string|max:255',
            'male_contact_with_male' => 'required|string|max:255',
            'saliva_contact_hepatitis' => 'nullable|string|max:255',
            'contact_blood_hepatitis' => 'required|string|max:255',
            'sexual_contact_hepatitis' => 'required|string|max:255',

            'tattoo' => 'required|string|max:255',
            'piercing' => 'required|string|max:255',
            'acupuncture' => 'nullable|string|max:255',
            'syphilis_gonorrhea' => 'required|string|max:255',
            'juvenile_detention' => 'required|string|max:255',
            'hiv_aids_positive' => 'nullable|string|max:255',
            'used_needles' => 'required|string|max:255',
            'clotting_factor' => 'required|string|max:255',
            'hepatitis' => 'nullable|string|max:255',
            'malaria' => 'required|string|max:255',
            'chagas' => 'required|string|max:255',
            'babesiosis' => 'required|string|max:255',

        ]);

        // Add the client_id to the validated attributes
        $validatedAttributes['client_id'] = Auth::id();

        // Update or create the medical history record for the client
        RhuMedicalHistory::updateOrCreate(
            ['client_id' => $validatedAttributes['client_id']],
            $validatedAttributes
        );

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

    public function blood()
    {
        if (auth()->user()->department !== 'BLOOD') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            // Get the count of appointments with status 'Pending' or 'Approved'
            $totalMedicines = RhuSupply::where('type', 'Medicines')->count();
            $totalSupplies = RhuSupply::where('type', 'Medical Supplies')->count();
            $totalEquipments = RhuSupply::where('type', 'Medical Equipments')->count();
            $totalVaccines = RhuSupply::where('type', 'Vaccines')->count();


           $pendingCount = RhuAppointment::where('status', 'Pending')
               ->where('type', 'blood')
               ->count();
           $approvedCount = RhuAppointment::where('status', 'Approved')
               ->where('type', 'blood')
               ->count();

           $totalCount = $pendingCount + $approvedCount;
           $completedCount = RhuClient::where('status', 'Completed')
               ->where('type', 'blood')
               ->count();

               $bloodTypes = RhuBloodType::all();
            // Pass the counts and total to the view
            return view('blood.homepage', [
                'totalMedicines' => $totalMedicines,
                'totalSupplies' => $totalSupplies,
                'totalEquipments' => $totalEquipments,
                'totalVaccines' => $totalVaccines,

                'pendingCount' => $pendingCount,
               'approvedCount' => $approvedCount,
               'totalCount' => $totalCount,
               'completedCount' => $completedCount,
                'currentDepartment' => $this->currentDepartment,
                'bloodTypes' => $bloodTypes
            ]);
        }


    }

    public function reports()
    {
        if (auth()->user()->department !== 'BLOOD') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            $turned_overs = RhuTurnedOver::all();
            $patients = RhuClient::where('type', 'blood')->get();
            $blood_appointments = RhuAppointment::where('type', 'blood')->get();

            return view('blood.reports', compact('turned_overs', 'patients', 'blood_appointments'));
        }

    }

    public function display_blood_appointments()
    {
        if (auth()->user()->department !== 'BLOOD') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
                $blood_appointments = RhuAppointment::Where('type', 'blood')
                ->whereIn('status', ['Pending', 'Approved'])
                ->get();
                $medical_history = RhuMedicalHistory::all();

            return view('blood.display_appointments', compact('blood_appointments', 'medical_history'));
        }
    }

    public function blood_staff_management()
    {
        if (auth()->user()->department !== 'BLOOD') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $staffs = RhuUser::where('role', 'Admin')
                ->where('department', 'BLOOD')
                ->get()
                ->map(function($staff) {
                    // Format 'bday' if it exists
                    if ($staff->bday) {
                        $staff->bday = Carbon::parse($staff->bday)->format('Y-m-d');
                    }
                    return $staff;
                })
                ->sortBy('created_at');

            // Return the view and pass both clients and staff data to it
            return view('blood.staff_account', compact('staffs'));
        }

    }

       // for patient record
    public function blood_patient_records()
    {
          if (auth()->user()->department !== 'BLOOD') {
              return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
          } else {
               $patients = RhuClient::where('type', 'blood')
                   ->whereIn('status', ['Completed', 'Rejected'])
                   ->get();

               $appointments = RhuAppointment::where('type', 'blood')
                   ->where('status', 'Approved')
                   ->get();

               return view('blood.lab_patient_records', compact('patients','appointments'));
          }
    }

    public function add_blood_patient_records(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'name' => 'required|string|max:255',
            'sub_type' => 'required|string|max:255',
            'volume' => 'required|integer|min:1|max:99999',
            'status' => 'required|string|max:255',
        ]);

        // dd($validatedAttributes);
        // Convert volume to an integer
        $volume = (int)$validatedAttributes['volume'];

        // Find the blood type record based on sub_type
        $bloodTypeRecord = RhuBloodType::where('blood_type', $request->sub_type)->first();

        if (!$bloodTypeRecord) {
            // If the blood type does not exist, create a new record
            $bloodTypeRecord = RhuBloodType::create([
                'blood_type' => $request->sub_type,
                'total' => $volume,
                'current' => $volume,
                'turned_over' => 0,
            ]);
        } else {
            // Update the total and current fields
            $bloodTypeRecord->total += $volume;
            $bloodTypeRecord->current += $volume;
            $bloodTypeRecord->save();
        }

        // Add additional attributes
        $validatedAttributes['date'] = now();
        $validatedAttributes['type'] = 'blood';

        // Save the data to RhuClient
        RhuClient::create($validatedAttributes);

            RhuAppointment::where('type', 'blood')
            ->where('sub_type', $request->sub_type)
            ->whereIn('status', ['Pending', 'Approved'])
            ->update([
                'status' => 'Completed',
            ]);

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = "New patient record added";

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

        // Redirect after successful creation
        return redirect()->back()->with('success', 'Blood patient record created successfully.');
    }

    public function getSubType($name)
    {
           $appointment = RhuAppointment::where('name', $name)
               ->where('type', 'blood')
               ->first();
           if ($appointment) {
               return response()->json(['sub_type' => $appointment->sub_type]);
           }
           return response()->json(['error' => 'No data found'], 404);
    }

    // for turned over
    public function turned_overs()
    {
        if (auth()->user()->department !== 'BLOOD') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            $turned_overs = RhuTurnedOver::all();
            return view('blood.turned_over', compact('turned_overs'));
        }

    }

    public function add_turned_overs(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'blood_type' => 'required|string|max:255',
            'volume' => 'required|integer|min:1', // Ensure volume is an integer
        ]);

        // Convert volume to an integer
        $requestedVolume = (int)$validatedAttributes['volume'];

        // Check if the blood type exists in RhuBloodType
        $bloodTypeRecord = RhuBloodType::where('blood_type', $request->blood_type)->first();

        if (!$bloodTypeRecord) {
            // If the blood type does not exist, return an error
            return redirect()->back()->withErrors(['blood_type' => 'Selected blood type is not available.']);

        }

        // Check if the requested volume exceeds the current stock
        if ($requestedVolume > $bloodTypeRecord->current) {
            // If insufficient stock, return an error
            return redirect()->back()->withErrors([
                'volume' => 'Insufficient stock for the requested blood volume.',
            ]);
        }

        // Deduct the requested volume from the current stock
        $bloodTypeRecord->current -= $requestedVolume;
        $bloodTypeRecord->turned_over += $requestedVolume; // Update the turned_over field
        $bloodTypeRecord->save();

        // Add the hardcoded role value
        $validatedAttributes['type'] = 'blood';

        // Create a new turned-over record
        $turned = RhuTurnedOver::create($validatedAttributes);

        // Flash success message to the session
        session()->flash('success', 'Turned over record created successfully.');

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = "Turned over {$turned->name} {$turned->blood_type} ";

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
        // Redirect after successful creation
        return redirect()->back();
    }

    public function delete_turned_overs($id)
    {
        try {
            $turned_overs = RhuTurnedOver::findOrFail($id);

            $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = "Deleted turned over {$turned->name} {$turned->blood_type} ";

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

            $turned_overs->delete();

            session()->flash('success', 'Medical Supplies delete successfully.');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
