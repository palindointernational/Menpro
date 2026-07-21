<?php

namespace App\Filament\Kpi\Concerns;

trait InteractsWithDashboardFilters
{
    public function getSelectedPeriodId(): ?int
    {
        return $this->page?->periodId;
    }
}
