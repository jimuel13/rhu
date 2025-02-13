<?php

namespace App\Http\Controllers;
use App\Models\RhuUSer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\RhuAppointment;
use Illuminate\Support\Facades\Auth;
use App\Models\RhuClient;
use App\Models\Logs;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\DemoMail;
use App\Mail\AccountApproved;

class ITDepartment extends Controller
{
    protected $currentDepartment;
    protected $currentRole;

    public function __construct()
    {
        $this->currentDepartment = session('currentDepartment');
        $this->currentRole = session('currentRole');
    }

    public function index()
    {
        // return view('rhu.index', ['current_department_name' => $this->currentDepartment]);
        return view('rhu.index');
    }

    public function it_dept()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            // Get the count of appointments with status 'Pending' and 'Approved'
            $pendingCount = RhuUser::where('status', 'Pending')->count();
            $approvedCount = RhuUSer::where('status', 'Approved')->count();
    
            // Calculate the total for Pending and Approved
            
    
            // Get the count of admin users
            $adminCount = RhuUser::where('role', 'admin')->count(); // Adjust `role` and value if needed
            $totalCount = $adminCount + $approvedCount;
            // Pass the counts to the view
            return view('it_dept.homepage', [
                'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount,
                'totalCount' => $totalCount,
                'adminCount' => $adminCount,
                'currentDepartment' => $this->currentDepartment
            ]);

        }

    }

    public function logs()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{

            $logs = Logs::orderBy('created_at', 'desc')->get();

            // Pass the counts and total to the view
            return view('it_dept.logs', [
                'logs' => $logs,

            ]);

        }

    }

    public function user_account()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            // Fetch Clients where role is 'Client' and status is 'Approved'
            $clients = RhuUser::where('role', 'Client')
                ->where('status', 'Approved')
                ->get()
                ->map(function($client) {
                    // Format 'bday' if it exists
                    if ($client->bday) {
                        $client->bday = Carbon::parse($client->bday)->format('Y-m-d');
                    }
                    return $client;
                })
                ->sortBy('created_at');  // Sorting clients by 'created_at' in ascending order
            return view('it_dept.user_account', compact('clients'));
        }

    }

    public function staff_store(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'f_name' => ['required'],
            'l_name' => ['required'],
            'm_name' => ['required'],
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_user')->ignore($request->id),  // Ensure the username is unique, ignoring the current record
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('rhu_user')->ignore($request->id),  // Ensure the email is unique, ignoring the current record
            ],
            'password' => ['required', 'min:6', 'confirmed'], // Add 'confirmed' rule for password confirmation
            'department' => ['required'],
            'status' => ['required'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.', // Custom error message for confirmation mismatch
        ]);
        // dd($validatedAttributes);

        // Add the hardcoded role value
        $validatedAttributes['role'] = 'Admin';  // Add the role to validated attributes

         // Hash the password before storing it
        $validatedAttributes['password'] = Hash::make($request->input('password'));
        // Create a new user record

        $newUser = RhuUser::create($validatedAttributes);

        $user = Auth::user();
        $existingLog = Logs::where('id', $user->id)
            ->whereNull('time_out')
            ->first();

        // Create a descriptive activity message
        $activityMessage = "Added new admin: {$newUser->f_name} {$newUser->l_name}, Username: {$newUser->username}, Email: {$newUser->email}, Department: {$newUser->department}.";

        if (!$existingLog) {
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
        } else {
            // Update existing log activity instead of skipping
            $existingLog->update([
                'activity' => $existingLog->activity . " | " . $activityMessage,
            ]);
        }


        // Set a session message for SweetAlert
        session()->flash('success', 'Admin created successfully.');

        // Redirect after creating the user
        return redirect()->back();
    }

    public function staff_account()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $staffs = RhuUser::where('role', 'Admin')
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
            return view('it_dept.staff_account', compact('staffs'));
        }

    }

    public function approveClient(Request $request, $id)
    {
        try {
            $client = RhuUser::findOrFail($id);
            $client->status = 'Approved';
            $client->save();


            $user = Auth::user();
            $existingLog = Logs::where('id', $user->id)
                ->whereNull('time_out')
                ->first();

            // Create a descriptive activity message
            $activityMessage = "Approved patient account: {$client->f_name} {$client->l_name}";

            if (!$existingLog) {
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
            } else {
                // Update existing log activity instead of skipping
                $existingLog->update([
                    'activity' => $existingLog->activity . " | " . $activityMessage,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function email(Request $request, $id)
    {
        $client = RhuUser::findOrFail($id);
        $type = strtolower(auth()->user()->department);

        try {
            $account_mail_data_approved = [
                'title' => 'RHU Lucban',
                'client' => "{$client->f_name} {$client->l_name}",
                'body' => "Congratulations! We are pleased to inform you that your account registration request has been approved. You can now log in and access all the features available on eHealth Lucban.",
            ];

           
            Mail::to($client->email)->send(new AccountApproved($account_mail_data_approved));

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }


    // registration_verification
    public function registration_verification()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access Denied! You do not have the required permissions.');
        } else{
            $clients = RhuUser::Where('role', 'Client')
                ->whereNot('status', 'Approved')
                ->get()
                ->map(function($client) {
                    // Format the 'bday' field as 'Y-m-d' (YYYY-MM-DD)
                    $client->bday = Carbon::parse($client->bday)->format('Y-m-d');
                    return $client;
                })
                ->sortBy('created_at');  // Sorting by 'created_at' in ascending order


            // Return the view and pass the data to it
            return view('it_dept.registration_verification', compact('clients'));


        }

    }

     // Shared update
     public function client_account_update(Request $request, $pId)
     {
         $client = RhuUser::findOrFail($pId);

         $user = Auth::user();

         // Check if the authenticated user is trying to update their own account
         if ($user->id == $client->id) {
             $request->merge([
                 'status' => $client->status,       // Keep the original value
                 'username' => $client->username,   // Keep the original value
                 'department' => $client->department // Keep the original value
             ]);
         }

         // Validate the input
         $validatedData = $request->validate([
             'f_name' => 'required|string|max:255',
             'm_name' => 'nullable|string|max:255',
             'l_name' => 'required|string|max:255',
             'suffix' => 'nullable|string|max:10',
             'bday' => 'nullable|date',
             'contactNo' => 'nullable|string|max:15',
             'gender' => 'nullable|string|max:15',
             'email' => 'nullable|email|max:255',
             'street' => 'nullable|string|max:255',
             'brgy' => 'nullable|string|max:255',
             'municipality' => 'nullable|string|max:255',
             'province' => 'nullable|string|max:255',
             'zip_code' => 'nullable|string|max:10',
             'status' => 'nullable|string|max:255',
             'username' => [
                 'nullable',
                 'string',
                 'max:255',
                 Rule::unique('rhu_user')->ignore($client->id),
             ],
             'department' => 'nullable|string|max:255',
         ]);



          // Track changes before update
        $changes = [];
        foreach ($validatedData as $key => $value) {
            if ($client->$key != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " updated from '{$client->$key}' to '{$value}'";
            }
        }


         // Update the client's data
         $client->update($validatedData);

         $user = Auth::user();
         $existingLog = Logs::where('id', $user->id)
             ->whereNull('time_out')
             ->first();

             if (!$existingLog) {
                Logs::create([
                    'user_id' => $user->id,
                    'name' => $user->f_name . " " . $user->l_name,
                    'department' => $user->department,
                    'position' => $user->role,
                    'time_in' => now(),
                    'time_out' => null,
                    'activity' => count($changes) > 0
                        ? "Updated staff account: " . implode(", ", $changes)
                        : "Updated staff account (no changes)",
                    'date' => now(),
                ]);
            }


         // Set a session message for SweetAlert
         session()->flash('success', 'Updated successfully.');

         return redirect()->back();
     }

    public function deleteClient($id)
    {
        try {
            $client = RhuUser::findOrFail($id);
            $client->delete();
            // Set a session message for SweetAlert
            session()->flash('success', 'User Deleted Successfully.');

            $user = Auth::user();
            $existingLog = Logs::where('id', $user->id)
                ->whereNull('time_out')
                ->first();

            // Create a descriptive activity message
            $activityMessage = "Deleted user: {$client->f_name} {$client->l_name}, Department: {$client->department}.";

            if (!$existingLog) {
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
            } else {
                // Update existing log activity instead of skipping
                $existingLog->update([
                    'activity' => $existingLog->activity . " | " . $activityMessage,
                ]);
            }












            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
