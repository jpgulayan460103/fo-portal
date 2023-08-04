<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            'Accounting Section',
            'Administrative Division',
            'Anti-Red Tape Unit',
            'Bids and Awards Committee Secretariat',
            'Budget Section',
            'Capability Building Section',
            'Cash Section',
            'Center Based Services',
            'Center for Children with Special Needs',
            'Commission on Audit',
            'Community-Based Services Section',
            'Comprehensive Program for Street Children, Families, Indigenous Peoples in Street Situations',
            'Crisis Intervention Section',
            'Davao City Operations Office',
            'Davao de Oro Operations Office',
            'Davao del Norte Operations Office',
            'Davao del Sur Operations Office',
            'Davao Occidental Operations Office',
            'Davao Oriental Operations Office',
            'Disaster Response and Rehabilitation Section',
            'Disaster Response Information Management Section',
            'Disaster Response Management Division',
            'Enhanced Partnership Against Hunger and Poverty Program Management Office',
            'Financial Management Division',
            'General Services Section',
            'Home for Girls and Women',
            'Home for the Aged',
            'Human Resource Management and Development Division',
            'Human Resource Planning and Performance Management Section',
            'Information and Communications Technology Management Section',
            'Internal Audit Unit',
            'KALAHI CIDSS Program Management Office',
            'Learning Development Section',
            'Legal Unit',
            'National Households Targeting System Program Management Office',
            'Office of the Assistant Regional Director for Administration',
            'Office of the Assistant Regional Director for Operations',
            'Office of the Regional Director',
            'Pantawid Pamilyang Pilipino Program Management Division',
            'Personnel Administration Section',
            'Policy and Plans Division',
            'Policy Development and Planning Section',
            'Procurement Section',
            'Promotive Services Division',
            'Property Supply Section',
            'Protective Services Division',
            'Provincial Social Welfare and Development Office',
            'Reception and Study Center for Children',
            'Records and Archives Management Section',
            'Recovery Reintegration for Trafficked Persons',
            'Regional Alternative Child Care Office',
            'Regional Juvenile Justice and Welfare Council',
            'Regional Rehabilitation Center for Youth',
            'Regional Resource Operations Section',
            'Regional Sub-Committee for the Welfare of Children',
            'Social Marketing Unit',
            'Social Pension Program Management Office',
            'Social Technology Unit',
            'Standards Section',
            'Supplementary Feeding Program Management Office',
            'Sustainable Livelihood Program Management Office',
            'Targeted Cash Transfer Program Management Office',
            'Technical Assistance and Resource Augmentation',
            'Welfare Section',
        ];

        foreach ($offices as $office) {
            Office::create([
                'name' => $office
            ]);
        }


    }
}
