<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('services')->countAllResults() > 0) {
            return;
        }
        $now  = date('Y-m-d H:i:s');
        $ncr  = $this->db->table('regions')->where('slug', 'ncr')->get()->getRowArray();
        $r4a  = $this->db->table('regions')->where('slug', 'region-4a')->get()->getRowArray();
        $r7   = $this->db->table('regions')->where('slug', 'region-7')->get()->getRowArray();

        $services = [
            // Health
            ['PhilHealth Member Registration', 'Health', 'fa-heartbeat', 'PhilHealth', 'Register as a PhilHealth member to access affordable health insurance benefits across the Philippines.', 'Free', '1-3 working days', 1, 1, 'PhilHealth Local Office', '8441-7444', 'philhealth.gov.ph', null],
            ['Free Medical Consultation',      'Health', 'fa-stethoscope','DOH', 'Access free outpatient medical consultations at Department of Health rural and city health centers.', 'Free', 'Same day', 1, 1, 'DOH Health Centers', '8651-7800', 'doh.gov.ph', null],
            ['COVID-19 Vaccination',           'Health', 'fa-syringe',    'DOH', 'Walk-in or schedule a free COVID-19 vaccination at any accredited vaccination center.', 'Free', 'Same day', 1, 1, 'DOH Vaccination Sites', '1555', 'doh.gov.ph', null],
            ['National Mental Health Helpline','Health', 'fa-brain',      'DOH', '24/7 free hotline counselling for mental health concerns and crisis intervention.', 'Free', '24/7', 1, 0, 'DOH NCMH', '1553', 'doh.gov.ph', null],

            // Business
            ['Business Permit Application',    'Business', 'fa-briefcase',     'LGU / DTI', 'Apply for a Mayor’s Permit to operate a business legally in your city or municipality.', '₱500–₱5,000', '5-7 working days', 0, 1, 'City Hall — BPLO', '', 'dti.gov.ph', $ncr['id'] ?? null],
            ['DTI Business Name Registration', 'Business', 'fa-store',         'DTI',       'Register your sole proprietorship business name with DTI through BNRS Online.', '₱200–₱2,000', '1-3 working days', 1, 1, 'DTI Field Offices', '8751-3330', 'bnrs.dti.gov.ph', null],
            ['SEC Corporation Registration',   'Business', 'fa-building',      'SEC',       'Register a corporation, partnership, or one-person corporation through SEC eSPARC.', '₱2,000+', '5-10 working days', 1, 0, 'SEC Main Office', '8818-6047', 'sec.gov.ph', null],
            ['BIR TIN Application',            'Business', 'fa-file-invoice',  'BIR',       'Get your Tax Identification Number — required for employment and business compliance.', 'Free', '1 working day', 1, 0, 'BIR Revenue District Office', '8538-3200', 'bir.gov.ph', null],

            // Civil Registry
            ['Birth Certificate Request',      'Civil Registry', 'fa-baby',          'PSA', 'Request a copy of your PSA Birth Certificate online via PSAHelpline.', '₱365 (delivery)', '3-7 working days', 1, 1, 'PSA Civil Registry', '8737-1111', 'psahelpline.ph', null],
            ['Marriage Certificate Request',   'Civil Registry', 'fa-rings-wedding', 'PSA', 'Order an authenticated PSA Marriage Certificate online with home delivery.', '₱365', '3-7 working days', 1, 0, 'PSA', '8737-1111', 'psahelpline.ph', null],
            ['Death Certificate Request',      'Civil Registry', 'fa-file',          'PSA', 'Order a PSA Death Certificate online for legal, insurance, or estate purposes.', '₱365', '3-7 working days', 1, 0, 'PSA', '8737-1111', 'psahelpline.ph', null],
            ['CENOMAR Application',            'Civil Registry', 'fa-id-card',       'PSA', 'Apply for a Certificate of No Marriage Record (CENOMAR) online.', '₱465', '3-7 working days', 1, 0, 'PSA', '8737-1111', 'psahelpline.ph', null],

            // Education
            ['DepEd Public School Enrollment', 'Education', 'fa-school',          'DepEd', 'Enroll a child in public elementary or secondary school for the upcoming school year.', 'Free', '1 day', 1, 0, 'DepEd Local School', '8636-1663', 'deped.gov.ph', null],
            ['CHED Scholarship Programs',      'Education', 'fa-graduation-cap',  'CHED',  'Apply for CHED scholarships and student financial assistance programs.', 'Free', '1-2 months', 1, 1, 'CHED Regional Office', '8441-1170', 'ched.gov.ph', null],
            ['TESDA Training Programs',        'Education', 'fa-tools',           'TESDA', 'Free TVET training and assessment programs for Filipino workers.', 'Free', 'Varies', 1, 1, 'TESDA Training Centers', '8893-1966', 'tesda.gov.ph', null],

            // Social Welfare
            ['4Ps — Pantawid Pamilyang Pilipino','Social Welfare', 'fa-hands-helping','DSWD', 'Conditional cash transfer program for poor Filipino families with children.', 'Free', 'Subject to validation', 1, 1, 'DSWD Field Office', '8931-8101', 'dswd.gov.ph', null],
            ['PWD ID Application',              'Social Welfare', 'fa-wheelchair',   'DOH/LGU','Get a Persons with Disability (PWD) ID for access to discounts and benefits.', 'Free', '1-3 working days', 1, 0, 'City Health Office', '', 'ncda.gov.ph', null],
            ['Senior Citizen ID',               'Social Welfare', 'fa-user',         'OSCA',  'Apply for an Office for Senior Citizens Affairs ID for 60+ benefits and discounts.', 'Free', '1 day', 1, 0, 'OSCA City Hall', '', '', null],
            ['Solo Parent ID',                  'Social Welfare', 'fa-user-friends', 'DSWD',  'Get a Solo Parent ID under RA 11861 for benefits and tax exemptions.', 'Free', '7-15 working days', 1, 0, 'DSWD / City Hall', '8931-8101', 'dswd.gov.ph', null],

            // Transportation
            ['LTO Driver’s License',            'Transportation', 'fa-id-card-alt', 'LTO', 'Apply for, renew, or duplicate a Philippine driver’s license at any LTO branch.', '₱585+', '1-2 hours', 1, 1, 'LTO Branch', '8922-9061', 'lto.gov.ph', null],
            ['LTO Vehicle Registration',        'Transportation', 'fa-car',         'LTO', 'New, renewal, or transfer of motor vehicle registration with LTO.', '₱600+', '1-3 hours', 1, 0, 'LTO Branch', '8922-9061', 'lto.gov.ph', null],

            // Housing
            ['NHA Socialized Housing Application','Housing', 'fa-home',         'NHA',     'Apply for affordable government housing under NHA programs.', 'Subject to evaluation', '1-3 months', 1, 0, 'NHA Office', '8851-3567', 'nha.gov.ph', null],
            ['Pag-IBIG Housing Loan',             'Housing', 'fa-house-user',   'Pag-IBIG','Apply for an affordable home loan with the Home Development Mutual Fund.', 'Subject to loan terms', '15-20 working days', 1, 1, 'Pag-IBIG Branch', '8724-4244', 'pagibigfund.gov.ph', null],

            // Agriculture
            ['DA Farmer Registration (RSBSA)',    'Agriculture', 'fa-seedling',     'DA', 'Register as a farmer or fisher under RSBSA to access agricultural subsidies and aid.', 'Free', '7 working days', 1, 0, 'Municipal Agriculturist Office', '8273-2474', 'da.gov.ph', $r4a['id'] ?? null],
        ];

        $rows = [];
        foreach ($services as $i => $s) {
            [$name, $cat, $icon, $agency, $desc, $fee, $time, $nationwide, $featured, $office, $contact, $website, $regionId] = $s;
            $rows[] = [
                'name'            => $name,
                'slug'            => url_title(strtolower($name), '-', true),
                'category'        => $cat,
                'short_desc'      => $desc,
                'description'     => '<p>' . esc($desc) . '</p><p>This service is offered by <strong>' . esc($agency) . '</strong> as part of the Philippine government’s commitment to accessible public services.</p>',
                'icon'            => $icon,
                'image'           => null,
                'requirements'    => "Valid government-issued ID\nAccomplished application form\nProof of residency",
                'steps'           => "Prepare requirements\nVisit the designated office or apply online\nSubmit documents and pay fees (if applicable)\nReceive your release/notice",
                'fee'             => $fee,
                'processing_time' => $time,
                'office'          => $office,
                'contact'         => $contact,
                'website'         => $website,
                'agency'          => $agency,
                'region_id'       => $regionId,
                'is_nationwide'   => $nationwide,
                'is_featured'     => $featured,
                'is_active'       => 1,
                'avg_rating'      => 0,
                'total_ratings'   => 0,
                'created_at'      => $now,
                'updated_at'      => $now,
                'deleted_at'      => null,
            ];
        }
        $this->db->table('services')->insertBatch($rows);
    }
}
