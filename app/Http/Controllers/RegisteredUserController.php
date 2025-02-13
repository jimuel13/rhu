<?php
namespace App\Http\Controllers;
use App\Models\Logs;
use App\Models\RhuUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;


class RegisteredUserController extends Controller
{
    // Show the registration form
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedAttributes = $request->validate([
            'f_name' => ['nullable', 'string', 'max:255'],
            'm_name' => ['nullable', 'string', 'max:255'],
            'l_name' => ['nullable', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'bday' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,prefer-not-say'],
            'contactNo' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'brgy' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:10'],
            'municipality' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:rhu_user,email'],
            'username' => ['required', 'string', 'max:255', 'unique:rhu_user,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'This email is already registered.',
            'username.unique' => 'This username is already taken.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        // Handle file upload for the residential ID
        if ($request->hasFile('upload_id')) {
            $file = $request->file('upload_id');
            $filePath = $file->store('uploads', 'public');
            $validatedAttributes['upload_id'] = $filePath;
        }

        // Add default values for department, status, and role
        $validatedAttributes['department'] = "Client";
        $validatedAttributes['status'] = "Pending";
        $validatedAttributes['role'] = "Client";

        // Hash the password before saving
        $validatedAttributes['password'] = Hash::make($validatedAttributes['password']);

        // Create the user
        $user = RhuUser::create($validatedAttributes);

        // Log the user in
        Auth::login($user);

        // Flash success message
        session()->flash('success', 'Registration successful!');



        $user = Auth::user();

        // Create a descriptive activity message
        $activityMessage = " {$user->f_name} {$user->l_name} successfully registered: ";


            Logs::create([
                'user_id' => $user->id,
                'name' => $user->f_name . " " . $user->l_name,
                'department' => $user->department,
                'position' => $user->role,
                'time_in' => now(),
                'time_out' => now(),
                'activity' => $activityMessage,
                'date' => now(),
            ]);



        // Redirect to the login page
        return redirect('/login');
    }


    public function forgot_password()
    {
        return view('auth.forgot');
    }










}
