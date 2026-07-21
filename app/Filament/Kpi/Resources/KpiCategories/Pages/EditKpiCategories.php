<?php

namespace App\Filament\Kpi\Resources\KpiCategories\Pages;

use App\Filament\Kpi\Resources\KpiCategories\KpiCategoriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKpiCategories extends EditRecord
{
    protected static string $resource = KpiCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
