<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceCoa;
use App\Models\FinanceLajur;

class FinanceCoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $financeCoas = [
            [
                'code' => '111',
                'item' => 'Kas',
            ],
            [
                'code' => '112',
                'item' => 'Dana',
            ],
            [
                'code' => '112.1',
                'item' => 'Bank BCA',
            ],
            [
                'code' => '112.2',
                'item' => 'Bank BNI',
            ],
            [
                'code' => '112.3',
                'item' => 'Bank BRI',
            ],
            [
                'code' => '112.4',
                'item' => 'Bank Mandiri',
            ],
            [
                'code' => '113',
                'item' => 'Piutang Usaha',
            ],
            [
                'code' => '114',
                'item' => 'Piutang Lain-Lain',
            ],
            [
                'code' => '211',
                'item' => 'Pajak Dibayar Dimuka',
            ],
            [
                'code' => '212',
                'item' => 'Peralatan Kantor',
            ],
            [
                'code' => '213',
                'item' => 'Gedung',
            ],
            [
                'code' => '311',
                'item' => 'Hutang Lain-Lain',
            ],
            [
                'code' => '312',
                'item' => 'Hutang Usaha',
            ],
            [
                'code' => '313',
                'item' => 'Hutang Gaji',
            ],
            [
                'code' => '314',
                'item' => 'Pendapatan Diterima Dimuka',
            ],
            [
                'code' => '315',
                'item' => 'Hutang Pajak',
            ],
            [
                'code' => '411',
                'item' => 'Modal Dasar',
            ],
            [
                'code' => '412',
                'item' => 'Modal Tambahan',
            ],
            [
                'code' => '413',
                'item' => 'Laba Bulan Berjalan Setelah PJK',
            ],
            [
                'code' => '414',
                'item' => 'Laba Ditahan',
            ],
            [
                'code' => '511',
                'item' => 'Pendapatan Jasa Inspeksi',
            ],
            [
                'code' => '512',
                'item' => 'Pendapatan Jasa Giro',
            ],
            [
                'code' => '513',
                'item' => 'Pendapatan Lain-Lain',
            ],
            [
                'code' => '611',
                'item' => 'Beban Akomodasi',
            ],
            [
                'code' => '612',
                'item' => 'Beban Internet',
            ],
            [
                'code' => '613',
                'item' => 'Beban Website',
            ],
            [
                'code' => '614',
                'item' => 'Beban Telepon',
            ],
            [
                'code' => '615',
                'item' => 'Beban Percetakan',
            ],
            [
                'code' => '616',
                'item' => 'Beban Marketing',
            ],
            [
                'code' => '617',
                'item' => 'Beban Transportasi',
            ],
            [
                'code' => '618',
                'item' => 'Beban Operational Lain',
            ],
            [
                'code' => '711',
                'item' => 'Biaya Gaji',
            ],
            [
                'code' => '712',
                'item' => 'Biaya Admin',
            ],
            [
                'code' => '713',
                'item' => 'Biaya Sewa',
            ],
            [
                'code' => '714',
                'item' => 'Biaya Lain-Lain',
            ],
        ];

        foreach ($financeCoas as $key => $financeCoa) {
            FinanceCoa::create([
                'code' => $financeCoa['code'],
                'item' => $financeCoa['item']
            ]);
            FinanceLajur::create([
                'code' => $financeCoa['code'],
                'item' => $financeCoa['item']
            ]);
        }
    }
}
