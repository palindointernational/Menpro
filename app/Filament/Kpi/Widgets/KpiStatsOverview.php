<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class KpiStatsOverview extends StatsOverviewWidget
{
    public ?int $periodId = null;
    public function mount()
    {
        $this->periodId = KpiPeriod::query()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->value('id');
    }
    #[On('periodChanged')]
    public function changePeriod($periodId)
    {
        $this->periodId = $periodId;
    }
    protected function getStats(): array
    {
        $period = KpiPeriod::find($this->periodId);

        if (! $period) {
            return [
                Stat::make('Rata-rata KPI', '0'),
                Stat::make('Karyawan Dinilai', '0'),
                Stat::make('Task Selesai', '0'),
                Stat::make('Task Terlambat', '0'),
            ];
        }
        $average = KpiSummarie::where('period_id', $period->id)
            ->avg('total_score') ?? 0;

        $employees = KpiSummarie::where('period_id', $period->id)->count();

        $completed = KpiSummarie::where('period_id', $period->id)
            ->sum('completed_task');

        $late = KpiSummarie::where('period_id', $period->id)
            ->sum('late_task');

        return [

            Stat::make('Rata-rata KPI', number_format($average, 2))
                ->description('Periode ' . $period->name)
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),

            Stat::make('Karyawan Dinilai', $employees)
                ->description('Karyawan telah dihitung')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Task Selesai', $completed)
                ->description('Total task selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Task Terlambat', $late)
                ->description('Perlu perhatian')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
