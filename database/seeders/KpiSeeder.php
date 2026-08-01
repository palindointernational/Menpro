<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KpiCategories;
use App\Models\KpiIndicator;
use App\Models\KpiPeriod;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $period = KpiPeriod::create([
            'name'       => 'Agustus 2026',
            'start_date' => '2026-08-01',
            'end_date'   => '2026-08-31',
            'is_active'  => true,
        ]);

        $taskCompletion = KpiCategories::create([
            'name'        => 'Penyelesaian Tugas',
            'description' => 'Menilai kemampuan karyawan dalam menyelesaikan seluruh tugas yang diberikan.',
            'weight'      => 40,
        ]);

        $onTime = KpiCategories::create([
            'name'        => 'Ketepatan Waktu',
            'description' => 'Menilai kemampuan menyelesaikan pekerjaan sesuai deadline.',
            'weight'      => 30,
        ]);

        $quality = KpiCategories::create([
            'name'        => 'Kualitas Hasil Pekerjaan',
            'description' => 'Menilai kualitas pekerjaan berdasarkan tingkat persetujuan.',
            'weight'      => 20,
        ]);

        $revision = KpiCategories::create([
            'name'        => 'Revisi Pekerjaan',
            'description' => 'Menilai jumlah revisi yang diterima pada setiap pekerjaan.',
            'weight'      => 10,
        ]);

        KpiIndicator::create([
            'kpi_categories_id' => $taskCompletion->id,
            'name'            => 'Penyelesaian Tugas',
            'description'     => 'Persentase task yang berhasil diselesaikan.',
            'formula'         => 'task_completion',
            'weight'          => 100,
            'max_score'       => 100,
            'is_auto'         => true,
        ]);

        KpiIndicator::create([
            'kpi_categories_id' => $onTime->id,
            'name'            => 'Ketepatan Waktu',
            'description'     => 'Persentase task yang selesai sebelum atau tepat pada deadline.',
            'formula'         => 'on_time_completion',
            'weight'          => 100,
            'max_score'       => 100,
            'is_auto'         => true,
        ]);

        KpiIndicator::create([
            'kpi_categories_id' => $quality->id,
            'name'            => 'Kualitas Hasil Pekerjaan',
            'description'     => 'Persentase hasil pekerjaan yang langsung disetujui.',
            'formula'         => 'approval_rate',
            'weight'          => 100,
            'max_score'       => 100,
            'is_auto'         => true,
        ]);

        KpiIndicator::create([
            'kpi_categories_id' => $revision->id,
            'name'            => 'Revisi Pekerjaan',
            'description'     => 'Mengukur jumlah revisi berdasarkan hasil pekerjaan yang ditolak.',
            'formula'         => 'revision_rate',
            'weight'          => 100,
            'max_score'       => 100,
            'is_auto'         => true,
        ]);
    }
}
