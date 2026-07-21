<?php

namespace App\Filament\Kpi\Resources\KpiCategories\Pages;

use App\Filament\Kpi\Resources\KpiCategories\KpiCategoriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKpiCategories extends ListRecords
{
    protected static string $resource = KpiCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
