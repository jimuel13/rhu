<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use App\Models\RhuUser;
use App\Models\RhuTest;
use App\Models\RhuSupply;
use App\Models\RhuAppointment;
use App\Models\RhuAnnouncement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
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
        $appointments = RhuAppointment::where('client_id', Auth::id())->get();
        $announcements = RhuAnnouncement::latest()
            // ->take(3)
            ->where('isShow', 'Yes')
            ->get();
        $tests = RhuTest::where('status', 'Available')->get();
        $vaccines = RhuSupply::where('type', 'Vaccines')
            ->where('quantity', '>', 0)
            ->get();


        return view('rhu.index', compact('appointments', 'announcements', 'tests', 'vaccines'));
    }

    public function client()
    {
        return view('client.homepage');
    }


    public function it_dept()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            return view('it_dept.homepage', ['currentDepartment' => $this->currentDepartment]);
        }

    }

    // registration_verification
    public function registration_verification()
    {
        if (auth()->user()->department !== 'IT DEPARTMENT') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            $clients = RhuUser::Where('role', 'Client')
            ->get()
            ->map(function($client) {
                // Format the 'bday' field as 'Y-m-d' (YYYY-MM-DD)
                $client->bday = Carbon::parse($client->bday)->format('Y-m-d');
                return $client;
            });

            // Return the view and pass the data to it
            return view('it_dept.registration_verification', compact('clients'));

        }

    }


     // Shared update
     public function client_account_update(Request $request, $pId)
     {
         $client = RhuUser::findOrFail($pId);

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
         ]);

         // Update the client's data
         $client->update($validatedData);

         $user = Auth::user();
         // Create a descriptive activity message
         $activityMessage = "Updated {$client->f_name} {$client->l_name} account ";

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

         return redirect()->back()->with('success', 'User Information Updated Successfully.');
     }

    public function client_account_destroy($pId){
        $client = RhuUser::where('id', $pId)->first();

        if ($client) {

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = "Deleted {$client->f_name} {$client->l_name} account ";

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

            $client->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Window not found.');
        }
    }

    // for edit profile
    public function edits()
    {
        $user = Auth::user();


        return view('edits', compact('user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedAttributes =  $request->validate([
            'profile_picture' => 'nullable',
            'f_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'l_name' => 'required|string|max:255',
            'bday' => 'required|date',
            'gender' => 'required|in:Male,Female,Prefer not to say',
            'contactNo' => 'required|string|max:15',

            'password' => 'nullable|min:8|confirmed',
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_user')->ignore($user->id),  // Ensure the username is unique, ignoring the current record
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('rhu_user')->ignore($user->id),  // Ensure the email is unique, ignoring the current record
            ],
        ], [
            'password.confirmed' => 'The password confirmation does not match.', // Custom error message for confirmation mismatch
        ]);


        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filePath = $file->store('profile_pictures', 'public');
            $validatedAttributes['profile_picture'] = $filePath;
        }

        // Hash password only if provided
        if ($request->filled('password')) {
            $validatedAttributes['password'] = Hash::make($request->input('password'));
        } else {
            unset($validatedAttributes['password']); // Remove password field if empty
        }

        // Update the user's profile with validated data
        $user->update($validatedAttributes);

        // Set a session message for SweetAlert
        session()->flash('success', 'Account Updated.');

        // Redirect after updating the user
        return redirect()->back();
    }

    public function update_edit_profile(Request $request)
    {
        $user = Auth::user();

        $validatedAttributes =  $request->validate([
            'profile_picture' => 'nullable',
            'f_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'l_name' => 'required|string|max:255',

            'address' => 'nullable|string|max:255',
            'bday' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Prefer not to say',
            'contactNo' => 'nullable|string|max:15',

            'password' => 'nullable|min:8|confirmed',
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_user')->ignore($user->id),  // Ensure the username is unique, ignoring the current record
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('rhu_user')->ignore($user->id),  // Ensure the email is unique, ignoring the current record
            ],
        ], [
            'password.confirmed' => 'The password confirmation does not match.', // Custom error message for confirmation mismatch
        ]);


        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filePath = $file->store('profile_pictures', 'public');
            $validatedAttributes['profile_picture'] = $filePath;
        }

        // Hash password only if provided
        if ($request->filled('password')) {
            $validatedAttributes['password'] = Hash::make($request->input('password'));
        } else {
            unset($validatedAttributes['password']); // Remove password field if empty
        }

        // Update the user's profile with validated data
        $user->update($validatedAttributes);

        // Set a session message for SweetAlert
        session()->flash('success', 'Account Updated.');

        // Redirect after updating the user
        return redirect()->back();
    }



}
