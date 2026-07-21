<?php

namespace App\Filament\Kpi\Resources\KpiIndicators;

use App\Filament\Kpi\Resources\KpiIndicators\Pages\CreateKpiIndicator;
use App\Filament\Kpi\Resources\KpiIndicators\Pages\EditKpiIndicator;
use App\Filament\Kpi\Resources\KpiIndicators\Pages\ListKpiIndicators;
use App\Filament\Kpi\Resources\KpiIndicators\Schemas\KpiIndicatorForm;
use App\Filament\Kpi\Resources\KpiIndicators\Tables\KpiIndicatorsTable;
use App\Models\KpiIndicator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KpiIndicatorResource extends Resource
{
    protected static ?string $model = KpiIndicator::class;
    protected static ?int $navigationSort = 4;
    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Indicator';
    protected static ?string $title = 'Indicator';
    protected ?string $heading = 'Indicator';
    protected static ?string $pluralModelLabel = 'Indicator';
    protected static ?string $modelLabel = 'Indicator';
    protected static ?string $navigationSubgroup = 'KPI';
    protected static ?string $navigationBadge = null;
    protected static ?string $navigationBadgeColor = 'primary';
    protected ?string $subheading = 'Manage KPI Indicator';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $recordTitleAttribute = 'KpiIndicator';

    public static function form(Schema $schema): Schema
    {
        return KpiIndicatorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KpiIndicatorsTable::configure($table);
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
            'index' => ListKpiIndicators::route('/'),
            'create' => CreateKpiIndicator::route('/create'),
            'edit' => EditKpiIndicator::route('/{record}/edit'),
        ];
    }
}
