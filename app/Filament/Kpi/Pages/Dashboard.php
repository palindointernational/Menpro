<?php

namespace App\Filament\Kpi\Pages;

use App\Filament\Kpi\Widgets\BottomLeaderboard;
use App\Filament\Kpi\Widgets\GradeDistributionChart;
use App\Filament\Kpi\Widgets\KpiRoleChart;
use App\Filament\Kpi\Widgets\KpiStatsOverview;
use App\Filament\Kpi\Widgets\KpiTrendChart;
use App\Filament\Kpi\Widgets\TopLeaderboard;
use App\Models\KpiPeriod;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;

class Dashboard extends Page
{

    protected static ?string $navigationLabel = 'KPI Dashboard';
    protected static ?string $title = 'KPI Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected string $view = 'filament.kpi.pages.dashboard';
    public ?int $periodId = null;

    public function mount(): void
    {
        $this->periodId = KpiPeriod::query()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->value('id');
    }
    public function updatedPeriodId()
    {
        $this->dispatch('periodChanged', periodId: $this->periodId);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('filterPeriod')
                ->label('Pilih Periode')
                ->icon('heroicon-o-calendar-days')
                ->form([
                    Select::make('periodId')
                        ->label('Periode')
                        ->options(
                            KpiPeriod::orderByDesc('start_date')
                                ->pluck('name', 'id')
                        )
                        ->native(false)
                        ->searchable()
                        ->default($this->periodId),
                ])
                ->action(function (array $data) {
                    $this->periodId = $data['periodId'];

                    $this->dispatch('periodChanged', periodId: $this->periodId);
                }),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            KpiStatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            TopLeaderboard::class,
            BottomLeaderboard::class,
            GradeDistributionChart::class,
            KpiTrendChart::class,
            KpiRoleChart::class,
            // RecentActivityWidget::class,
        ];
    }
}
