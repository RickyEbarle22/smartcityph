<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgenciesSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('agencies')->countAllResults() > 0) {
            return; // already seeded
        }

        $now = date('Y-m-d H:i:s');

        $agencies = [
            ['PhilHealth', 'PHIC', 'GOCC', 'Philippine Health Insurance Corporation — National health insurance program of the Philippines.', 'https://www.philhealth.gov.ph', 'actioncenter@philhealth.gov.ph', '(02) 8441-7444', 'Citystate Centre, 709 Shaw Boulevard, Pasig City', 'Emmanuel R. Ledesma Jr.', 'President and CEO'],
            ['Social Security System', 'SSS', 'GOCC', 'Social insurance program covering private sector employees and self-employed Filipinos.', 'https://www.sss.gov.ph', 'member_relations@sss.gov.ph', '(02) 7920-6446', 'SSS Building, East Avenue, Diliman, Quezon City', 'Rolando Macasaet', 'President and CEO'],
            ['Government Service Insurance System', 'GSIS', 'GOCC', 'Social insurance program for government employees in the Philippines.', 'https://www.gsis.gov.ph', 'gsiscares@gsis.gov.ph', '(02) 8847-4747', 'GSIS Headquarters, Financial Center, Pasay City', 'Wick Veloso', 'President and General Manager'],
            ['Bureau of Internal Revenue', 'BIR', 'Attached Agency', 'Primary tax-collecting agency under the Department of Finance.', 'https://www.bir.gov.ph', 'contact_us@bir.gov.ph', '(02) 8538-3200', 'BIR National Office, Agham Road, Diliman, Quezon City', 'Romeo D. Lumagui Jr.', 'Commissioner'],
            ['Department of Trade and Industry', 'DTI', 'Department', 'Lead agency for trade, industry, and investment policy. Issues business name registrations.', 'https://www.dti.gov.ph', 'ask@dti.gov.ph', '(02) 7791-3100', '361 Senator Gil Puyat Avenue, Makati City', 'Cristina A. Roque', 'Secretary'],
            ['Department of Information and Communications Technology', 'DICT', 'Department', 'Lead agency for ICT planning, policy, and the National ID and e-government services.', 'https://dict.gov.ph', 'info@dict.gov.ph', '(02) 8920-0101', 'C.P. Garcia Avenue, UP-Diliman, Quezon City', 'Henry Rhoel R. Aguda', 'Secretary'],
            ['Department of Education', 'DepEd', 'Department', 'Executive department responsible for basic education in the Philippines.', 'https://www.deped.gov.ph', 'action@deped.gov.ph', '(02) 8636-1663', 'DepEd Complex, Meralco Avenue, Pasig City', 'Sonny Angara', 'Secretary'],
            ['Commission on Higher Education', 'CHED', 'Attached Agency', 'Regulates higher education institutions and administers scholarship programs.', 'https://ched.gov.ph', 'info@ched.gov.ph', '(02) 8441-1177', 'Higher Education Development Center, C.P. Garcia Avenue, UP-Diliman', 'Shirley C. Agrupis', 'Chairperson'],
            ['Technical Education and Skills Development Authority', 'TESDA', 'Attached Agency', 'Manages and supervises technical and vocational education and training.', 'https://www.tesda.gov.ph', 'contactcenter@tesda.gov.ph', '(02) 8888-5641', 'TESDA Complex, East Service Road, Taguig City', 'Jose Francisco Benitez', 'Secretary'],
            ['Department of Social Welfare and Development', 'DSWD', 'Department', 'Lead agency for social protection programs including 4Ps and disaster relief.', 'https://www.dswd.gov.ph', 'inquiry@dswd.gov.ph', '(02) 8931-8101', 'Batasan Pambansa Complex, Constitution Hills, Quezon City', 'Rex Gatchalian', 'Secretary'],
            ['Land Transportation Office', 'LTO', 'Attached Agency', 'Regulates motor vehicles and issues driver licenses nationwide.', 'https://www.lto.gov.ph', '8888@lto.gov.ph', '(02) 8922-9061', 'East Avenue, Diliman, Quezon City', 'Vigor D. Mendoza II', 'Assistant Secretary'],
            ['National Bureau of Investigation', 'NBI', 'Attached Agency', 'National investigative agency under the Department of Justice. Issues NBI Clearance.', 'https://nbi.gov.ph', 'nbi.helpdesk@nbi.gov.ph', '(02) 8523-8231', 'NBI Headquarters, Taft Avenue, Manila', 'Jaime B. Santiago', 'Director'],
            ['Department of Foreign Affairs', 'DFA', 'Department', 'Manages foreign relations and issues Philippine passports.', 'https://dfa.gov.ph', 'osec@dfa.gov.ph', '(02) 8834-4000', '2330 Roxas Boulevard, Pasay City', 'Enrique A. Manalo', 'Secretary'],
            ['Philippine Statistics Authority', 'PSA', 'Attached Agency', 'Official statistics agency. Issues birth, marriage, death certificates and CENOMAR.', 'https://psa.gov.ph', 'info@psa.gov.ph', '(02) 8462-6600', 'PSA Complex, East Avenue, Diliman, Quezon City', 'Claire Dennis S. Mapa', 'National Statistician'],
            ['Department of Labor and Employment', 'DOLE', 'Department', 'Lead agency for labor and employment policy and OFW welfare.', 'https://www.dole.gov.ph', 'oss@dole.gov.ph', '(02) 8527-8000', 'DOLE Building, Muralla cor. Gen. Luna Sts., Intramuros, Manila', 'Bienvenido E. Laguesma', 'Secretary'],
        ];

        $rows = [];
        foreach ($agencies as $a) {
            $rows[] = [
                'name'        => $a[0],
                'slug'        => url_title(strtolower($a[0]), '-', true),
                'acronym'     => $a[1],
                'category'    => $a[2],
                'description' => $a[3],
                'website'     => $a[4],
                'email'       => $a[5],
                'phone'       => $a[6],
                'address'     => $a[7],
                'head_name'   => $a[8],
                'head_title'  => $a[9],
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        $this->db->table('agencies')->insertBatch($rows);
    }
}
