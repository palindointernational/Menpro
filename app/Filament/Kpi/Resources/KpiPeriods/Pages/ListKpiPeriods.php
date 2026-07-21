<?php

namespace App\Filament\Kpi\Resources\KpiPeriods\Pages;

use App\Filament\Kpi\Resources\KpiPeriods\KpiPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKpiPeriods extends ListRecords
{
    protected static string $resource = KpiPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
