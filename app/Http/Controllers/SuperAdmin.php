<?php

namespace App\Http\Controllers;
use App\Models\RhuUser;
use App\Models\RhuClient;
use App\Models\RhuAnnouncement;
use App\Models\RhuAppointment;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuperAdmin extends Controller
{
    protected $currentDepartment;
    protected $currentRole;

    public function __construct()
    {
        $this->currentDepartment = session('currentDepartment');
        $this->currentRole = session('currentRole');
    }

    public function super_admin()
    {
        if (auth()->user()->department !== 'SUPER ADMIN') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
              // Get the count of appointments with status 'Pending' or 'Approved'
              $totalConsultation = RhuAppointment::where('type', 'consultation')->count();
              $totalVaccination = RhuAppointment::where('type', 'vaccination')->count();
              $totalLaboratory = RhuAppointment::where('type', 'laboratory')->count();
              $totalBlood = RhuAppointment::where('type', 'blood')->count();

              // Pass the counts and total to the view
              return view('super_admin.homepage', [
                  'totalConsultation' => $totalConsultation,
                  'totalVaccination' => $totalVaccination,
                  'totalLaboratory' => $totalLaboratory,
                  'totalBlood' => $totalBlood,
                  'currentDepartment' => $this->currentDepartment
              ]);

        }

    }

    public function super_patient()
    {
        if (auth()->user()->department !== 'SUPER ADMIN') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{
            $patients = RhuClient::all();

            return view('super_admin.super_patient', compact('patients'));

        }

    }

    // registration_verification
    public function announcement()
    {
        if (auth()->user()->department !== 'SUPER ADMIN') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            $announcements = RhuAnnouncement::orderBy('created_at', 'asc')->get()
                ->map(function($announcement) {
                    // Format 'date' if it exists
                    if ($announcement->date) {
                        $announcement->date = Carbon::parse($announcement->date)->format('Y-m-d');
                    }
                    return $announcement;
                });

            return view('super_admin.announcement', compact('announcements'));
        }
    }

    public function announcement_store(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'fullcontext' => ['required', 'string'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle file upload for the image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('images', 'public');
            $validatedAttributes['image'] = $filePath;
        }

        $validatedAttributes['isShow'] = "Yes";
        // Create a new announcement record
        $announcement = RhuAnnouncement::create($validatedAttributes);

        $user = Auth::user();

        $activityMessage = "{$user->f_name} {$user->l_name} Added new announcement. Title: {$announcement->title}";
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

        // Redirect after creating the announcement
        return redirect()->back()->with('success', 'Announcement created successfully.');
    }

    public function deleteAnnouncement($id)
    {
        try {
            $announcement = RhuAnnouncement::findOrFail($id);
            $announcement->delete();
            // Set a session message for SweetAlert

            $user = Auth::user();

            $activityMessage = "{$user->f_name} {$user->l_name} Delete announcement. Title: {$announcement->title}";

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

    public function updateAnnouncement(Request $request, $pId)
    {
        $announcement = RhuAnnouncement::findOrFail($pId);

        $validatedAttributes = $request->validate([
            'editTitle' => ['required', 'string', 'max:255'],
            'editFullcontext' => ['required', 'string'],
            'editDate' => ['required', 'date'],
            'editDescription' => ['required', 'string'],
            'editImage' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'editIsShow' => ['required', 'string'],

        ]);

        // Map the validated attributes to the expected keys
        $mappedAttributes = [
            'title' => $validatedAttributes['editTitle'],
            'fullcontext' => $validatedAttributes['editFullcontext'],
            'date' => $validatedAttributes['editDate'],
            'description' => $validatedAttributes['editDescription'],
            'image' => $request->hasFile('editImage') ? $validatedAttributes['editImage'] : $announcement->image,
            'isShow' => $validatedAttributes['editIsShow'],
        ];

       // Handle file upload for the image
       if ($request->hasFile('editImage')) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }

            // Store the new image
            $file = $request->file('editImage');
            $filePath = $file->store('images', 'public');
            $mappedAttributes['image'] = $filePath;
        }

        // Update the announcement's data
        $announcement->update($mappedAttributes);

        $user = Auth::user();

        $activityMessage = "{$user->f_name} {$user->l_name} Updated announcement";
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




        // Set a session message for SweetAlert
        session()->flash('success', 'Announcement updated successfully.');

        return redirect()->back();
    }

    public function super_admin_staff_account()
    {
        if (auth()->user()->department !== 'SUPER ADMIN') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $staffs = RhuUser::where('role', 'Admin')
                // ->where('department', 'SUPER ADMIN')
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
            return view('super_admin.staff_account', compact('staffs'));
        }

    }

    public function appointments()
    {
        if (auth()->user()->department !== 'SUPER ADMIN') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $appointments = RhuAppointment::all();

            return view('super_admin.appointments', compact('appointments'));

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

}
