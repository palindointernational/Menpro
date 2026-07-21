<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Widgets\TableWidget;

class RecentActivityWidget extends TableWidget
{
    protected string $view = 'filament.kpi.widgets.recent-activity-widget';

    protected int|string|array $columnSpan = 1;

    protected static ?int $sort = 6;
    public function getActivities()
    {
        return KpiPeriod::latest()
            ->take(5)
            ->get()
            ->map(function ($period) {

                $employee = KpiSummarie::where('period_id', $period->id)->count();

                $completed = KpiSummarie::where('period_id', $period->id)
                    ->sum('completed_task');

                $late = KpiSummarie::where('period_id', $period->id)
                    ->sum('late_task');

                return [

                    'title' => "Generate KPI {$period->name}",

                    'employee' => $employee,

                    'completed' => $completed,

                    'late' => $late,

                    'created_at' => $period->created_at,

                ];
            });
    }
}
