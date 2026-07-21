<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\On;

class KpiRoleChart extends ChartWidget
{
    protected ?string $heading = 'Rata-rata KPI per Role';

    protected int|string|array $columnSpan = 2;
    public function getDescription(): ?string
    {
        return 'Rata-rata nilai KPI karyawan berdasarkan role.';
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
        $roles = KpiSummarie::query()
            ->where('period_id', $this->periodId)
            ->join('users', 'users.id', '=', 'kpi_summaries.user_id')
            ->selectRaw('users.role, AVG(kpi_summaries.total_score) as average_score')
            ->groupBy('users.role')
            ->orderByDesc('average_score')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata KPI',
                    'data' => $roles
                        ->pluck('average_score')
                        ->map(fn($score) => round($score, 2))
                        ->values(),
                ],
            ],

            'labels' => $roles
                ->pluck('role')
                ->map(fn($role) => ucwords(str_replace('_', ' ', $role)))
                ->values(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                ],
            ],
        ];
    }
}
