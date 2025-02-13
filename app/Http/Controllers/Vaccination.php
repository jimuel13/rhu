<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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

class Vaccination extends Controller
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
            'dose_number' => 'required|max:255',
            'date' => 'required|string',
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
        $activityMessage = "{$user->f_name} {$user->l_name} Added new appointment to Department: " . ucfirst($user->department);

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

    public function reports()
    {
        if (auth()->user()->department !== 'VACCINATION') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{

            $patients = RhuClient::where('type', 'vaccination')->get();
            $blood_appointments = RhuAppointment::where('type', 'vaccination')->get();

            return view('vaccination.reports', compact('patients', 'blood_appointments'));
        }

    }


    public function vaccination()
    {
        if (auth()->user()->department !== 'VACCINATION') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        }  else{
            // Get the count of appointments with status 'Pending' or 'Approved'
            $totalMedicines = RhuSupply::where('type', 'Medicines')->count();
            $totalSupplies = RhuSupply::where('type', 'Medical Supplies')->count();
            $totalEquipments = RhuSupply::where('type', 'Medical Equipments')->count();
            $totalVaccines = RhuSupply::where('type', 'Vaccines')->count();


           $pendingCount = RhuAppointment::where('status', 'Pending')
               ->where('type', 'vaccination')
               ->count();
           $approvedCount = RhuAppointment::where('status', 'Approved')
               ->where('type', 'vaccination')
               ->count();

           $totalCount = $pendingCount + $approvedCount;
           $completedCount = RhuClient::where('status', 'Completed')
               ->where('type', 'vaccination')
               ->count();


            // Pass the counts and total to the view
            return view('vaccination.homepage', [
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

   public function display_vax_appointments()
   {
       if (auth()->user()->department !== 'VACCINATION') {
           return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
       } else{
           $vax_appointments = RhuAppointment::Where('type', 'vaccination')
               ->whereIn('status', ['Pending', 'Approved'])
               ->get();
           return view('vaccination.display_appointments', compact('vax_appointments'));
       }
   }

   public function vax_staff_management()
   {
       if (auth()->user()->department !== 'VACCINATION') {
           return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
       } else {

           $staffs = RhuUser::where('role', 'Admin')
               ->where('department', 'VACCINATION')
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
           return view('vaccination.staff_account', compact('staffs'));
       }

   }


       // for patient record
      public function vax_patient_records()
      {
          if (auth()->user()->department !== 'VACCINATION') {
              return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
          } else {
               $patients = RhuClient::where('type', 'vaccination')
                   ->whereIn('status', ['Completed', 'Rejected'])
                   ->get();

               $appointments = RhuAppointment::where('type', 'vaccination')
                   ->where('status', 'Approved')
                   ->get();

               return view('vaccination.lab_patient_records', compact('patients','appointments'));
          }
      }

      public function add_vax_patient_records(Request $request)
      {
          // Validate the form data
          $validatedAttributes = $request->validate([
               'name' => 'required|string|max:255',
               'sub_type' => 'required|string|max:255',
               'dose_number' => 'required|string|max:255',
               'status' => 'required|string|in:Completed,Rejected',

          ]);

           $validatedAttributes['date'] = now();
           $validatedAttributes['type'] = 'vaccination';

           // Save the data to RhuTest
           $client = RhuClient::create($validatedAttributes);


           RhuAppointment::where('type', 'vaccination')
                ->where('sub_type', $request->sub_type)
                ->whereIn('status', ['Pending', 'Approved'])
                ->update([
                    'status' => 'Completed',
                ]);


           $user = Auth::user();
           // Create a descriptive activity message
           $activityMessage = "{$client->name} Added to patient record. Department: " . ucfirst($user->department) . " - {$user->sub_type}.";

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
          return redirect()->back()->with('success', 'Record added successfully!');
      }

      public function getSubType($name)
       {
           $appointment = RhuAppointment::where('name', $name)
               ->where('type', 'vaccination')
               ->first();
           if ($appointment) {
               return response()->json(['sub_type' => $appointment->sub_type]);
           }
           return response()->json(['error' => 'No data found'], 404);
       }

}