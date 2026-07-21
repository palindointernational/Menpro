<?php

namespace App\Filament\Kpi\Resources\KpiCategories;

use App\Filament\Kpi\Resources\KpiCategories\Pages\CreateKpiCategories;
use App\Filament\Kpi\Resources\KpiCategories\Pages\EditKpiCategories;
use App\Filament\Kpi\Resources\KpiCategories\Pages\ListKpiCategories;
use App\Filament\Kpi\Resources\KpiCategories\Schemas\KpiCategoriesForm;
use App\Filament\Kpi\Resources\KpiCategories\Tables\KpiCategoriesTable;
use App\Models\KpiCategories;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KpiCategoriesResource extends Resource
{
    protected static ?string $model = KpiCategories::class;
    protected static ?int $navigationSort = 3;
    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Category';
    protected static ?string $title = 'Category';
    protected ?string $heading = 'Category';
    protected static ?string $pluralModelLabel = 'Category';
    protected static ?string $modelLabel = 'Category';
    protected static ?string $navigationSubgroup = 'KPI';
    protected static ?string $navigationBadge = null;
    protected static ?string $navigationBadgeColor = 'primary';
    protected ?string $subheading = 'Manage KPI Category';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquaresPlus;

    protected static ?string $recordTitleAttribute = 'KpiCategories';

    public static function form(Schema $schema): Schema
    {
        return KpiCategoriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KpiCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKpiCategories::route('/'),
            'create' => CreateKpiCategories::route('/create'),
            'edit' => EditKpiCategories::route('/{record}/edit'),
        ];
    }
}
