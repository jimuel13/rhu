<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuMedicalHistory extends Model
{
        // The table associated with the model.
        protected $table = 'rhu_medical_history';

        // Define the attributes that are mass assignable.
        protected $fillable = [
            'client_id',
            'well_health',
            'antibiotics',
            'infection_medication',
            'medication_deferral',
            'aspirin',
            'vaccinations',
            'pregnant',
            'donated_recently',
            'apheresis',
            'blood_transfusion',
            'transplant',
            'graft',
            'contact_blood',
            'needlestick_injury',
            'sexual_contact_hiv',
            'prostitute_contact',
            'drug_use_contact',
            'hemophilia_contact',
            'male_contact_with_male',
            'saliva_contact_hepatitis',
            'contact_blood_hepatitis',
            'sexual_contact_hepatitis',
            'tattoo',
            'piercing',
            'acupuncture',
            'syphilis_gonorrhea',
            'juvenile_detention',
            'hiv_aids_positive',
            'used_needles',
            'clotting_factor',
            'hepatitis',
            'malaria',
            'chagas',
            'babesiosis'
        ];
}
