<?php

namespace App\Filament\Kpi\Resources\KpiSummaries;

use App\Filament\Kpi\Resources\KpiSummaries\Pages\CreateKpiSummarie;
use App\Filament\Kpi\Resources\KpiSummaries\Pages\EditKpiSummarie;
use App\Filament\Kpi\Resources\KpiSummaries\Pages\ListKpiSummaries;
use App\Filament\Kpi\Resources\KpiSummaries\Schemas\KpiSummarieForm;
use App\Filament\Kpi\Resources\KpiSummaries\Tables\KpiSummariesTable;
use App\Models\KpiSummarie;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KpiSummarieResource extends Resource
{
    protected static ?string $model = KpiSummarie::class;
    protected static ?int $navigationSort = 6;
    protected static string | UnitEnum | null $navigationGroup = 'KPI';
    protected static ?string $navigationLabel = 'KPI Summaries';
    protected static ?string $title = 'KPI Summaries';
    protected ?string $heading = 'KPI Summaries';
    protected static ?string $pluralModelLabel = 'KPI Summaries';
    protected static ?string $modelLabel = 'KPI Summaries';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    protected static ?string $recordTitleAttribute = 'KpiSummarie';

    public static function form(Schema $schema): Schema
    {
        return KpiSummarieForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KpiSummariesTable::configure($table);
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
            'index' => ListKpiSummaries::route('/'),
            // 'create' => CreateKpiSummarie::route('/create'),
            // 'edit' => EditKpiSummarie::route('/{record}/edit'),
        ];
    }
}
