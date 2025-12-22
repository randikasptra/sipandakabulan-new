<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Desa;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // MATIKAN FK CHECK (BIAR CEPET)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // KOSONGKAN TABLE
        DB::table('users')->truncate();
        DB::table('desas')->truncate();

        // ADMIN
        User::insert([
            [
                'name' => 'Admin Dinsos Kabupaten Tasikmalaya',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Risna Admin',
                'email' => 'risna@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Tubagus Admin',
                'email' => 'tubagus@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
        ]);

        // ===============================
        // DESA (PASTE ARRAY DESA KAMU DI SINI)
        // ===============================
        $desas = [

            // ===============================
            // KECAMATAN BOJONGASIH
            // ===============================
            [
                'nama_desa' => 'Desa Bojongasih',
                'nama_kades' => 'Kepala Desa Bojongasih',
                'kode_desa' => 'DS001',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560001',
            ],
            [
                'nama_desa' => 'Desa Cikadongdong',
                'nama_kades' => 'Kepala Desa Cikadongdong',
                'kode_desa' => 'DS002',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560002',
            ],
            [
                'nama_desa' => 'Desa Girijaya',
                'nama_kades' => 'Kepala Desa Girijaya',
                'kode_desa' => 'DS003',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560003',
            ],
            [
                'nama_desa' => 'Desa Mertajaya',
                'nama_kades' => 'Kepala Desa Mertajaya',
                'kode_desa' => 'DS004',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560004',
            ],
            [
                'nama_desa' => 'Desa Sindangsari',
                'nama_kades' => 'Kepala Desa Sindangsari',
                'kode_desa' => 'DS005',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560005',
            ],
            [
                'nama_desa' => 'Desa Toblongan',
                'nama_kades' => 'Kepala Desa Toblongan',
                'kode_desa' => 'DS006',
                'alamat_kantor' => 'Kec. Bojongasih',
                'no_telp' => '081234560006',
            ],

            // ===============================
            // KECAMATAN BOJONGGAMBIR
            // ===============================
            [
                'nama_desa' => 'Desa Bojonggambir',
                'nama_kades' => 'Kepala Desa Bojonggambir',
                'kode_desa' => 'DS007',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560007',
            ],
            [
                'nama_desa' => 'Desa Bojongkapol',
                'nama_kades' => 'Kepala Desa Bojongkapol',
                'kode_desa' => 'DS008',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560008',
            ],
            [
                'nama_desa' => 'Desa Campakasari',
                'nama_kades' => 'Kepala Desa Campakasari',
                'kode_desa' => 'DS009',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560009',
            ],
            [
                'nama_desa' => 'Desa Ciroyom',
                'nama_kades' => 'Kepala Desa Ciroyom',
                'kode_desa' => 'DS010',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560010',
            ],
            [
                'nama_desa' => 'Desa Girimukti',
                'nama_kades' => 'Kepala Desa Girimukti',
                'kode_desa' => 'DS011',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560011',
            ],
            [
                'nama_desa' => 'Desa Kertanegla',
                'nama_kades' => 'Kepala Desa Kertanegla',
                'kode_desa' => 'DS012',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560012',
            ],
            [
                'nama_desa' => 'Desa Mangkonjaya',
                'nama_kades' => 'Kepala Desa Mangkonjaya',
                'kode_desa' => 'DS013',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560013',
            ],
            [
                'nama_desa' => 'Desa Pedangkamulyan',
                'nama_kades' => 'Kepala Desa Pedangkamulyan',
                'kode_desa' => 'DS014',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560014',
            ],
            [
                'nama_desa' => 'Desa Purwaraharja',
                'nama_kades' => 'Kepala Desa Purwaraharja',
                'kode_desa' => 'DS015',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560015',
            ],
            [
                'nama_desa' => 'Desa Wandasari',
                'nama_kades' => 'Kepala Desa Wandasari',
                'kode_desa' => 'DS016',
                'alamat_kantor' => 'Kec. Bojonggambir',
                'no_telp' => '081234560016',
            ],

            // ===============================
            // KECAMATAN CIGALONTANG
            // ===============================
            [
                'nama_desa' => 'Desa Cigalontang',
                'nama_kades' => 'Kepala Desa Cigalontang',
                'kode_desa' => 'DS017',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560017',
            ],
            [
                'nama_desa' => 'Desa Jayapura',
                'nama_kades' => 'Kepala Desa Jayapura',
                'kode_desa' => 'DS018',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560018',
            ],
            // ===============================
            // KECAMATAN BANTARKALONG
            // ===============================
            [
                'nama_desa' => 'Desa Hegarwangi',
                'nama_kades' => 'Kepala Desa Hegarwangi',
                'kode_desa' => 'DS019',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560019',
            ],
            [
                'nama_desa' => 'Desa Pamijahan',
                'nama_kades' => 'Kepala Desa Pamijahan',
                'kode_desa' => 'DS020',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560020',
            ],
            [
                'nama_desa' => 'Desa Parakanhonje',
                'nama_kades' => 'Kepala Desa Parakanhonje',
                'kode_desa' => 'DS021',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560021',
            ],
            [
                'nama_desa' => 'Desa Simpang',
                'nama_kades' => 'Kepala Desa Simpang',
                'kode_desa' => 'DS022',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560022',
            ],
            [
                'nama_desa' => 'Desa Sirnagalih',
                'nama_kades' => 'Kepala Desa Sirnagalih',
                'kode_desa' => 'DS023',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560023',
            ],
            [
                'nama_desa' => 'Desa Sukamaju',
                'nama_kades' => 'Kepala Desa Sukamaju',
                'kode_desa' => 'DS024',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560024',
            ],
            [
                'nama_desa' => 'Desa Wakap',
                'nama_kades' => 'Kepala Desa Wakap',
                'kode_desa' => 'DS025',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560025',
            ],
            [
                'nama_desa' => 'Desa Wangunsari',
                'nama_kades' => 'Kepala Desa Wangunsari',
                'kode_desa' => 'DS026',
                'alamat_kantor' => 'Kec. Bantarkalong',
                'no_telp' => '081234560026',
            ],


            // ===============================
            // KECAMATAN CIAWI
            // ===============================
            [
                'nama_desa' => 'Desa Bugel',
                'nama_kades' => 'Kepala Desa Bugel',
                'kode_desa' => 'DS027',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560027',
            ],
            [
                'nama_desa' => 'Desa Ciawi',
                'nama_kades' => 'Kepala Desa Ciawi',
                'kode_desa' => 'DS028',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560028',
            ],
            [
                'nama_desa' => 'Desa Citamba',
                'nama_kades' => 'Kepala Desa Citamba',
                'kode_desa' => 'DS029',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560029',
            ],
            [
                'nama_desa' => 'Desa Gombong',
                'nama_kades' => 'Kepala Desa Gombong',
                'kode_desa' => 'DS030',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560030',
            ],
            [
                'nama_desa' => 'Desa Kertamukti',
                'nama_kades' => 'Kepala Desa Kertamukti',
                'kode_desa' => 'DS031',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560031',
            ],
            [
                'nama_desa' => 'Desa Kurniabakti',
                'nama_kades' => 'Kepala Desa Kurniabakti',
                'kode_desa' => 'DS032',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560032',
            ],
            [
                'nama_desa' => 'Desa Margasari',
                'nama_kades' => 'Kepala Desa Margasari',
                'kode_desa' => 'DS033',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560033',
            ],
            [
                'nama_desa' => 'Desa Pakamitankidul',
                'nama_kades' => 'Kepala Desa Pakamitankidul',
                'kode_desa' => 'DS034',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560034',
            ],
            [
                'nama_desa' => 'Desa Pakemitan',
                'nama_kades' => 'Kepala Desa Pakemitan',
                'kode_desa' => 'DS035',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560035',
            ],
            [
                'nama_desa' => 'Desa Pasirhuni',
                'nama_kades' => 'Kepala Desa Pasirhuni',
                'kode_desa' => 'DS036',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560036',
            ],
            [
                'nama_desa' => 'Desa Sukamantri',
                'nama_kades' => 'Kepala Desa Sukamantri',
                'kode_desa' => 'DS037',
                'alamat_kantor' => 'Kec. Ciawi',
                'no_telp' => '081234560037',
            ],


            // ===============================
            // KECAMATAN CIBALONG
            // ===============================
            [
                'nama_desa' => 'Desa Cibalong',
                'nama_kades' => 'Kepala Desa Cibalong',
                'kode_desa' => 'DS038',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560038',
            ],
            [
                'nama_desa' => 'Desa Cisempur',
                'nama_kades' => 'Kepala Desa Cisempur',
                'kode_desa' => 'DS039',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560039',
            ],
            [
                'nama_desa' => 'Desa Eureunpalay',
                'nama_kades' => 'Kepala Desa Eureunpalay',
                'kode_desa' => 'DS040',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560040',
            ],
            [
                'nama_desa' => 'Desa Parung',
                'nama_kades' => 'Kepala Desa Parung',
                'kode_desa' => 'DS041',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560041',
            ],
            [
                'nama_desa' => 'Desa Setiawaras',
                'nama_kades' => 'Kepala Desa Setiawaras',
                'kode_desa' => 'DS042',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560042',
            ],
            [
                'nama_desa' => 'Desa Singajaya',
                'nama_kades' => 'Kepala Desa Singajaya',
                'kode_desa' => 'DS043',
                'alamat_kantor' => 'Kec. Cibalong',
                'no_telp' => '081234560043',
            ],


            // ===============================
            // KECAMATAN CIKALONG
            // ===============================
            [
                'nama_desa' => 'Desa Cibeber',
                'nama_kades' => 'Kepala Desa Cibeber',
                'kode_desa' => 'DS044',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560044',
            ],
            [
                'nama_desa' => 'Desa Cidadali',
                'nama_kades' => 'Kepala Desa Cidadali',
                'kode_desa' => 'DS045',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560045',
            ],
            [
                'nama_desa' => 'Desa Cikadu',
                'nama_kades' => 'Kepala Desa Cikadu',
                'kode_desa' => 'DS046',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560046',
            ],
            [
                'nama_desa' => 'Desa Cikalong',
                'nama_kades' => 'Kepala Desa Cikalong',
                'kode_desa' => 'DS047',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560047',
            ],
            [
                'nama_desa' => 'Desa Cikancra',
                'nama_kades' => 'Kepala Desa Cikancra',
                'kode_desa' => 'DS048',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560048',
            ],
            [
                'nama_desa' => 'Desa Cimanuk',
                'nama_kades' => 'Kepala Desa Cimanuk',
                'kode_desa' => 'DS049',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560049',
            ],
            [
                'nama_desa' => 'Desa Kalapagenep',
                'nama_kades' => 'Kepala Desa Kalapagenep',
                'kode_desa' => 'DS050',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560050',
            ],
            [
                'nama_desa' => 'Desa Kubangsari',
                'nama_kades' => 'Kepala Desa Kubangsari',
                'kode_desa' => 'DS051',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560051',
            ],
            [
                'nama_desa' => 'Desa Mandalajaya',
                'nama_kades' => 'Kepala Desa Mandalajaya',
                'kode_desa' => 'DS052',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560052',
            ],
            [
                'nama_desa' => 'Desa Panyiaran',
                'nama_kades' => 'Kepala Desa Panyiaran',
                'kode_desa' => 'DS053',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560053',
            ],
            [
                'nama_desa' => 'Desa Sindangjaya',
                'nama_kades' => 'Kepala Desa Sindangjaya',
                'kode_desa' => 'DS054',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560054',
            ],
            [
                'nama_desa' => 'Desa Singkir',
                'nama_kades' => 'Kepala Desa Singkir',
                'kode_desa' => 'DS055',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560055',
            ],
            [
                'nama_desa' => 'Desa Tonjongsari',
                'nama_kades' => 'Kepala Desa Tonjongsari',
                'kode_desa' => 'DS056',
                'alamat_kantor' => 'Kec. Cikalong',
                'no_telp' => '081234560056',
            ],

            // ===============================
            // KECAMATAN GUNUNGTANJUNG
            // ===============================
            [
                'nama_desa' => 'Desa Bojongsari',
                'nama_kades' => 'Kepala Desa Bojongsari',
                'kode_desa' => 'DS109',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560109',
            ],
            [
                'nama_desa' => 'Desa Cinunjang',
                'nama_kades' => 'Kepala Desa Cinunjang',
                'kode_desa' => 'DS110',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560110',
            ],
            [
                'nama_desa' => 'Desa Giriwangi',
                'nama_kades' => 'Kepala Desa Giriwangi',
                'kode_desa' => 'DS111',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560111',
            ],
            [
                'nama_desa' => 'Desa Gunungtanjung',
                'nama_kades' => 'Kepala Desa Gunungtanjung',
                'kode_desa' => 'DS112',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560112',
            ],
            [
                'nama_desa' => 'Desa Jatijaya',
                'nama_kades' => 'Kepala Desa Jatijaya',
                'kode_desa' => 'DS113',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560113',
            ],
            [
                'nama_desa' => 'Desa Malatisuka',
                'nama_kades' => 'Kepala Desa Malatisuka',
                'kode_desa' => 'DS114',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560114',
            ],
            [
                'nama_desa' => 'Desa Tanjungsari',
                'nama_kades' => 'Kepala Desa Tanjungsari',
                'kode_desa' => 'DS115',
                'alamat_kantor' => 'Kec. Gunungtanjung',
                'no_telp' => '081234560115',
            ],


            // ===============================
            // KECAMATAN JAMANIS
            // ===============================
            [
                'nama_desa' => 'Desa Bojonggaok',
                'nama_kades' => 'Kepala Desa Bojonggaok',
                'kode_desa' => 'DS116',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560116',
            ],
            [
                'nama_desa' => 'Desa Condong',
                'nama_kades' => 'Kepala Desa Condong',
                'kode_desa' => 'DS117',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560117',
            ],
            [
                'nama_desa' => 'Desa Geresik',
                'nama_kades' => 'Kepala Desa Geresik',
                'kode_desa' => 'DS118',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560118',
            ],
            [
                'nama_desa' => 'Desa Karangmulya',
                'nama_kades' => 'Kepala Desa Karangmulya',
                'kode_desa' => 'DS119',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560119',
            ],
            [
                'nama_desa' => 'Desa Karangresik',
                'nama_kades' => 'Kepala Desa Karangresik',
                'kode_desa' => 'DS120',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560120',
            ],
            [
                'nama_desa' => 'Desa Karangsembung',
                'nama_kades' => 'Kepala Desa Karangsembung',
                'kode_desa' => 'DS121',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560121',
            ],
            [
                'nama_desa' => 'Desa Sindangraja',
                'nama_kades' => 'Kepala Desa Sindangraja',
                'kode_desa' => 'DS122',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560122',
            ],
            [
                'nama_desa' => 'Desa Tanjungmekar',
                'nama_kades' => 'Kepala Desa Tanjungmekar',
                'kode_desa' => 'DS123',
                'alamat_kantor' => 'Kec. Jamanis',
                'no_telp' => '081234560123',
            ],


            // ===============================
            // KECAMATAN JATIWARAS
            // ===============================
            [
                'nama_desa' => 'Desa Ciwarak',
                'nama_kades' => 'Kepala Desa Ciwarak',
                'kode_desa' => 'DS124',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560124',
            ],
            [
                'nama_desa' => 'Desa Jatiwaras',
                'nama_kades' => 'Kepala Desa Jatiwaras',
                'kode_desa' => 'DS125',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560125',
            ],
            [
                'nama_desa' => 'Desa Kaputihan',
                'nama_kades' => 'Kepala Desa Kaputihan',
                'kode_desa' => 'DS126',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560126',
            ],
            [
                'nama_desa' => 'Desa Kersagalih',
                'nama_kades' => 'Kepala Desa Kersagalih',
                'kode_desa' => 'DS127',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560127',
            ],
            [
                'nama_desa' => 'Desa Kertarahayu',
                'nama_kades' => 'Kepala Desa Kertarahayu',
                'kode_desa' => 'DS128',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560128',
            ],
            [
                'nama_desa' => 'Desa Mandalahurip',
                'nama_kades' => 'Kepala Desa Mandalahurip',
                'kode_desa' => 'DS129',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560129',
            ],
            [
                'nama_desa' => 'Desa Mandalamekar',
                'nama_kades' => 'Kepala Desa Mandalamekar',
                'kode_desa' => 'DS130',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560130',
            ],
            [
                'nama_desa' => 'Desa Neglasari',
                'nama_kades' => 'Kepala Desa Neglasari',
                'kode_desa' => 'DS131',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560131',
            ],
            [
                'nama_desa' => 'Desa Papayan',
                'nama_kades' => 'Kepala Desa Papayan',
                'kode_desa' => 'DS132',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560132',
            ],
            [
                'nama_desa' => 'Desa Setiawangi',
                'nama_kades' => 'Kepala Desa Setiawangi',
                'kode_desa' => 'DS133',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560133',
            ],
            [
                'nama_desa' => 'Desa Sukakerta',
                'nama_kades' => 'Kepala Desa Sukakerta',
                'kode_desa' => 'DS134',
                'alamat_kantor' => 'Kec. Jatiwaras',
                'no_telp' => '081234560134',
            ],


            // ===============================
            // KECAMATAN KADIPATEN
            // ===============================
            [
                'nama_desa' => 'Desa Buniasih',
                'nama_kades' => 'Kepala Desa Buniasih',
                'kode_desa' => 'DS135',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560135',
            ],
            [
                'nama_desa' => 'Desa Cibahayu',
                'nama_kades' => 'Kepala Desa Cibahayu',
                'kode_desa' => 'DS136',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560136',
            ],
            [
                'nama_desa' => 'Desa Dirgahayu',
                'nama_kades' => 'Kepala Desa Dirgahayu',
                'kode_desa' => 'DS137',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560137',
            ],
            [
                'nama_desa' => 'Desa Kadipaten',
                'nama_kades' => 'Kepala Desa Kadipaten',
                'kode_desa' => 'DS138',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560138',
            ],
            [
                'nama_desa' => 'Desa Mekarsari',
                'nama_kades' => 'Kepala Desa Mekarsari',
                'kode_desa' => 'DS139',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560139',
            ],
            [
                'nama_desa' => 'Desa Pamoyanan',
                'nama_kades' => 'Kepala Desa Pamoyanan',
                'kode_desa' => 'DS140',
                'alamat_kantor' => 'Kec. Kadipaten',
                'no_telp' => '081234560140',
            ],


            // ===============================
            // KECAMATAN KARANGJAYA
            // ===============================
            [
                'nama_desa' => 'Desa Citalahab',
                'nama_kades' => 'Kepala Desa Citalahab',
                'kode_desa' => 'DS141',
                'alamat_kantor' => 'Kec. Karangjaya',
                'no_telp' => '081234560141',
            ],
            [
                'nama_desa' => 'Desa Karangjaya',
                'nama_kades' => 'Kepala Desa Karangjaya',
                'kode_desa' => 'DS142',
                'alamat_kantor' => 'Kec. Karangjaya',
                'no_telp' => '081234560142',
            ],
            [
                'nama_desa' => 'Desa Karanglayung',
                'nama_kades' => 'Kepala Desa Karanglayung',
                'kode_desa' => 'DS143',
                'alamat_kantor' => 'Kec. Karangjaya',
                'no_telp' => '081234560143',
            ],
            [
                'nama_desa' => 'Desa Sirnajaya',
                'nama_kades' => 'Kepala Desa Sirnajaya',
                'kode_desa' => 'DS144',
                'alamat_kantor' => 'Kec. Karangjaya',
                'no_telp' => '081234560144',
            ],
            // ===============================
            // KECAMATAN KARANGNUNGGAL
            // ===============================
            [
                'nama_desa' => 'Desa Ciawi',
                'nama_kades' => 'Kepala Desa Ciawi',
                'kode_desa' => 'DS145',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560145',
            ],
            [
                'nama_desa' => 'Desa Cibatu',
                'nama_kades' => 'Kepala Desa Cibatu',
                'kode_desa' => 'DS146',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560146',
            ],
            [
                'nama_desa' => 'Desa Cibatuireng',
                'nama_kades' => 'Kepala Desa Cibatuireng',
                'kode_desa' => 'DS147',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560147',
            ],
            [
                'nama_desa' => 'Desa Cidadap',
                'nama_kades' => 'Kepala Desa Cidadap',
                'kode_desa' => 'DS148',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560148',
            ],
            [
                'nama_desa' => 'Desa Cikapinis',
                'nama_kades' => 'Kepala Desa Cikapinis',
                'kode_desa' => 'DS149',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560149',
            ],
            [
                'nama_desa' => 'Desa Cikukulu',
                'nama_kades' => 'Kepala Desa Cikukulu',
                'kode_desa' => 'DS150',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560150',
            ],
            [
                'nama_desa' => 'Desa Cikupa',
                'nama_kades' => 'Kepala Desa Cikupa',
                'kode_desa' => 'DS151',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560151',
            ],
            [
                'nama_desa' => 'Desa Cintawangi',
                'nama_kades' => 'Kepala Desa Cintawangi',
                'kode_desa' => 'DS152',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560152',
            ],
            [
                'nama_desa' => 'Desa Karangmekar',
                'nama_kades' => 'Kepala Desa Karangmekar',
                'kode_desa' => 'DS153',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560153',
            ],
            [
                'nama_desa' => 'Desa Karangnunggal',
                'nama_kades' => 'Kepala Desa Karangnunggal',
                'kode_desa' => 'DS154',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560154',
            ],
            [
                'nama_desa' => 'Desa Kujang',
                'nama_kades' => 'Kepala Desa Kujang',
                'kode_desa' => 'DS155',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560155',
            ],
            [
                'nama_desa' => 'Desa Sarimanggu',
                'nama_kades' => 'Kepala Desa Sarimanggu',
                'kode_desa' => 'DS156',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560156',
            ],
            [
                'nama_desa' => 'Desa Sarimukti',
                'nama_kades' => 'Kepala Desa Sarimukti',
                'kode_desa' => 'DS157',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560157',
            ],
            [
                'nama_desa' => 'Desa Sukawangun',
                'nama_kades' => 'Kepala Desa Sukawangun',
                'kode_desa' => 'DS158',
                'alamat_kantor' => 'Kec. Karangnunggal',
                'no_telp' => '081234560158',
            ],


            // ===============================
            // KECAMATAN LEUWISARI
            // ===============================
            [
                'nama_desa' => 'Desa Arjasari',
                'nama_kades' => 'Kepala Desa Arjasari',
                'kode_desa' => 'DS159',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560159',
            ],
            [
                'nama_desa' => 'Desa Ciawang',
                'nama_kades' => 'Kepala Desa Ciawang',
                'kode_desa' => 'DS160',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560160',
            ],
            [
                'nama_desa' => 'Desa Cigadog',
                'nama_kades' => 'Kepala Desa Cigadog',
                'kode_desa' => 'DS161',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560161',
            ],
            [
                'nama_desa' => 'Desa Jayamukti',
                'nama_kades' => 'Kepala Desa Jayamukti',
                'kode_desa' => 'DS162',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560162',
            ],
            [
                'nama_desa' => 'Desa Linggamulya',
                'nama_kades' => 'Kepala Desa Linggamulya',
                'kode_desa' => 'DS163',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560163',
            ],
            [
                'nama_desa' => 'Desa Linggawangi',
                'nama_kades' => 'Kepala Desa Linggawangi',
                'kode_desa' => 'DS164',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560164',
            ],
            [
                'nama_desa' => 'Desa Mandalagiri',
                'nama_kades' => 'Kepala Desa Mandalagiri',
                'kode_desa' => 'DS165',
                'alamat_kantor' => 'Kec. Leuwisari',
                'no_telp' => '081234560165',
            ],


            // ===============================
            // KECAMATAN MANGUNREJA
            // ===============================
            [
                'nama_desa' => 'Desa Mangunreja',
                'nama_kades' => 'Kepala Desa Mangunreja',
                'kode_desa' => 'DS166',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560166',
            ],
            [
                'nama_desa' => 'Desa Margajaya',
                'nama_kades' => 'Kepala Desa Margajaya',
                'kode_desa' => 'DS167',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560167',
            ],
            [
                'nama_desa' => 'Desa Pasirsalam',
                'nama_kades' => 'Kepala Desa Pasirsalam',
                'kode_desa' => 'DS168',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560168',
            ],
            [
                'nama_desa' => 'Desa Salebu',
                'nama_kades' => 'Kepala Desa Salebu',
                'kode_desa' => 'DS169',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560169',
            ],
            [
                'nama_desa' => 'Desa Sukaluyu',
                'nama_kades' => 'Kepala Desa Sukaluyu',
                'kode_desa' => 'DS170',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560170',
            ],
            [
                'nama_desa' => 'Desa Sukasukur',
                'nama_kades' => 'Kepala Desa Sukasukur',
                'kode_desa' => 'DS171',
                'alamat_kantor' => 'Kec. Mangunreja',
                'no_telp' => '081234560171',
            ],


            // ===============================
            // KECAMATAN MANONJAYA
            // ===============================
            [
                'nama_desa' => 'Desa Batusumur',
                'nama_kades' => 'Kepala Desa Batusumur',
                'kode_desa' => 'DS172',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560172',
            ],
            [
                'nama_desa' => 'Desa Cibeber',
                'nama_kades' => 'Kepala Desa Cibeber',
                'kode_desa' => 'DS173',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560173',
            ],
            [
                'nama_desa' => 'Desa Cihaur',
                'nama_kades' => 'Kepala Desa Cihaur',
                'kode_desa' => 'DS174',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560174',
            ],
            [
                'nama_desa' => 'Desa Cilangkap',
                'nama_kades' => 'Kepala Desa Cilangkap',
                'kode_desa' => 'DS175',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560175',
            ],
            [
                'nama_desa' => 'Desa Gunajaya',
                'nama_kades' => 'Kepala Desa Gunajaya',
                'kode_desa' => 'DS176',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560176',
            ],
            [
                'nama_desa' => 'Desa Kalimanggis',
                'nama_kades' => 'Kepala Desa Kalimanggis',
                'kode_desa' => 'DS177',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560177',
            ],
            [
                'nama_desa' => 'Desa Kamulyan',
                'nama_kades' => 'Kepala Desa Kamulyan',
                'kode_desa' => 'DS178',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560178',
            ],
            [
                'nama_desa' => 'Desa Manonjaya',
                'nama_kades' => 'Kepala Desa Manonjaya',
                'kode_desa' => 'DS179',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560179',
            ],
            [
                'nama_desa' => 'Desa Margahayu',
                'nama_kades' => 'Kepala Desa Margahayu',
                'kode_desa' => 'DS180',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560180',
            ],
            [
                'nama_desa' => 'Desa Margaluyu',
                'nama_kades' => 'Kepala Desa Margaluyu',
                'kode_desa' => 'DS181',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560181',
            ],
            [
                'nama_desa' => 'Desa Pasirbatang',
                'nama_kades' => 'Kepala Desa Pasirbatang',
                'kode_desa' => 'DS182',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560182',
            ],
            [
                'nama_desa' => 'Desa Pasirpanjang',
                'nama_kades' => 'Kepala Desa Pasirpanjang',
                'kode_desa' => 'DS183',
                'alamat_kantor' => 'Kec. Manonjaya',
                'no_telp' => '081234560183',
            ],
            // ===============================
            // KECAMATAN PADAKEMBANG
            // ===============================
            [
                'nama_desa' => 'Desa Cilampunghilir',
                'nama_kades' => 'Kepala Desa Cilampunghilir',
                'kode_desa' => 'DS184',
                'alamat_kantor' => 'Kec. Padakembang',
                'no_telp' => '081234560184',
            ],
            [
                'nama_desa' => 'Desa Cisaruni',
                'nama_kades' => 'Kepala Desa Cisaruni',
                'kode_desa' => 'DS185',
                'alamat_kantor' => 'Kec. Padakembang',
                'no_telp' => '081234560185',
            ],
            [
                'nama_desa' => 'Desa Mekarjaya',
                'nama_kades' => 'Kepala Desa Mekarjaya',
                'kode_desa' => 'DS186',
                'alamat_kantor' => 'Kec. Padakembang',
                'no_telp' => '081234560186',
            ],
            [
                'nama_desa' => 'Desa Padakembang',
                'nama_kades' => 'Kepala Desa Padakembang',
                'kode_desa' => 'DS187',
                'alamat_kantor' => 'Kec. Padakembang',
                'no_telp' => '081234560187',
            ],
            [
                'nama_desa' => 'Desa Rancapaku',
                'nama_kades' => 'Kepala Desa Rancapaku',
                'kode_desa' => 'DS188',
                'alamat_kantor' => 'Kec. Padakembang',
                'no_telp' => '081234560188',
            ],


            // ===============================
            // KECAMATAN PAGERAGEUNG
            // ===============================
            [
                'nama_desa' => 'Desa Cipacing',
                'nama_kades' => 'Kepala Desa Cipacing',
                'kode_desa' => 'DS189',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560189',
            ],
            [
                'nama_desa' => 'Desa Guranteng',
                'nama_kades' => 'Kepala Desa Guranteng',
                'kode_desa' => 'DS190',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560190',
            ],
            [
                'nama_desa' => 'Desa Nanggewer',
                'nama_kades' => 'Kepala Desa Nanggewer',
                'kode_desa' => 'DS191',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560191',
            ],
            [
                'nama_desa' => 'Desa Pagerageung',
                'nama_kades' => 'Kepala Desa Pagerageung',
                'kode_desa' => 'DS192',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560192',
            ],
            [
                'nama_desa' => 'Desa Pagersari',
                'nama_kades' => 'Kepala Desa Pagersari',
                'kode_desa' => 'DS193',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560193',
            ],
            [
                'nama_desa' => 'Desa Puteran',
                'nama_kades' => 'Kepala Desa Puteran',
                'kode_desa' => 'DS194',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560194',
            ],
            [
                'nama_desa' => 'Desa Sukadana',
                'nama_kades' => 'Kepala Desa Sukadana',
                'kode_desa' => 'DS195',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560195',
            ],
            [
                'nama_desa' => 'Desa Sukamaju',
                'nama_kades' => 'Kepala Desa Sukamaju',
                'kode_desa' => 'DS196',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560196',
            ],
            [
                'nama_desa' => 'Desa Sukapada',
                'nama_kades' => 'Kepala Desa Sukapada',
                'kode_desa' => 'DS197',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560197',
            ],
            [
                'nama_desa' => 'Desa Tanjungkerta',
                'nama_kades' => 'Kepala Desa Tanjungkerta',
                'kode_desa' => 'DS198',
                'alamat_kantor' => 'Kec. Pagerageung',
                'no_telp' => '081234560198',
            ],


            // ===============================
            // KECAMATAN PANCATENGAH
            // ===============================
            [
                'nama_desa' => 'Desa Cibongas',
                'nama_kades' => 'Kepala Desa Cibongas',
                'kode_desa' => 'DS199',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560199',
            ],
            [
                'nama_desa' => 'Desa Cibuniasih',
                'nama_kades' => 'Kepala Desa Cibuniasih',
                'kode_desa' => 'DS200',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560200',
            ],
            [
                'nama_desa' => 'Desa Cikawung',
                'nama_kades' => 'Kepala Desa Cikawung',
                'kode_desa' => 'DS201',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560201',
            ],
            [
                'nama_desa' => 'Desa Jayamukti',
                'nama_kades' => 'Kepala Desa Jayamukti',
                'kode_desa' => 'DS202',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560202',
            ],
            [
                'nama_desa' => 'Desa Margaluyu',
                'nama_kades' => 'Kepala Desa Margaluyu',
                'kode_desa' => 'DS203',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560203',
            ],
            [
                'nama_desa' => 'Desa Mekarsari',
                'nama_kades' => 'Kepala Desa Mekarsari',
                'kode_desa' => 'DS204',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560204',
            ],
            [
                'nama_desa' => 'Desa Neglasari',
                'nama_kades' => 'Kepala Desa Neglasari',
                'kode_desa' => 'DS205',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560205',
            ],
            [
                'nama_desa' => 'Desa Pancawangi',
                'nama_kades' => 'Kepala Desa Pancawangi',
                'kode_desa' => 'DS206',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560206',
            ],
            [
                'nama_desa' => 'Desa Pangliaran',
                'nama_kades' => 'Kepala Desa Pangliaran',
                'kode_desa' => 'DS207',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560207',
            ],
            [
                'nama_desa' => 'Desa Tawang',
                'nama_kades' => 'Kepala Desa Tawang',
                'kode_desa' => 'DS208',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560208',
            ],
            [
                'nama_desa' => 'Desa Tonjong',
                'nama_kades' => 'Kepala Desa Tonjong',
                'kode_desa' => 'DS209',
                'alamat_kantor' => 'Kec. Pancatengah',
                'no_telp' => '081234560209',
            ],


            // ===============================
            // KECAMATAN PARUNGPONTENG
            // ===============================
            [
                'nama_desa' => 'Desa Barumekar',
                'nama_kades' => 'Kepala Desa Barumekar',
                'kode_desa' => 'DS210',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560210',
            ],
            [
                'nama_desa' => 'Desa Burujuljaya',
                'nama_kades' => 'Kepala Desa Burujuljaya',
                'kode_desa' => 'DS211',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560211',
            ],
            [
                'nama_desa' => 'Desa Cibanteng',
                'nama_kades' => 'Kepala Desa Cibanteng',
                'kode_desa' => 'DS212',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560212',
            ],
            [
                'nama_desa' => 'Desa Cibungur',
                'nama_kades' => 'Kepala Desa Cibungur',
                'kode_desa' => 'DS213',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560213',
            ],
            [
                'nama_desa' => 'Desa Cigunung',
                'nama_kades' => 'Kepala Desa Cigunung',
                'kode_desa' => 'DS214',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560214',
            ],
            [
                'nama_desa' => 'Desa Girikencana',
                'nama_kades' => 'Kepala Desa Girikencana',
                'kode_desa' => 'DS215',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560215',
            ],
            [
                'nama_desa' => 'Desa Karyabakti',
                'nama_kades' => 'Kepala Desa Karyabakti',
                'kode_desa' => 'DS216',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560216',
            ],
            [
                'nama_desa' => 'Desa Parungponteng',
                'nama_kades' => 'Kepala Desa Parungponteng',
                'kode_desa' => 'DS217',
                'alamat_kantor' => 'Kec. Parungponteng',
                'no_telp' => '081234560217',
            ],
            // ===============================
            // KECAMATAN PUSPAHIANG
            // ===============================
            [
                'nama_desa' => 'Desa Cimanggu',
                'nama_kades' => 'Kepala Desa Cimanggu',
                'kode_desa' => 'DS218',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560218',
            ],
            [
                'nama_desa' => 'Desa Luyubakti',
                'nama_kades' => 'Kepala Desa Luyubakti',
                'kode_desa' => 'DS219',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560219',
            ],
            [
                'nama_desa' => 'Desa Mandalasari',
                'nama_kades' => 'Kepala Desa Mandalasari',
                'kode_desa' => 'DS220',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560220',
            ],
            [
                'nama_desa' => 'Desa Puspahiang',
                'nama_kades' => 'Kepala Desa Puspahiang',
                'kode_desa' => 'DS221',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560221',
            ],
            [
                'nama_desa' => 'Desa Puspajaya',
                'nama_kades' => 'Kepala Desa Puspajaya',
                'kode_desa' => 'DS222',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560222',
            ],
            [
                'nama_desa' => 'Desa Pusparahayu',
                'nama_kades' => 'Kepala Desa Pusparahayu',
                'kode_desa' => 'DS223',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560223',
            ],
            [
                'nama_desa' => 'Desa Puspasari',
                'nama_kades' => 'Kepala Desa Puspasari',
                'kode_desa' => 'DS224',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560224',
            ],
            [
                'nama_desa' => 'Desa Sukasari',
                'nama_kades' => 'Kepala Desa Sukasari',
                'kode_desa' => 'DS225',
                'alamat_kantor' => 'Kec. Puspahiang',
                'no_telp' => '081234560225',
            ],


            // ===============================
            // KECAMATAN RAJAPOLAH
            // ===============================
            [
                'nama_desa' => 'Desa Dawagung',
                'nama_kades' => 'Kepala Desa Dawagung',
                'kode_desa' => 'DS226',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560226',
            ],
            [
                'nama_desa' => 'Desa Manggungjaya',
                'nama_kades' => 'Kepala Desa Manggungjaya',
                'kode_desa' => 'DS227',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560227',
            ],
            [
                'nama_desa' => 'Desa Manggungsari',
                'nama_kades' => 'Kepala Desa Manggungsari',
                'kode_desa' => 'DS228',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560228',
            ],
            [
                'nama_desa' => 'Desa Rajamandala',
                'nama_kades' => 'Kepala Desa Rajamandala',
                'kode_desa' => 'DS229',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560229',
            ],
            [
                'nama_desa' => 'Desa Rajapolah',
                'nama_kades' => 'Kepala Desa Rajapolah',
                'kode_desa' => 'DS230',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560230',
            ],
            [
                'nama_desa' => 'Desa Sukanagalih',
                'nama_kades' => 'Kepala Desa Sukanagalih',
                'kode_desa' => 'DS231',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560231',
            ],
            [
                'nama_desa' => 'Desa Sukaraja',
                'nama_kades' => 'Kepala Desa Sukaraja',
                'kode_desa' => 'DS232',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560232',
            ],
            [
                'nama_desa' => 'Desa Tanjungpura',
                'nama_kades' => 'Kepala Desa Tanjungpura',
                'kode_desa' => 'DS233',
                'alamat_kantor' => 'Kec. Rajapolah',
                'no_telp' => '081234560233',
            ],


            // ===============================
            // KECAMATAN SALAWU
            // ===============================
            [
                'nama_desa' => 'Desa Jahiang',
                'nama_kades' => 'Kepala Desa Jahiang',
                'kode_desa' => 'DS234',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560234',
            ],
            [
                'nama_desa' => 'Desa Karangmukti',
                'nama_kades' => 'Kepala Desa Karangmukti',
                'kode_desa' => 'DS235',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560235',
            ],
            [
                'nama_desa' => 'Desa Kawungsari',
                'nama_kades' => 'Kepala Desa Kawungsari',
                'kode_desa' => 'DS236',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560236',
            ],
            [
                'nama_desa' => 'Desa Kutawaringin',
                'nama_kades' => 'Kepala Desa Kutawaringin',
                'kode_desa' => 'DS237',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560237',
            ],
            [
                'nama_desa' => 'Desa Margalaksana',
                'nama_kades' => 'Kepala Desa Margalaksana',
                'kode_desa' => 'DS238',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560238',
            ],
            [
                'nama_desa' => 'Desa Neglasari',
                'nama_kades' => 'Kepala Desa Neglasari',
                'kode_desa' => 'DS239',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560239',
            ],
            [
                'nama_desa' => 'Desa Salawu',
                'nama_kades' => 'Kepala Desa Salawu',
                'kode_desa' => 'DS240',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560240',
            ],
            [
                'nama_desa' => 'Desa Serang',
                'nama_kades' => 'Kepala Desa Serang',
                'kode_desa' => 'DS241',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560241',
            ],
            [
                'nama_desa' => 'Desa Sukarasa',
                'nama_kades' => 'Kepala Desa Sukarasa',
                'kode_desa' => 'DS242',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560242',
            ],
            [
                'nama_desa' => 'Desa Sundawenang',
                'nama_kades' => 'Kepala Desa Sundawenang',
                'kode_desa' => 'DS243',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560243',
            ],
            [
                'nama_desa' => 'Desa Tanjungsari',
                'nama_kades' => 'Kepala Desa Tanjungsari',
                'kode_desa' => 'DS244',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560244',
            ],
            [
                'nama_desa' => 'Desa Tenjowaringin',
                'nama_kades' => 'Kepala Desa Tenjowaringin',
                'kode_desa' => 'DS245',
                'alamat_kantor' => 'Kec. Salawu',
                'no_telp' => '081234560245',
            ],


            // ===============================
            // KECAMATAN SALOPA
            // ===============================
            [
                'nama_desa' => 'Desa Banjarwaringin',
                'nama_kades' => 'Kepala Desa Banjarwaringin',
                'kode_desa' => 'DS246',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560246',
            ],
            [
                'nama_desa' => 'Desa Karyamandala',
                'nama_kades' => 'Kepala Desa Karyamandala',
                'kode_desa' => 'DS247',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560247',
            ],
            [
                'nama_desa' => 'Desa Karyawangi',
                'nama_kades' => 'Kepala Desa Karyawangi',
                'kode_desa' => 'DS248',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560248',
            ],
            [
                'nama_desa' => 'Desa Kawitan',
                'nama_kades' => 'Kepala Desa Kawitan',
                'kode_desa' => 'DS249',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560249',
            ],
            [
                'nama_desa' => 'Desa Mandalaguna',
                'nama_kades' => 'Kepala Desa Mandalaguna',
                'kode_desa' => 'DS250',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560250',
            ],
            [
                'nama_desa' => 'Desa Mandalahayu',
                'nama_kades' => 'Kepala Desa Mandalahayu',
                'kode_desa' => 'DS251',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560251',
            ],
            [
                'nama_desa' => 'Desa Mandalawangi',
                'nama_kades' => 'Kepala Desa Mandalawangi',
                'kode_desa' => 'DS252',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560252',
            ],
            [
                'nama_desa' => 'Desa Mulyasari',
                'nama_kades' => 'Kepala Desa Mulyasari',
                'kode_desa' => 'DS253',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560253',
            ],
            [
                'nama_desa' => 'Desa Tanjungsari',
                'nama_kades' => 'Kepala Desa Tanjungsari',
                'kode_desa' => 'DS254',
                'alamat_kantor' => 'Kec. Salopa',
                'no_telp' => '081234560254',
            ],
            // ===============================
            // KECAMATAN SARIWANGI
            // ===============================
            [
                'nama_desa' => 'Desa Jayaputra',
                'nama_kades' => 'Kepala Desa Jayaputra',
                'kode_desa' => 'DS255',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560255',
            ],
            [
                'nama_desa' => 'Desa Jayaratu',
                'nama_kades' => 'Kepala Desa Jayaratu',
                'kode_desa' => 'DS256',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560256',
            ],
            [
                'nama_desa' => 'Desa Linggasirna',
                'nama_kades' => 'Kepala Desa Linggasirna',
                'kode_desa' => 'DS257',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560257',
            ],
            [
                'nama_desa' => 'Desa Sariwangi',
                'nama_kades' => 'Kepala Desa Sariwangi',
                'kode_desa' => 'DS258',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560258',
            ],
            [
                'nama_desa' => 'Desa Selawangi',
                'nama_kades' => 'Kepala Desa Selawangi',
                'kode_desa' => 'DS259',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560259',
            ],
            [
                'nama_desa' => 'Desa Sirnasari',
                'nama_kades' => 'Kepala Desa Sirnasari',
                'kode_desa' => 'DS260',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560260',
            ],
            [
                'nama_desa' => 'Desa Sukaharja',
                'nama_kades' => 'Kepala Desa Sukaharja',
                'kode_desa' => 'DS261',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560261',
            ],
            [
                'nama_desa' => 'Desa Sukamulih',
                'nama_kades' => 'Kepala Desa Sukamulih',
                'kode_desa' => 'DS262',
                'alamat_kantor' => 'Kec. Sariwangi',
                'no_telp' => '081234560262',
            ],


            // ===============================
            // KECAMATAN SINGAPARNA
            // ===============================
            [
                'nama_desa' => 'Desa Cikunir',
                'nama_kades' => 'Kepala Desa Cikunir',
                'kode_desa' => 'DS263',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560263',
            ],
            [
                'nama_desa' => 'Desa Cikunten',
                'nama_kades' => 'Kepala Desa Cikunten',
                'kode_desa' => 'DS264',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560264',
            ],
            [
                'nama_desa' => 'Desa Cintaraja',
                'nama_kades' => 'Kepala Desa Cintaraja',
                'kode_desa' => 'DS265',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560265',
            ],
            [
                'nama_desa' => 'Desa Cipakat',
                'nama_kades' => 'Kepala Desa Cipakat',
                'kode_desa' => 'DS266',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560266',
            ],
            [
                'nama_desa' => 'Desa Cokadongdong',
                'nama_kades' => 'Kepala Desa Cokadongdong',
                'kode_desa' => 'DS267',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560267',
            ],
            [
                'nama_desa' => 'Desa Singaparna',
                'nama_kades' => 'Kepala Desa Singaparna',
                'kode_desa' => 'DS268',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560268',
            ],
            [
                'nama_desa' => 'Desa Singasari',
                'nama_kades' => 'Kepala Desa Singasari',
                'kode_desa' => 'DS269',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560269',
            ],
            [
                'nama_desa' => 'Desa Sukaasih',
                'nama_kades' => 'Kepala Desa Sukaasih',
                'kode_desa' => 'DS270',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560270',
            ],
            [
                'nama_desa' => 'Desa Sukaherang',
                'nama_kades' => 'Kepala Desa Sukaherang',
                'kode_desa' => 'DS271',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560271',
            ],
            [
                'nama_desa' => 'Desa Sukamulya',
                'nama_kades' => 'Kepala Desa Sukamulya',
                'kode_desa' => 'DS272',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560272',
            ],


            // ===============================
            // KECAMATAN SODONGHILIR
            // ===============================
            [
                'nama_desa' => 'Desa Cikalong',
                'nama_kades' => 'Kepala Desa Cikalong',
                'kode_desa' => 'DS273',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560273',
            ],
            [
                'nama_desa' => 'Desa Cipaingeun',
                'nama_kades' => 'Kepala Desa Cipaingeun',
                'kode_desa' => 'DS274',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560274',
            ],
            [
                'nama_desa' => 'Desa Cukangjayaguna',
                'nama_kades' => 'Kepala Desa Cukangjayaguna',
                'kode_desa' => 'DS275',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560275',
            ],
            [
                'nama_desa' => 'Desa Cukangkawung',
                'nama_kades' => 'Kepala Desa Cukangkawung',
                'kode_desa' => 'DS276',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560276',
            ],
            [
                'nama_desa' => 'Desa Leuwidulang',
                'nama_kades' => 'Kepala Desa Leuwidulang',
                'kode_desa' => 'DS277',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560277',
            ],
            [
                'nama_desa' => 'Desa Muncang',
                'nama_kades' => 'Kepala Desa Muncang',
                'kode_desa' => 'DS278',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560278',
            ],
            [
                'nama_desa' => 'Desa Pakalongan',
                'nama_kades' => 'Kepala Desa Pakalongan',
                'kode_desa' => 'DS279',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560279',
            ],
            [
                'nama_desa' => 'Desa Parumasan',
                'nama_kades' => 'Kepala Desa Parumasan',
                'kode_desa' => 'DS280',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560280',
            ],
            [
                'nama_desa' => 'Desa Raksajaya',
                'nama_kades' => 'Kepala Desa Raksajaya',
                'kode_desa' => 'DS281',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560281',
            ],
            [
                'nama_desa' => 'Desa Sepatnunggal',
                'nama_kades' => 'Kepala Desa Sepatnunggal',
                'kode_desa' => 'DS282',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560282',
            ],
            [
                'nama_desa' => 'Desa Sodonghilir',
                'nama_kades' => 'Kepala Desa Sodonghilir',
                'kode_desa' => 'DS283',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560283',
            ],
            [
                'nama_desa' => 'Desa Sukabakti',
                'nama_kades' => 'Kepala Desa Sukabakti',
                'kode_desa' => 'DS284',
                'alamat_kantor' => 'Kec. Sodonghilir',
                'no_telp' => '081234560284',
            ],


            // ===============================
            // KECAMATAN SUKAHENING
            // ===============================
            [
                'nama_desa' => 'Desa Banyurasa',
                'nama_kades' => 'Kepala Desa Banyurasa',
                'kode_desa' => 'DS285',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560285',
            ],
            [
                'nama_desa' => 'Desa Banyuresmi',
                'nama_kades' => 'Kepala Desa Banyuresmi',
                'kode_desa' => 'DS286',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560286',
            ],
            [
                'nama_desa' => 'Desa Calincing',
                'nama_kades' => 'Kepala Desa Calincing',
                'kode_desa' => 'DS287',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560287',
            ],
            [
                'nama_desa' => 'Desa Kiarajangkung',
                'nama_kades' => 'Kepala Desa Kiarajangkung',
                'kode_desa' => 'DS288',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560288',
            ],
            [
                'nama_desa' => 'Desa Kudadepa',
                'nama_kades' => 'Kepala Desa Kudadepa',
                'kode_desa' => 'DS289',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560289',
            ],
            [
                'nama_desa' => 'Desa Sukahening',
                'nama_kades' => 'Kepala Desa Sukahening',
                'kode_desa' => 'DS290',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560290',
            ],
            [
                'nama_desa' => 'Desa Sundakerta',
                'nama_kades' => 'Kepala Desa Sundakerta',
                'kode_desa' => 'DS291',
                'alamat_kantor' => 'Kec. Sukahening',
                'no_telp' => '081234560291',
            ],


            // ===============================
            // KECAMATAN SUKARAJA
            // ===============================
            [
                'nama_desa' => 'Desa Janggala',
                'nama_kades' => 'Kepala Desa Janggala',
                'kode_desa' => 'DS292',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560292',
            ],
            [
                'nama_desa' => 'Desa Leuwibudah',
                'nama_kades' => 'Kepala Desa Leuwibudah',
                'kode_desa' => 'DS293',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560293',
            ],
            [
                'nama_desa' => 'Desa Linggaraja',
                'nama_kades' => 'Kepala Desa Linggaraja',
                'kode_desa' => 'DS294',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560294',
            ],
            [
                'nama_desa' => 'Desa Margalaksana',
                'nama_kades' => 'Kepala Desa Margalaksana',
                'kode_desa' => 'DS295',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560295',
            ],
            [
                'nama_desa' => 'Desa Mekarjaya',
                'nama_kades' => 'Kepala Desa Mekarjaya',
                'kode_desa' => 'DS296',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560296',
            ],
            [
                'nama_desa' => 'Desa Sirnajaya',
                'nama_kades' => 'Kepala Desa Sirnajaya',
                'kode_desa' => 'DS297',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560297',
            ],
            [
                'nama_desa' => 'Desa Sukapura',
                'nama_kades' => 'Kepala Desa Sukapura',
                'kode_desa' => 'DS298',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560298',
            ],
            [
                'nama_desa' => 'Desa Tarunajaya',
                'nama_kades' => 'Kepala Desa Tarunajaya',
                'kode_desa' => 'DS299',
                'alamat_kantor' => 'Kec. Sukaraja',
                'no_telp' => '081234560299',
            ],


            // ===============================
            // KECAMATAN SUKARAME
            // ===============================
            [
                'nama_desa' => 'Desa Padasuka',
                'nama_kades' => 'Kepala Desa Padasuka',
                'kode_desa' => 'DS300',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560300',
            ],
            [
                'nama_desa' => 'Desa Sukakarsa',
                'nama_kades' => 'Kepala Desa Sukakarsa',
                'kode_desa' => 'DS301',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560301',
            ],
            [
                'nama_desa' => 'Desa Sukamenak',
                'nama_kades' => 'Kepala Desa Sukamenak',
                'kode_desa' => 'DS302',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560302',
            ],
            [
                'nama_desa' => 'Desa Sukarame',
                'nama_kades' => 'Kepala Desa Sukarame',
                'kode_desa' => 'DS303',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560303',
            ],
            [
                'nama_desa' => 'Desa Sukarapih',
                'nama_kades' => 'Kepala Desa Sukarapih',
                'kode_desa' => 'DS304',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560304',
            ],
            [
                'nama_desa' => 'Desa Wargakerta',
                'nama_kades' => 'Kepala Desa Wargakerta',
                'kode_desa' => 'DS305',
                'alamat_kantor' => 'Kec. Sukarame',
                'no_telp' => '081234560305',
            ],


            // ===============================
            // KECAMATAN SUKARATU
            // ===============================
            [
                'nama_desa' => 'Desa Gunungsari',
                'nama_kades' => 'Kepala Desa Gunungsari',
                'kode_desa' => 'DS306',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560306',
            ],
            [
                'nama_desa' => 'Desa Indrajaya',
                'nama_kades' => 'Kepala Desa Indrajaya',
                'kode_desa' => 'DS307',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560307',
            ],
            [
                'nama_desa' => 'Desa Linggajati',
                'nama_kades' => 'Kepala Desa Linggajati',
                'kode_desa' => 'DS308',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560308',
            ],
            [
                'nama_desa' => 'Desa Sinagar',
                'nama_kades' => 'Kepala Desa Sinagar',
                'kode_desa' => 'DS309',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560309',
            ],
            [
                'nama_desa' => 'Desa Sukagalih',
                'nama_kades' => 'Kepala Desa Sukagalih',
                'kode_desa' => 'DS310',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560310',
            ],
            [
                'nama_desa' => 'Desa Sukamahi',
                'nama_kades' => 'Kepala Desa Sukamahi',
                'kode_desa' => 'DS311',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560311',
            ],
            [
                'nama_desa' => 'Desa Sukaratu',
                'nama_kades' => 'Kepala Desa Sukaratu',
                'kode_desa' => 'DS312',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560312',
            ],
            [
                'nama_desa' => 'Desa Tawangbanteng',
                'nama_kades' => 'Kepala Desa Tawangbanteng',
                'kode_desa' => 'DS313',
                'alamat_kantor' => 'Kec. Sukaratu',
                'no_telp' => '081234560313',
            ],


            // ===============================
            // KECAMATAN SUKARESIK
            // ===============================
            [
                'nama_desa' => 'Desa Banjarsari',
                'nama_kades' => 'Kepala Desa Banjarsari',
                'kode_desa' => 'DS314',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560314',
            ],
            [
                'nama_desa' => 'Desa Cipondok',
                'nama_kades' => 'Kepala Desa Cipondok',
                'kode_desa' => 'DS315',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560315',
            ],
            [
                'nama_desa' => 'Desa Margamulya',
                'nama_kades' => 'Kepala Desa Margamulya',
                'kode_desa' => 'DS316',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560316',
            ],
            [
                'nama_desa' => 'Desa Sukamenak',
                'nama_kades' => 'Kepala Desa Sukamenak',
                'kode_desa' => 'DS317',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560317',
            ],
            [
                'nama_desa' => 'Desa Sukapancar',
                'nama_kades' => 'Kepala Desa Sukapancar',
                'kode_desa' => 'DS318',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560318',
            ],
            [
                'nama_desa' => 'Desa Sukaratu',
                'nama_kades' => 'Kepala Desa Sukaratu',
                'kode_desa' => 'DS319',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560319',
            ],
            [
                'nama_desa' => 'Desa Sukaresik',
                'nama_kades' => 'Kepala Desa Sukaresik',
                'kode_desa' => 'DS320',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560320',
            ],
            [
                'nama_desa' => 'Desa Tanjungsari',
                'nama_kades' => 'Kepala Desa Tanjungsari',
                'kode_desa' => 'DS321',
                'alamat_kantor' => 'Kec. Sukaresik',
                'no_telp' => '081234560321',
            ],


            // ===============================
            // KECAMATAN TANJUNGJAYA
            // ===============================
            [
                'nama_desa' => 'Desa Cibalanarik',
                'nama_kades' => 'Kepala Desa Cibalanarik',
                'kode_desa' => 'DS322',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560322',
            ],
            [
                'nama_desa' => 'Desa Cikeusal',
                'nama_kades' => 'Kepala Desa Cikeusal',
                'kode_desa' => 'DS323',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560323',
            ],
            [
                'nama_desa' => 'Desa Cilolohan',
                'nama_kades' => 'Kepala Desa Cilolohan',
                'kode_desa' => 'DS324',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560324',
            ],
            [
                'nama_desa' => 'Desa Cintajaya',
                'nama_kades' => 'Kepala Desa Cintajaya',
                'kode_desa' => 'DS325',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560325',
            ],
            [
                'nama_desa' => 'Desa Sukanagara',
                'nama_kades' => 'Kepala Desa Sukanagara',
                'kode_desa' => 'DS326',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560326',
            ],
            [
                'nama_desa' => 'Desa Sukasenang',
                'nama_kades' => 'Kepala Desa Sukasenang',
                'kode_desa' => 'DS327',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560327',
            ],
            [
                'nama_desa' => 'Desa Tanjungjaya',
                'nama_kades' => 'Kepala Desa Tanjungjaya',
                'kode_desa' => 'DS328',
                'alamat_kantor' => 'Kec. Tanjungjaya',
                'no_telp' => '081234560328',
            ],


            // ===============================
            // KECAMATAN TARAJU
            // ===============================
            [
                'nama_desa' => 'Desa Banyuasih',
                'nama_kades' => 'Kepala Desa Banyuasih',
                'kode_desa' => 'DS329',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560329',
            ],
            [
                'nama_desa' => 'Desa Cikubang',
                'nama_kades' => 'Kepala Desa Cikubang',
                'kode_desa' => 'DS330',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560330',
            ],
            [
                'nama_desa' => 'Desa Deudeul',
                'nama_kades' => 'Kepala Desa Deudeul',
                'kode_desa' => 'DS331',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560331',
            ],
            [
                'nama_desa' => 'Desa Kertaraharja',
                'nama_kades' => 'Kepala Desa Kertaraharja',
                'kode_desa' => 'DS332',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560332',
            ],
            [
                'nama_desa' => 'Desa Pageralam',
                'nama_kades' => 'Kepala Desa Pageralam',
                'kode_desa' => 'DS333',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560333',
            ],
            [
                'nama_desa' => 'Desa Purwarahayu',
                'nama_kades' => 'Kepala Desa Purwarahayu',
                'kode_desa' => 'DS334',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560334',
            ],
            [
                'nama_desa' => 'Desa Raksasari',
                'nama_kades' => 'Kepala Desa Raksasari',
                'kode_desa' => 'DS335',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560335',
            ],
            [
                'nama_desa' => 'Desa Singasari',
                'nama_kades' => 'Kepala Desa Singasari',
                'kode_desa' => 'DS336',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560336',
            ],
            [
                'nama_desa' => 'Desa Taraju',
                'nama_kades' => 'Kepala Desa Taraju',
                'kode_desa' => 'DS337',
                'alamat_kantor' => 'Kec. Taraju',
                'no_telp' => '081234560337',
            ],
            // ===============================
            // KECAMATAN CIKATOMAS (BARU - LENGKAP)
            // ===============================
            [
                'nama_desa' => 'Desa Cayur',
                'nama_kades' => 'Kepala Desa Cayur',
                'kode_desa' => 'DS057',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560057',
            ],
            [
                'nama_desa' => 'Desa Cilumba',
                'nama_kades' => 'Kepala Desa Cilumba',
                'kode_desa' => 'DS058',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560058',
            ],
            [
                'nama_desa' => 'Desa Cogreg',
                'nama_kades' => 'Kepala Desa Cogreg',
                'kode_desa' => 'DS059',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560059',
            ],
            [
                'nama_desa' => 'Desa Gunungsari',
                'nama_kades' => 'Kepala Desa Gunungsari',
                'kode_desa' => 'DS060',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560060',
            ],
            [
                'nama_desa' => 'Desa Lengkongbarang',
                'nama_kades' => 'Kepala Desa Lengkongbarang',
                'kode_desa' => 'DS061',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560061',
            ],
            [
                'nama_desa' => 'Desa Linggalaksana',
                'nama_kades' => 'Kepala Desa Linggalaksana',
                'kode_desa' => 'DS062',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560062',
            ],
            [
                'nama_desa' => 'Desa Pakemitan',
                'nama_kades' => 'Kepala Desa Pakemitan',
                'kode_desa' => 'DS063',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560063',
            ],
            [
                'nama_desa' => 'Desa Sindangasih',
                'nama_kades' => 'Kepala Desa Sindangasih',
                'kode_desa' => 'DS064',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560064',
            ],
            [
                'nama_desa' => 'Desa Tanjungbarang',
                'nama_kades' => 'Kepala Desa Tanjungbarang',
                'kode_desa' => 'DS065',
                'alamat_kantor' => 'Kec. Cikatomas',
                'no_telp' => '081234560065',
            ],

            // ===============================
            // KECAMATAN CINEAM (BARU - LENGKAP)
            // ===============================
            [
                'nama_desa' => 'Desa Ancol',
                'nama_kades' => 'Kepala Desa Ancol',
                'kode_desa' => 'DS066',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560066',
            ],
            [
                'nama_desa' => 'Desa Ciampanan',
                'nama_kades' => 'Kepala Desa Ciampanan',
                'kode_desa' => 'DS067',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560067',
            ],
            [
                'nama_desa' => 'Desa Cijulang',
                'nama_kades' => 'Kepala Desa Cijulang',
                'kode_desa' => 'DS068',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560068',
            ],
            [
                'nama_desa' => 'Desa Cikondang',
                'nama_kades' => 'Kepala Desa Cikondang',
                'kode_desa' => 'DS069',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560069',
            ],
            [
                'nama_desa' => 'Desa Cineam',
                'nama_kades' => 'Kepala Desa Cineam',
                'kode_desa' => 'DS070',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560070',
            ],
            [
                'nama_desa' => 'Desa Cisarua',
                'nama_kades' => 'Kepala Desa Cisarua',
                'kode_desa' => 'DS071',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560071',
            ],
            [
                'nama_desa' => 'Desa Madiasari',
                'nama_kades' => 'Kepala Desa Madiasari',
                'kode_desa' => 'DS072',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560072',
            ],
            [
                'nama_desa' => 'Desa Nagaratengah',
                'nama_kades' => 'Kepala Desa Nagaratengah',
                'kode_desa' => 'DS073',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560073',
            ],
            [
                'nama_desa' => 'Desa Pasirmukti',
                'nama_kades' => 'Kepala Desa Pasirmukti',
                'kode_desa' => 'DS074',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560074',
            ],
            [
                'nama_desa' => 'Desa Rajadatu',
                'nama_kades' => 'Kepala Desa Rajadatu',
                'kode_desa' => 'DS075',
                'alamat_kantor' => 'Kec. Cineam',
                'no_telp' => '081234560075',
            ],

            // ===============================
            // KECAMATAN CIPATUJAH (BARU - LENGKAP)
            // ===============================
            [
                'nama_desa' => 'Desa Bantarkalong',
                'nama_kades' => 'Kepala Desa Bantarkalong',
                'kode_desa' => 'DS076',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560076',
            ],
            [
                'nama_desa' => 'Desa Ciandum',
                'nama_kades' => 'Kepala Desa Ciandum',
                'kode_desa' => 'DS077',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560077',
            ],
            [
                'nama_desa' => 'Desa Ciheras',
                'nama_kades' => 'Kepala Desa Ciheras',
                'kode_desa' => 'DS078',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560078',
            ],
            [
                'nama_desa' => 'Desa Cikawungading',
                'nama_kades' => 'Kepala Desa Cikawungading',
                'kode_desa' => 'DS079',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560079',
            ],
            [
                'nama_desa' => 'Desa Cipanas',
                'nama_kades' => 'Kepala Desa Cipanas',
                'kode_desa' => 'DS080',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560080',
            ],
            [
                'nama_desa' => 'Desa Cipatujah',
                'nama_kades' => 'Kepala Desa Cipatujah',
                'kode_desa' => 'DS081',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560081',
            ],
            [
                'nama_desa' => 'Desa Darawati',
                'nama_kades' => 'Kepala Desa Darawati',
                'kode_desa' => 'DS082',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560082',
            ],
            [
                'nama_desa' => 'Desa Kertasari',
                'nama_kades' => 'Kepala Desa Kertasari',
                'kode_desa' => 'DS083',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560083',
            ],
            [
                'nama_desa' => 'Desa Nagrog',
                'nama_kades' => 'Kepala Desa Nagrog',
                'kode_desa' => 'DS084',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560084',
            ],
            [
                'nama_desa' => 'Desa Nangelasari',
                'nama_kades' => 'Kepala Desa Nangelasari',
                'kode_desa' => 'DS085',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560085',
            ],
            [
                'nama_desa' => 'Desa Padawaras',
                'nama_kades' => 'Kepala Desa Padawaras',
                'kode_desa' => 'DS086',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560086',
            ],
            [
                'nama_desa' => 'Desa Pameutingan',
                'nama_kades' => 'Kepala Desa Pameutingan',
                'kode_desa' => 'DS087',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560087',
            ],
            [
                'nama_desa' => 'Desa Sindangkerta',
                'nama_kades' => 'Kepala Desa Sindangkerta',
                'kode_desa' => 'DS088',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560088',
            ],
            [
                'nama_desa' => 'Desa Sukahurip',
                'nama_kades' => 'Kepala Desa Sukahurip',
                'kode_desa' => 'DS089',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560089',
            ],
            [
                'nama_desa' => 'Desa Tobongjaya',
                'nama_kades' => 'Kepala Desa Tobongjaya',
                'kode_desa' => 'DS090',
                'alamat_kantor' => 'Kec. Cipatujah',
                'no_telp' => '081234560090',
            ],

            // ===============================
            // KECAMATAN CISAYONG (BARU - LENGKAP)
            // ===============================
            [
                'nama_desa' => 'Desa Cikadu',
                'nama_kades' => 'Kepala Desa Cikadu',
                'kode_desa' => 'DS091',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560091',
            ],
            [
                'nama_desa' => 'Desa Cileuleus',
                'nama_kades' => 'Kepala Desa Cileuleus',
                'kode_desa' => 'DS092',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560092',
            ],
            [
                'nama_desa' => 'Desa Cisayong',
                'nama_kades' => 'Kepala Desa Cisayong',
                'kode_desa' => 'DS093',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560093',
            ],
            [
                'nama_desa' => 'Desa Jatihurip',
                'nama_kades' => 'Kepala Desa Jatihurip',
                'kode_desa' => 'DS094',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560094',
            ],
            [
                'nama_desa' => 'Desa Mekarwangi',
                'nama_kades' => 'Kepala Desa Mekarwangi',
                'kode_desa' => 'DS095',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560095',
            ],
            [
                'nama_desa' => 'Desa Nusawangi',
                'nama_kades' => 'Kepala Desa Nusawangi',
                'kode_desa' => 'DS096',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560096',
            ],
            [
                'nama_desa' => 'Desa Purwasari',
                'nama_kades' => 'Kepala Desa Purwasari',
                'kode_desa' => 'DS097',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560097',
            ],
            [
                'nama_desa' => 'Desa Santanamekar',
                'nama_kades' => 'Kepala Desa Santanamekar',
                'kode_desa' => 'DS098',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560098',
            ],
            [
                'nama_desa' => 'Desa Sukajadi',
                'nama_kades' => 'Kepala Desa Sukajadi',
                'kode_desa' => 'DS099',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560099',
            ],
            [
                'nama_desa' => 'Desa Sukamukti',
                'nama_kades' => 'Kepala Desa Sukamukti',
                'kode_desa' => 'DS100',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560100',
            ],
            [
                'nama_desa' => 'Desa Sukaraharja',
                'nama_kades' => 'Kepala Desa Sukaraharja',
                'kode_desa' => 'DS101',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560101',
            ],
            [
                'nama_desa' => 'Desa Sukasetia',
                'nama_kades' => 'Kepala Desa Sukasetia',
                'kode_desa' => 'DS102',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560102',
            ],
            [
                'nama_desa' => 'Desa Sukasukur',
                'nama_kades' => 'Kepala Desa Sukasukur',
                'kode_desa' => 'DS103',
                'alamat_kantor' => 'Kec. Cisayong',
                'no_telp' => '081234560103',
            ],

            // ===============================
            // KECAMATAN CULAMEGA (BARU - LENGKAP)
            // ===============================
            [
                'nama_desa' => 'Desa Bojongsari',
                'nama_kades' => 'Kepala Desa Bojongsari',
                'kode_desa' => 'DS104',
                'alamat_kantor' => 'Kec. Culamega',
                'no_telp' => '081234560104',
            ],
            [
                'nama_desa' => 'Desa Cikuya',
                'nama_kades' => 'Kepala Desa Cikuya',
                'kode_desa' => 'DS105',
                'alamat_kantor' => 'Kec. Culamega',
                'no_telp' => '081234560105',
            ],
            [
                'nama_desa' => 'Desa Cintabodas',
                'nama_kades' => 'Kepala Desa Cintabodas',
                'kode_desa' => 'DS106',
                'alamat_kantor' => 'Kec. Culamega',
                'no_telp' => '081234560106',
            ],
            [
                'nama_desa' => 'Desa Cipicung',
                'nama_kades' => 'Kepala Desa Cipicung',
                'kode_desa' => 'DS107',
                'alamat_kantor' => 'Kec. Culamega',
                'no_telp' => '081234560107',
            ],
            [
                'nama_desa' => 'Desa Mekarlaksana',
                'nama_kades' => 'Kepala Desa Mekarlaksana',
                'kode_desa' => 'DS108',
                'alamat_kantor' => 'Kec. Culamega',
                'no_telp' => '081234560108',
            ],

            // ===============================
            // DESA TAMBAHAN UNTUK KECAMATAN YANG SUDAH ADA
            // ===============================

            // ===============================
            // KECAMATAN CIGALONTANG (TAMBAHAN)
            // ===============================
            [
                'nama_desa' => 'Desa Cidugaleun',
                'nama_kades' => 'Kepala Desa Cidugaleun',
                'kode_desa' => 'DS338',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560338',
            ],
            [
                'nama_desa' => 'Desa Kersamaju',
                'nama_kades' => 'Kepala Desa Kersamaju',
                'kode_desa' => 'DS339',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560339',
            ],
            [
                'nama_desa' => 'Desa Lengkongjaya',
                'nama_kades' => 'Kepala Desa Lengkongjaya',
                'kode_desa' => 'DS340',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560340',
            ],
            [
                'nama_desa' => 'Desa Nanggerang',
                'nama_kades' => 'Kepala Desa Nanggerang',
                'kode_desa' => 'DS341',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560341',
            ],
            [
                'nama_desa' => 'Desa Nangtang',
                'nama_kades' => 'Kepala Desa Nangtang',
                'kode_desa' => 'DS342',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560342',
            ],
            [
                'nama_desa' => 'Desa Parentas',
                'nama_kades' => 'Kepala Desa Parentas',
                'kode_desa' => 'DS343',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560343',
            ],
            [
                'nama_desa' => 'Desa Puspamukti',
                'nama_kades' => 'Kepala Desa Puspamukti',
                'kode_desa' => 'DS344',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560344',
            ],
            [
                'nama_desa' => 'Desa Pusparaja',
                'nama_kades' => 'Kepala Desa Pusparaja',
                'kode_desa' => 'DS345',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560345',
            ],
            // [
            //     'nama_desa' => 'Desa Sirnagalih_Cigalontang',
            //     'nama_kades' => 'Kepala Desa Sirnagalih',
            //     'kode_desa' => 'DS346',
            //     'alamat_kantor' => 'Kec. Cigalontang',
            //     'no_telp' => '081234560346',
            // ],
            [
                'nama_desa' => 'Desa Sirnaputra',
                'nama_kades' => 'Kepala Desa Sirnaputra',
                'kode_desa' => 'DS347',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560347',
            ],
            [
                'nama_desa' => 'Desa Sirnaraja',
                'nama_kades' => 'Kepala Desa Sirnaraja',
                'kode_desa' => 'DS348',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560348',
            ],
            [
                'nama_desa' => 'Desa Sukamanah',
                'nama_kades' => 'Kepala Desa Sukamanah',
                'kode_desa' => 'DS349',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560349',
            ],
            [
                'nama_desa' => 'Desa Tanjungkarang',
                'nama_kades' => 'Kepala Desa Tanjungkarang',
                'kode_desa' => 'DS350',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560350',
            ],
            [
                'nama_desa' => 'Desa Tenjonagara',
                'nama_kades' => 'Kepala Desa Tenjonagara',
                'kode_desa' => 'DS351',
                'alamat_kantor' => 'Kec. Cigalontang',
                'no_telp' => '081234560351',
            ],

            // ===============================
            // KECAMATAN LEUWISARI (TAMBAHAN)
            // ===============================
            // [
            //     'nama_desa' => 'Desa Mangunreja_Leuwisari',
            //     'nama_kades' => 'Kepala Desa Mangunreja',
            //     'kode_desa' => 'DS352',
            //     'alamat_kantor' => 'Kec. Leuwisari',
            //     'no_telp' => '081234560352',
            // ],

            // ===============================
            // KECAMATAN SINGAPARNA (TAMBAHAN)
            // ===============================
            [
                'nama_desa' => 'Desa Cikadongdong_Singaparna',
                'nama_kades' => 'Kepala Desa Cikadongdong',
                'kode_desa' => 'DS353',
                'alamat_kantor' => 'Kec. Singaparna',
                'no_telp' => '081234560353',
            ],

        ];

        // INSERT DESA SEKALIGUS 🚀
        Desa::insert($desas);

        // AMBIL SEMUA DESA
        $desaRecords = Desa::all();

        // BUAT USER DESA SEKALIGUS
        $users = [];
        $emailTracker = []; // Untuk melacak email yang sudah dibuat

        foreach ($desaRecords as $desa) {
            // 1. Hapus "Desa " dari awal nama desa
            $namaTanpaDesa = str_replace('Desa ', '', $desa->nama_desa);

            // 2. Hapus spasi, underscore, dan karakter khusus
            $namaClean = strtolower(str_replace([' ', '_', '-', '.'], '', $namaTanpaDesa));

            // 3. Format email baru: desanamadesa@tasikdesa.com (TANPA TITIK)
            $baseEmail = 'desa' . $namaClean . '@evaluasikla.com';

            // Jika ada duplikat (contoh: Desa Ciawi di 2 kecamatan berbeda)
            if (isset($emailTracker[$baseEmail])) {
                // Ambil nama kecamatan tanpa "Kec. "
                $kecamatan = strtolower(str_replace(' ', '', str_replace('Kec. ', '', $desa->alamat_kantor)));
                $kecamatan = preg_replace('/[^a-z0-9]/', '', $kecamatan);

                $baseEmail = 'desa' . $namaClean . $kecamatan . '@evaluasikla.com';
            }

            $emailTracker[$baseEmail] = true;

            // Password: nama desa tanpa "Desa " + @2025
            $password = str_replace('Desa ', '', $desa->nama_desa) . '@2025';

            $users[] = [
                'name' => 'Operator ' . $desa->nama_desa,
                'email' => $baseEmail,
                'password' => Hash::make($password),
                'role' => 'desa',
                'desa_id' => $desa->id,
            ];
        }

        User::insert($users);
        // NYALAIN LAGI FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
