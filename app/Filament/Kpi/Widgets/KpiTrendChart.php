<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class KpiTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tren Nilai KPI';

    protected int|string|array $columnSpan = 1;
    public function getDescription(): ?string
    {
        return 'Tren rata-rata nilai KPI karyawan dari periode ke periode.';
    }
    public ?int $periodId = null;

    public function mount(): void
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
    protected function getData(): array
    {
        $data = KpiSummarie::query()
            ->where('period_id', $this->periodId)
            ->selectRaw('period_id, AVG(total_score) as average_score')
            ->with('period')
            ->groupBy('period_id')
            ->orderBy('period_id')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata KPI',
                    'data' => $data
                        ->pluck('average_score')
                        ->map(fn($value) => round($value, 2))
                        ->values(),
                    'borderWidth' => 3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],

            'labels' => $data
                ->map(fn($item) => $item->period?->name ?? '-')
                ->values(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
