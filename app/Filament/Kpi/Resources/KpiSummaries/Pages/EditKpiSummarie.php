<?php

namespace App\Filament\Kpi\Resources\KpiSummaries\Pages;

use App\Filament\Kpi\Resources\KpiSummaries\KpiSummarieResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKpiSummarie extends EditRecord
{
    protected static string $resource = KpiSummarieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
