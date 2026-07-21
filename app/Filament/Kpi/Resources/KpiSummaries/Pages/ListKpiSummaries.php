<?php

namespace App\Filament\Kpi\Resources\KpiSummaries\Pages;

use App\Filament\Kpi\Resources\KpiSummaries\KpiSummarieResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKpiSummaries extends ListRecords
{
    protected static string $resource = KpiSummarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
