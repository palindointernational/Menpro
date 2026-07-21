<?php

namespace App\Filament\Kpi\Resources\KpiPeriods;

use App\Filament\Kpi\Resources\KpiPeriods\Pages\CreateKpiPeriod;
use App\Filament\Kpi\Resources\KpiPeriods\Pages\EditKpiPeriod;
use App\Filament\Kpi\Resources\KpiPeriods\Pages\ListKpiPeriods;
use App\Filament\Kpi\Resources\KpiPeriods\Schemas\KpiPeriodForm;
use App\Filament\Kpi\Resources\KpiPeriods\Tables\KpiPeriodsTable;
use App\Models\KpiPeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KpiPeriodResource extends Resource
{
    protected static ?string $model = KpiPeriod::class;
    protected static ?int $navigationSort = 2;
    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Periode';
    protected static ?string $title = 'Periode';
    protected ?string $heading = 'Periode';
    protected static ?string $pluralModelLabel = 'Periode';
    protected static ?string $modelLabel = 'Periode';
    protected static ?string $navigationSubgroup = 'KPI';
    protected static ?string $navigationBadge = null;
    protected static ?string $navigationBadgeColor = 'primary';
    protected ?string $subheading = 'Manage KPI Periode';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'KpiPeriod';

    public static function form(Schema $schema): Schema
    {
        return KpiPeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KpiPeriodsTable::configure($table);
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
            'index' => ListKpiPeriods::route('/'),
            'create' => CreateKpiPeriod::route('/create'),
            'edit' => EditKpiPeriod::route('/{record}/edit'),
        ];
    }
}
