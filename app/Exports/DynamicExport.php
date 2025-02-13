<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\RhuAppointment;
use App\Models\RhuTurnedOver;
use App\Models\RhuClient;
use App\Models\RhuTest;
use App\Models\RhuSupply;

class DynamicExport implements FromCollection , WithHeadings
{
    protected $department;
    /**
    * @return \Illuminate\Support\Collection
    */

    // Constructor to pass department name
    public function __construct($department)
    {
        $this->department = $department;
    }
    public function collection()
    {
        switch ($this->department) {
            case 'appointments':
                return RhuAppointment::select('name', 'sub_type', 'date', 'contactNo', 'status')->get();
            case 'blood-donation':
                return RhuClient::select('name', 'sub_type', 'volume', 'date', 'status')->get();
            case 'turned_over':
                return RhuTurnedOver::select('name', 'blood_type', 'date', 'volume')->get();

            // for blood
            case 'b_appointments':
                return RhuAppointment::where('type', 'blood')
                    ->select('name', 'sub_type', 'date', 'contactNo', 'status')
                    ->get();
            case 'b_blood-donation':
                return RhuClient::where('type', 'blood')
                    ->select('name', 'sub_type', 'volume', 'date', 'status')
                    ->get();



            // for vaccination
            case 'vax_appointments':
                return RhuAppointment::where('type', 'vaccination')->select('name', 'sub_type', 'dose_number', 'date', 'contactNo', 'status')->get();
            case 'vax_blood-donation':
                return RhuClient::where('type', 'vaccination')->select('name', 'sub_type', 'dose_number', 'date', 'status')->get();


            // consultation
            case 'con_appointments':
                return RhuAppointment::where('type', 'consultation')->select('name', 'sub_type', 'date', 'contactNo', 'status')->get();
            case 'con_blood-donation':
                return RhuClient::where('type', 'consultation')->select('name', 'sub_type', 'date', 'status')->get();

             // laboratory
             case 'lab_appointments':
                return RhuAppointment::where('type', 'laboratory')->select('name', 'sub_type', 'date', 'contactNo', 'status')->get();
            case 'lab_blood-donation':
                return RhuClient::where('type', 'laboratory')->select('name', 'sub_type', 'result', 'date', 'status')->get();
            case 'testList':
                return RhuTest::select('name', 'price', 'status')->get();

             // inventory
            case 'medicines':
                return RhuSupply::where('type', 'Medicines')->select('name', 'dosage_f', 'dosage_s', 'location_code', 'Quantity')->get();
            case 'medicalSupplies':
                return RhuSupply::where('type', 'Medical Supplies')->select('name', 'batchNo', 'location_code', 'quantity')->get();
            case 'medicalEquipments':
                return RhuSupply::where('type', 'Medical Equipments')->select('name', 'batchNo', 'location_code', 'quantity')->get();
            case 'vaccines':
                return RhuSupply::where('type', 'Vaccines')->select('name', 'expiration_date', 'location_code', 'quantity')->get();


             // super admin patient
             case 'laboratory':
                return RhuClient::where('type', 'laboratory')->select('name', 'sub_type', 'result', 'date', 'status')->get();
            case 'consultation':
                return RhuClient::where('type', 'consultation')->select('name', 'sub_type', 'doctor', 'analysis', 'date', 'status')->get();
            case 'vaccination':
                return RhuClient::where('type', 'vaccination')->select('name', 'sub_type', 'dose_number', 'date', 'status')->get();
            case 'blood':
                return RhuClient::where('type', 'blood')->select('name', 'sub_type', 'volume', 'date', 'status')->get();

            default:
                return collect(); // Return empty collection if no match
        }
    }

     // Define headings dynamically based on the department
     public function headings(): array
     {
         switch ($this->department) {
             case 'appointments':
                 return ['Patient Name', 'Blood Type', 'Date', 'Contact Number', 'Status'];
             case 'blood-donation':
                 return ['Name', 'Blood Type', 'Volume', 'Date', 'Status'];
             case 'turned_over':
                 return ['Blood Bank Name', 'Blood Type', 'Date', 'Volume'];


            // for vaccination
            case 'vax_appointments':
                return ['Patient Name', 'Vaccine Type','Dose Number', 'Date', 'Contact Number', 'Status'];
            case 'vax_blood-donation':
                return ['Patient Name', 'Vaccine Type', 'Dose Number', 'Date', 'Status'];

            // for consultation
            case 'con_appointments':
                return ['Patient Name', 'Mode of Consultation', 'Date', 'Contact Number', 'Status'];
            case 'con_blood-donation':
                return ['Patient Name', 'Mode of Consultation', 'Date', 'Status'];

            // for laboratory
            case 'lab_appointments':
                return ['Patient Name', 'Test Requested', 'Date', 'Contact Number', 'Status'];
            case 'lab_blood-donation':
                return ['Patient Name', 'Test Requested', 'Result', 'Date', 'Status'];
            case 'testList':
                return ['Test Name', 'Price', 'Status'];

            // for laboratory
            case 'medicines':
                return ['Medicine Name', 'Dosage Form', 'Dosage Strenght', 'Location Area Code/ Rack Number', 'Quantity'];
            case 'medicalSupplies':
                return ['Medicine Name', 'Batch. Lot No.', 'Location Area Code/ Rack Number', 'Quantity'];
            case 'medicalEquipments':
                return ['Equipment Name', 'Batch. Lot No.', 'Location Area Code/ Rack Number', 'Quantity'];
            case 'vaccines':
                return ['Medicine Name', 'Expiration Date', 'Location Area Code/ Rack Number', 'Quantity'];

                case 'laboratory':
                    return ['Medicine Name', 'Dosage Form', 'Dosage Strenght', 'Location Area Code/ Rack Number', 'Quantity'];
                case 'consultation':
                    return ['Name', 'Mode of Consultation', 'Doctor', 'Doctor\'s Analysis', 'Date', 'Status'];
                case 'vaccination':
                    return ['Name', 'Vaccine type', 'Dose Number', 'Date', 'Status'];
                case 'blood':
                    return ['Name', 'Blood type', 'Volume', 'Date', 'Status'];

             default:
                 return [];
         }
     }
}
