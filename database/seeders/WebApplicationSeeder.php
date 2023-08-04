<?php

namespace Database\Seeders;

use App\Models\WebApplication;
use Illuminate\Database\Seeder;

class WebApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebApplication::create([
            'application_name' => 'Procurement Manangement System',
            'application_url' => 'https://fo11apps.dswd.gov.ph/pms',
            'application_image' => '/storage/apps/pms.png',
            'application_description' => "The Procurement Management System organizes the processes of contractual agreements and suppliers' connection with DSWD.",
            'keywords' => 'pms ris pr procurement supplies property request ppmp service order purchase supply equipment suppliers',
        ]);

        WebApplication::create([
            'application_name' => 'Electronic Document Information System',
            'application_url' => 'https://fo11apps.dswd.gov.ph/edis',
            'application_image' => '/storage/apps/pms.png',
            'application_description' => "The Electronic Document Information System organizes the creation and digital signing of a document.",
            'keywords' => 'edis signatures documents signings records electronic digital rams',
        ]);

        WebApplication::create([
            'application_name' => 'Information Kiosk',
            'application_url' => 'https://fo11apps.dswd.gov.ph/InfoKiosk',
            'application_image' => '/storage/apps/kiosk.png',
            'application_description' => "Information Kiosk.",
            'keywords' => 'kiosk information client ciu cis'
        ]);

        WebApplication::create([
            'application_name' => 'Freedom of Information',
            'application_url' => 'https://fo11apps.dswd.gov.ph/FOI',
            'application_image' => '/storage/apps/foi.png',
            'application_description' => "This process covers requests for information/data of Department through FOI pursuant to Executive Order No. 02, series of 2016, on FOI.",
            'keywords' => 'foi freedom information'
        ]);

        WebApplication::create([
            'application_name' => 'Regional Resource Operations Section Warehouse Management Information System',
            'application_url' => 'https://fo11apps.dswd.gov.ph/inventory',
            'application_image' => '/storage/apps/inventory.png',
            'application_description' => "Automation of reports for the purpose of daily forecasting, monitoring of the available stockpile of food and non-food items.",
            'keywords' => 'inventory warehouse rros regional resource operations'
        ]);

        WebApplication::create([
            'application_name' => 'Administrative Services All-in-one Portal',
            'application_url' => 'https://genservices.dswdfo11.com/',
            'application_image' => '/storage/apps/asap.png',
            'application_description' => "Administrative Services All-in-one Portal.",
            'keywords' => 'asap gss general services building vehicle conference air transport janitorial all portal admin official'
        ]);

        WebApplication::create([
            'application_name' => 'CPMS-CIS Processing and Monitoring System',
            'application_url' => 'https://onse.dswd.gov.ph/cpmsv2_2',
            'application_image' => '/storage/apps/cpms.png',
            'application_description' => "CPMS-CIS Processing and Monitoring System",
            'keywords' => 'cmps ciu cis assisstances processing client'
        ]);

        WebApplication::create([
            'application_name' => 'Employee Profile Management System',
            'application_url' => 'https://onse.dswd.gov.ph/profile',
            'application_image' => '/storage/apps/dtrms.png',
            'application_description' => "Employee Profile Management System",
            'keywords' => 'dtrms profile pds outslip hrms employee informations'
        ]);
    }
}
