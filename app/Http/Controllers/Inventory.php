<?php

namespace App\Http\Controllers;
use App\Models\RhuUser;
use App\Models\RhuAnnouncement;
use App\Models\RhuAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\RhuSupply;
use App\Models\RhuMedicine;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;

class Inventory extends Controller
{
    protected $currentDepartment;
    protected $currentRole;

    public function __construct()
    {
        $this->currentDepartment = session('currentDepartment');
        $this->currentRole = session('currentRole');
    }


    public function reports()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else{

            $medicines = RhuSupply::where('type', 'Medicines')->get();
            $medicalSupplies = RhuSupply::where('type', 'Medical Supplies')->get();
            $medicalEquipments = RhuSupply::where('type', 'Medical Equipments')->get();
            $vaccines = RhuSupply::where('type', 'Vaccines')->get();


            return view('inventory.reports', compact('medicalSupplies', 'medicines', 'medicalEquipments', 'vaccines'));
        }

    }

    //inventory homepage
    public function inventory()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            // Get the count of appointments with status 'Pending' or 'Approved'
            $totalMedicines = RhuSupply::where('type', 'Medicines')->count();
            $totalSupplies = RhuSupply::where('type', 'Medical Supplies')->count();
            $totalEquipments = RhuSupply::where('type', 'Medical Equipments')->count();
            $totalVaccines = RhuSupply::where('type', 'Vaccines')->count();

            // Pass the counts and total to the view
            return view('inventory.homepage', [
                'totalMedicines' => $totalMedicines,
                'totalSupplies' => $totalSupplies,
                'totalEquipments' => $totalEquipments,
                'totalVaccines' => $totalVaccines,
                'currentDepartment' => $this->currentDepartment
            ]);

      }

    }

    public function inventory_staff_management()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $staffs = RhuUser::where('role', 'Admin')
                ->where('department', 'INVENTORY')
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
            return view('inventory.staff_account', compact('staffs'));
        }

    }

    // display medicine

    public function medicines()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {
            $medicines = RhuSupply::where('type', 'Medicines')->get()
                ->map(function ($medicine) {
                    // Format 'expiration_date' if it exists
                    if ($medicine->expiration_date) {
                        $medicine->expiration_date = Carbon::parse($medicine->expiration_date)->format('Y-m-d');
                    }
                    return $medicine;
                });  // <-- Missing semicolon added here

            return view('inventory.medicines', compact('medicines'));
        }
    }


    // add medicine
    public function add_medicines(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'name' => 'required|string|max:255',
            'dosage_f' => 'nullable|string|max:255',
            'dosage_s' => 'required|string|max:255',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',
            'expiration_date' => 'nullable|date',
            'end_user' => 'nullable|string|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies')->ignore($request->id),
            ],

        ]);

        // Add the hardcoded role value
        $validatedAttributes['type'] = 'Medicines';

        // Create a new user record
        $x= RhuSupply::create($validatedAttributes);

         // Find the medicine record based on name and dosage
        $medicineRecord = RhuMedicine::where('name', $request->name)
            ->first();

        if (!$medicineRecord) {
            // If the medicine does not exist, create a new record
            $medicineRecord = RhuMedicine::create([
                'name' => $request->name,
                'total' => $request->quantity,
                'current' => $request->quantity,

            ]);
        } else {
            // Update the total and current fields
            $medicineRecord->total += $quantity;
            $medicineRecord->current += $quantity;
            $medicineRecord->save();
        }

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = " Added new medicine name:{$x->name} ";
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
        return redirect()->back()->with('success', 'New medicine added successfully.');
    }

     // update medicine
     public function update_medicines(Request $request, $pId)
     {
         $supplies = RhuSupply::findOrFail($pId);
         $previousCurrent = $supplies->quantity;

         // Validate the input
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'dosage_f' => 'nullable|string|max:255',
             'dosage_s' => 'required|string|max:255',
             'location_code' => 'nullable|string|max:10',
             'quantity' => 'required|string|max:255',
             'expiration_date' => 'nullable|date',
             'end_user' => 'nullable|string|max:255',

             'name' => [
                 'nullable',
                 'string',
                 'max:255',
                 Rule::unique('rhu_supplies')->ignore($supplies->id), // Exclude current user's username
             ],

         ]);

         $newQuantity = $supplies->quantity + $validatedData['quantity'];
         $validatedData['quantity'] = $newQuantity; // Update the quantity field
         $supplies->update($validatedData); // Save changes
         

        // update the medicine and supply (medicine)
        $med = RhuMedicine::where('name', $supplies->name)->first();

        $currentDifference = abs($supplies->quantity - $previousCurrent);

        $med->update(['current' => $supplies->quantity]);

        $currentDifference = abs($supplies->quantity - $previousCurrent);

        if ($supplies->quantity > $previousCurrent) {
            $med->update(['total' => $med->total + $currentDifference]);
        } else {
            $med->update(['total' => $med->total - $currentDifference]);
        }



         $user = Auth::user();
         // Create a descriptive activity message
         $activityMessage = " Updated medicine";
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

         session()->flash('success', 'Medicine added successfully.');

         return redirect()->back();
     }

     public function update_medicines1(Request $request, $pId)
     {
         // Find the supply record
         $supply = RhuSupply::findOrFail($pId);

         // Validate the input
         $validatedData = $request->validate([
             'quantity' => 'required|min:1|max:99999',
         ]);

         // Check if requested quantity is greater than available stock
         if ($request->quantity >  $supply->quantity) {
             return redirect()->back()->with('error', 'Insufficient stock. Available: ' . $supply->current);
         }


         // Find the corresponding medicine in RhuMedicine
        $medicine = RhuMedicine::where('name', $supply->name)
            ->first();

        if (!$medicine) {
            return redirect()->back()->with('error', 'Medicine record not found.');
        }

         // Deduct the quantity from current stock
         $supply->quantity -= $request->quantity;
         $supply->save();

         $medicine->current -= $request->quantity;
         $medicine->turned_over += $request->quantity;
         $medicine->save();


         $user = Auth::user();
         // Create a descriptive activity message
         $activityMessage = " Updated medicine";
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


         session()->flash('success', 'Medicine information updated successfully.');

         return redirect()->back();
     }

    //  delete medicine
     public function delete_medicines($id)
    {
        try {
            $supplies = RhuSupply::findOrFail($id);

            // Check if the type is 'Medicines'
            if ($supplies->type === 'Medicines') {
                // Delete the RhuMedicine record where the name matches $supplies->name
                RhuMedicine::where('name', $supplies->name)->delete();
            }


            $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = " Deleted {$supplies->name} medicine";
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
                $supplies->delete();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    ################ Medical Supplies ########################

    public function medical_supplies()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $medical_supplies = RhuSupply::where('type', 'Medical Supplies')->get();
            return view('inventory.medical_supplies', compact('medical_supplies'));
        }

    }

    public function add_medical_supplies(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([
            'name' => 'required|string|max:255',
            'batchNo' => 'nullable|string|max:255',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies'), // Exclude current user's username
            ],

        ]);

        // Add the hardcoded role value
        $validatedAttributes['type'] = 'Medical Supplies';

        // Create a new user record
        $supplies = RhuSupply::create($validatedAttributes);



        $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = " Added {$supplies->name}, {$supplies->type} ";
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
        return redirect()->back()->with('success', 'New medical supply added successfully.');
    }

     public function update_medical_supplies(Request $request, $pId)
     {
         $medical_supplies = RhuSupply::findOrFail($pId);

         // Validate the input
         $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'batchNo' => 'nullable|string|max:255',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies')->ignore($medical_supplies->id), // Exclude current user's username
            ],

         ]);

         $medical_supplies->update($validatedData);

         $user = Auth::user();
         // Create a descriptive activity message
         $activityMessage = " Updated {$medical_supplies->name}, {$medical_supplies->type} ";
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

         session()->flash('success', 'Medical Supply information updated successfully.');

         return redirect()->back();
     }

     public function delete_medical_supplies($id)
    {
        try {
            $supplies = RhuSupply::findOrFail($id);

            $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = " Deleted {$supplies->name}, {$supplies->type} ";
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

            $supplies->delete();

            session()->flash('success', 'Medical Supplies delete successfully.');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    ################ Medical Equipment ########################

    public function medical_equipments()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $medical_equipments = RhuSupply::where('type', 'Medical Equipments')->get();
            return view('inventory.medical_equipments', compact('medical_equipments'));
        }

    }

    public function add_medical_equipments(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([

            'batchNo' => 'nullable|string|max:255',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies'), // Exclude current user's username
            ],

        ]);

        // Add the hardcoded role value
        $validatedAttributes['type'] = 'Medical Equipments';


        $supplies = RhuSupply::create($validatedAttributes);

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = " Added {$supplies->name}, {$supplies->type} ";
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
         return redirect()->back()->with('success', 'New medical equipment added!');
    }

     public function update_medical_equipments(Request $request, $pId)
     {
         $medical_equipments = RhuSupply::findOrFail($pId);

         // Validate the input
         $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rhu_supplies')->ignore($medical_equipments->id),
            ],
            'batchNo' => 'nullable|string|max:255',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',

         ]);

         $medical_equipments->update($validatedData);
         $user = Auth::user();
         // Create a descriptive activity message
         $activityMessage = " Updated {$medical_equipments->name}, {$medical_equipments->type} ";
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
        return redirect()->back()->with('success', 'Medical equipment updated!');
     }

     public function delete_medical_equipments($id)
    {
        try {
            $equipments = RhuSupply::findOrFail($id);

            $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = " Deleted {$equipments->name}, {$equipments->type} ";
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

            $equipments->delete();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    ################ Vaccines ########################

    public function vaccines()
    {
        if (auth()->user()->department !== 'INVENTORY') {
            return redirect('/')->with('error', 'Access denied. You do not have the required permissions.');
        } else {

            $vaccines = RhuSupply::where('type', 'Vaccines')->get()
                ->map(function ($vaccine) {
                    // Format 'expiration_date' if it exists
                    if ($vaccine->expiration_date) {
                        $vaccine->expiration_date = Carbon::parse($vaccine->expiration_date)->format('Y-m-d');
                    }
                    return $vaccine;
                });
            return view('inventory.vaccines', compact('vaccines'));
        }

    }

    public function add_vaccines(Request $request)
    {
        // Validate the form data
        $validatedAttributes = $request->validate([

            'expiration_date' => 'nullable|date',
            'location_code' => 'nullable|string|max:10',
            'quantity' => 'required|string|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies'),
            ],

        ]);

        // Add the hardcoded role value
        $validatedAttributes['type'] = 'Vaccines';

        // Create a new user record
        $vax = RhuSupply::create($validatedAttributes);

        $user = Auth::user();
        // Create a descriptive activity message
        $activityMessage = " Added {$vax->name}, {$vax->type} ";
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
        return redirect()->back()->with('success', 'New vaccine added successfully.');
    }

    public function update_vaccines(Request $request, $pId)
    {
        $vaccines = RhuSupply::findOrFail($pId);

        // Validate the input
        $validatedData = $request->validate([

            'expiration_date' => 'nullable|date',
            'location_code' => 'required|string|max:255',
            'quantity' => 'nullable|max:255',

            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rhu_supplies')->ignore($vaccines->id),
            ],

        ]);


        $vaccines->update($validatedData);

          $user = Auth::user();
          // Create a descriptive activity message
          $activityMessage = " Updated {$vaccines->name}, {$vaccines->type} ";
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


        session()->flash('success', 'Vaccine updated successfully.');

        return redirect()->back();
    }

    public function delete_vaccines($id)
    {
        try {
            $vaccines = RhuSupply::findOrFail($id);

            $user = Auth::user();
            // Create a descriptive activity message
            $activityMessage = " Deleted {$vaccines->name}, {$vaccines->type} ";
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


            $vaccines->delete();

            session()->flash('success', 'Vaccine deleted successfully.');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



}
