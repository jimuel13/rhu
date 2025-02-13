<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\{
    Department, DmsUserDepts, DmsDepartment, Logs
};

class SessionController extends Controller{

    public function create(){
        return view('auth.login');
    }

    public function store()
    {
        $validatedAttributes = request()->validate([
            'username' => ['required'],
            'password' => [
                'required',
                'string',
                'min:8',             // Minimum 8 characters
                'regex:/[a-z]/',     // At least one lowercase letter
                'regex:/[A-Z]/',     // At least one uppercase letter
                'regex:/[0-9]/',     // At least one digit
                'regex:/[@$!%*?&#]/' // At least one special character
            ],
        ]);

        $user = Auth::attempt([
            'username' => $validatedAttributes['username'],
            'password' => $validatedAttributes['password'],
        ]);

        if (!Auth::attempt($validatedAttributes)) {
            return back()->withErrors([
                'username' => 'Sorry, credentials do not match',
            ])->onlyInput('username');
        }

        request()->session()->regenerate();

            $user = Auth::user();
            $currentRhuUser = \App\Models\RhuUser::where('id', $user->id)->first();
            session(['currentDepartment' => $currentRhuUser->department]);
            session(['currentRole' => $currentRhuUser->role]);

            $existingLog = Logs::where('user_id', $user->id)
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
                        'activity' => "Login",
                        'date' => now(),
                    ]);
                }


        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's status is 'Approved' or 'Active'
            if ($user->status === 'Approved' || $user->status === 'Active') {
                // Check the user's role and department to handle redirection
                if ($user->role === 'Client') {
                    return redirect('/');
                } elseif ($user->department === 'IT DEPARTMENT') {
                    return redirect('/it_dept');
                } elseif ($user->department === 'SUPER ADMIN') {
                    return redirect('/super_admin');
                } elseif ($user->department === 'INVENTORY') {
                    return redirect('/inventory');
                } elseif ($user->department === 'LABORATORY') {
                    return redirect('/laboratory');
                } elseif ($user->department === 'CONSULTATION') {
                    return redirect('/consultation');

                } elseif ($user->department === 'VACCINATION') {
                    return redirect('/vaccination');
                } elseif ($user->department === 'BLOOD') {
                    return redirect('/blood');
                }


                else {
                    return redirect('/');
                }
            } else {
                // If the user is not 'Approved' or 'Active', return a redirect with SweetAlert
                return redirect()->route('login')->with('status', 'Your account is pending for verification!');
            }
        }



        // Handle case when user is not authenticated
        return redirect('/login');
    }

    public function destroy()
    {
        Logs::where('user_id', Auth::user()->id)
            ->where('time_out', NULL)
            ->update(['time_out' => now()]);

        // Destroy all sessions for the user
        $userId = Auth::user()->getAuthIdentifier();
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('id', $userId)
            ->delete();

        // Log out the current session
        Auth::logout();

        // Regenerate the session to prevent session fixation attacks
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
