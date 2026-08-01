<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class GradeDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Grade';

    protected int|string|array $columnSpan = 1;
    protected ?string $maxHeight = '280px';
    public function getDescription(): ?string
    {
        return 'Distribusi grade karyawan berdasarkan nilai KPI terbaru.';
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
        $grades = KpiSummarie::query()
            ->where('period_id', $this->periodId)
            ->selectRaw('grade, COUNT(*) as total')
            ->groupBy('grade')
            ->orderBy('grade')
            ->get();

            $total = $grades->sum('total');
        return [
            'datasets' => [
                [
                    'data' => $grades->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#22C55E', // A - Hijau
                        '#3B82F6', // B - Biru
                        '#FACC15', // C - Kuning
                        '#F97316', // D - Orange
                        '#EF4444', // E - Merah
                    ],

                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                    'hoverOffset' => 10,
                ],
            ],
            
            'labels' => $grades
                ->map(function ($item) use ($total) {
                    $percentage = $total > 0
                    ? round(($item->total / $total) * 100)
                    : 0;    
                    return match ($item->grade) {

                        'A' => "A (Excellent) {$percentage}%",

                        'B' => "B (Good) {$percentage}%",

                        'C' => "C (Average) {$percentage}%",

                        'D' => "D (Poor) {$percentage}%",

                        default => "E (Very Poor) {$percentage}%",
                    };
                })
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 20,
                    ],
                ],
            ],
        ];
    }

    
}
