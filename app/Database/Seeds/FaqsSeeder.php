<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FaqsSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('faqs')->countAllResults() > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');

        $faqs = [
            ['Services', 'How do I find a government service relevant to me?',
             "Use the search bar on the home page or browse the full directory at /services. You can filter by region, category, or agency. Each service page lists requirements, fees, processing time, and the responsible agency."],

            ['Services', 'Are the fees and processing times accurate?',
             "Yes, the fees and processing times are sourced from each agency's official citizen's charter. Actual experience may vary depending on completeness of documents, location, and time of year. For the most current rates, always confirm with the issuing agency."],

            ['Services', 'How do I leave a review on a service?',
             "Sign in to your citizen account, open the service page, and use the 'Write a Review' form. Reviews must be approved by an administrator before they appear publicly to ensure quality and prevent spam."],

            ['Reports', 'How do I report a community issue?',
             "Go to /reports, fill in the form, click on the map to pin the exact location, and submit. You'll receive a reference number starting with 'RPT-' that you can use to track progress."],

            ['Reports', 'How do I track the status of my report?',
             "Visit /track and enter your reference number (format: RPT-XXXXXXXX). You'll see the current status — Pending, Reviewing, In Progress, or Resolved — along with any official notes from the assigned office."],

            ['Reports', 'What kinds of issues should I report here?',
             "Non-emergency community concerns: potholes, garbage collection, streetlight outages, flooding, noise, and similar local issues. For life-threatening emergencies, call 911 immediately. For complaints against government employees, also try the 8888 Citizens' Complaint Hotline."],

            ['Account', 'Do I need an account to use SmartCity PH?',
             "Most features — browsing services, reading news, viewing transparency data, and filing reports — work without an account. You need an account to write service reviews, track multiple reports in one dashboard, and personalize your experience."],

            ['Account', 'How do I create an account?',
             "Visit /register and fill in your name, email, and password. Citizen accounts are free and your data is protected under the Data Privacy Act of 2012 (RA 10173)."],

            ['Account', 'I forgot my password — what should I do?',
             "Currently, please use the /contact form to request a password reset. A self-service password reset feature is on the roadmap."],

            ['FOI', 'What is the Freedom of Information (FOI) Program?',
             "Under Executive Order No. 2 (2016), every Filipino has the right to request information from Executive branch agencies. Submit a request at /foi — agencies have 15 working days to respond."],

            ['FOI', 'What information can I request via FOI?',
             "Public records held by Executive branch agencies — budgets, contracts, project status, statistical data, agency rules, and similar non-confidential information. Records covered by exceptions (national security, personal privacy, ongoing investigations) may be denied with explanation."],

            ['FOI', 'How long does an FOI response take?',
             "Agencies must respond within 15 working days. For voluminous or complex requests, agencies may extend this by another 20 working days with written notice."],

            ['Technical', 'Why does the 3D city on the homepage run slowly on my device?',
             "The Three.js animated city is GPU-intensive. On mobile or older devices, the number of buildings is automatically reduced. You can also disable animations system-wide via your OS accessibility settings (prefers-reduced-motion)."],

            ['Technical', 'Is SmartCity PH available on mobile?',
             "Yes — the portal is fully responsive on mobile, tablet, and desktop. The official eGovPH Super App is also available on the App Store and Google Play for a native experience."],

            ['General', 'Who runs SmartCity PH?',
             "SmartCity PH is a citizen-focused digital government services portal. It is aligned with the E-Governance Act (RA 12254) and the National e-Government Master Plan. For agency-specific concerns, always reach out to the responsible agency listed on each service page."],
        ];

        $rows = [];
        foreach ($faqs as $i => $f) {
            $rows[] = [
                'question'   => $f[1],
                'answer'     => $f[2],
                'category'   => $f[0],
                'sort_order' => $i,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->db->table('faqs')->insertBatch($rows);
    }
}
