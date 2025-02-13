<?php
// Patient
// It Dept
// Super Admin
// Inventory
// Laboratory
// Consultation
// Vaccination
// blood...


use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ITDepartment;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Laboratory;
use App\Http\Controllers\Consultation;
use App\Http\Controllers\Vaccination;
use App\Http\Controllers\Blood;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\ReceiptController;
use App\Exports\DynamicExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ForgotPasswordController;


Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/profile/edit','edit')->name('profile.edit');
    Route::post('/profile/update', 'update')->name('profile.update');

    Route::get('/edits','edits')->name('edits');
    Route::get('/edit_profile','edit_profile')->name('edit');
    Route::post('/update_edit_profile','update_edit_profile')->name('update_edit_profile');
});

// Route::get('/generate-receipt/{id}', [ReceiptController::class, 'generateReceipt']);
Route::get('/generate-receipt', [ReceiptController::class, 'generateReceipt']);
Route::get('/generate-image', [ReceiptController::class, 'generateImage']);

Route::middleware('auth')->controller(ITDepartment::class)->group(function () {
    Route::get('/it_dept', 'it_dept');
    Route::get('/user_account', 'user_account');
    Route::get('/staff_account', 'staff_account');

    Route::get('/registration_verification', 'registration_verification');
    Route::put('/client_account/{pId}','client_account_update');
    Route::post('/approve-client/{id}','approveClient');
    Route::match(['get', 'post'], '/approve-client-email/{id}', 'email');
    Route::delete('/delete-client/{id}', 'deleteClient');
    Route::post('/add-staff', 'staff_store')->name('staff_store');
    Route::get('/logs', 'logs');
});

Route::middleware('auth')->controller(SuperAdmin::class)->group(function () {
    Route::get('/super_admin', 'super_admin');
    Route::get('/super_patient', 'super_patient');
    Route::get('/announcement', 'announcement');
    Route::post('/add-announcement', 'announcement_store')->name('announcement_store');
    Route::delete('/delete-announcement/{id}', 'deleteAnnouncement');
    Route::put('/update-announcement/{pId}','updateAnnouncement');
    Route::get('/super_admin_staff', 'super_admin_staff_account');

    Route::get('/super_admin_appointments', 'appointments');
});

Route::middleware('auth')->controller(Laboratory::class)->group(function () {
    Route::post('/lab-appointments', 'store');
    Route::get('/laboratory', 'laboratory');
    Route::get('/lab_staff_management', 'lab_staff_management');
    Route::get('/lab_report', 'reports');

    Route::get('/display-lab_appointments', 'display_lab_appointments');
    Route::put('/update-lab_appointments/{pId}','update_lab_appointments');
    Route::match(['get', 'post'], '/approve-appointments/{id}', 'approve_appointments');
    Route::delete('/delete-appointments/{id}', 'delete_appointments');

    Route::match(['get', 'post'], '/email/{id}', 'email');


    // for test list
    Route::get('/lab_tests', 'lab_tests');
    Route::put('/update-lab_tests/{pId}','update_lab_tests');
    Route::post('/add-lab_tests', 'add_lab_tests')->name('add_lab_tests');
    Route::delete('/delete-lab_tests/{id}', 'delete_lab_tests');

    // for patient records
    Route::get('/lab_patient_records', 'lab_patient_records');
    Route::post('/add-lab_patient_records', 'add_lab_patient_records')->name('add_lab_patient_records');
    Route::delete('/delete-patient_records/{id}', 'delete_patient_records');

    // for dynnamic name
    Route::get('/get-sub-type/{name}', 'getSubType');
});

Route::middleware('auth')->controller(Consultation::class)->group(function () {
    Route::post('/con-appointments', 'store');
    Route::get('/consultation', 'consultation');
    Route::get('/con_staff_management', 'con_staff_management');

    Route::get('/con_report', 'reports');
    Route::put('/con_refer_reject/{pId}','con_refer_reject');

    // appointment
    Route::get('/display-con_appointments', 'display_con_appointments');
    Route::put('/update-con_appointments/{pId}','update_con_appointments');

    // for patient records
    Route::get('/con_patient_records', 'con_patient_records');
    Route::post('/add-con_patient_records', 'add_con_patient_records')->name('add_con_patient_records');

    // for dynnamic name
    Route::get('/get-sub-type-con/{name}', 'getSubType');

});

Route::middleware('auth')->controller(Vaccination::class)->group(function () {
    Route::post('/vax-appointments', 'store');

    Route::get('/vaccination', 'vaccination');
    Route::get('/vax_staff_management', 'vax_staff_management');
    Route::get('/vax_report', 'reports');

    // appointment
    Route::get('/display-vax_appointments', 'display_vax_appointments');
    Route::put('/update-vax_appointments/{pId}','update_vax_appointments');

    // for patient records
    Route::get('/vax_patient_records', 'vax_patient_records');
    Route::post('/add-vax_patient_records', 'add_vax_patient_records')->name('add_vax_patient_records');

    // for dynnamic name
    Route::get('/get-sub-type-vax/{name}', 'getSubType');

});

Route::middleware('auth')->controller(Blood::class)->group(function () {
    Route::post('/blood-appointments', 'store');

    Route::get('/blood', 'blood');
    Route::get('/blood_reports', 'reports');
    Route::get('/blood_staff_management', 'blood_staff_management');

    // appointment
    Route::get('/display-blood_appointments', 'display_blood_appointments');
    Route::put('/update-blood_appointments/{pId}','update_blood_appointments');

    // for patient records
    Route::get('/blood_patient_records', 'blood_patient_records');
    Route::post('/add-blood_patient_records', 'add_blood_patient_records')->name('add_blood_patient_records');

    // for dynnamic name
    Route::get('/get-sub-type-blood/{name}', 'getSubType');

    // for turned over
    Route::get('/turned_overs', 'turned_overs');
    Route::put('/update-turned_overs/{pId}','update_turned_overs');
    Route::post('/add-turned_overs', 'add_turned_overs')->name('add_turned_overs');
    Route::delete('/delete-turned_overs/{id}', 'delete_turned_overs');

});

Route::middleware('auth')->controller(Inventory::class)->group(function () {
    Route::get('/inventory', 'inventory');
    Route::get('/inventory_staff_management', 'inventory_staff_management');
    Route::get('/inventory_reports', 'reports');
    // for medicine
    Route::get('/medicines', 'medicines');
    Route::put('/update-medicines/{pId}','update_medicines');
    Route::put('/update-medicines1/{pId}','update_medicines1');
    Route::post('/add-medicines', 'add_medicines')->name('add_medicines');
    Route::delete('/delete-medicines/{id}', 'delete_medicines');

    // for medical supplies
    Route::get('/medical_supplies', 'medical_supplies');
    Route::put('/update-medical_supplies/{pId}','update_medical_supplies');
    Route::post('/add-medical_supplies', 'add_medical_supplies')->name('add_medical_supplies');
    Route::delete('/delete-medical_supplies/{id}', 'delete_medical_supplies');

    // for medical equipment
    Route::get('/medical_equipments', 'medical_equipments');
    Route::put('/update-medical_equipments/{pId}','update_medical_equipments');
    Route::post('/add-medical_equipments', 'add_medical_equipments')->name('add_medical_equipments');
    Route::delete('/delete-medical_equipments/{id}', 'delete_medical_equipments');

    // for vaccines
    Route::get('/vaccines', 'vaccines');
    Route::put('/update-vaccines/{pId}','update_vaccines');
    Route::post('/add-vaccines', 'add_vaccines')->name('add_vaccines');
    Route::delete('/delete-vaccines/{id}', 'delete_vaccines');
});

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create');
    Route::post('/register', 'store');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

Route::middleware('auth')->get('/export/{department}', function ($department) {
    return Excel::download(new DynamicExport($department), $department . '.xlsx');
});

Route::get('/phpinfo', function () {
    phpinfo();
});
