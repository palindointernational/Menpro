<?php

namespace App\Filament\Kpi\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use App\Models\KpiPeriod;
use App\Services\KpiCalculatorService;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;

class GenerateKpi extends Page
{
    protected string $view = 'filament.kpi.pages.generate-kpi';
    protected static ?int $navigationSort = 5;
    protected static string | UnitEnum | null $navigationGroup = 'KPI';
    protected static ?string $navigationLabel = 'Generate KPI';
    protected static ?string $title = 'Generate KPI';
    protected ?string $heading = 'Generate KPI';
    protected static ?string $pluralModelLabel = 'Generate KPI';
    protected static ?string $modelLabel = 'Generate KPI';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;


    public function generate(): void
    {
        $period = KpiPeriod::findOrFail($this->period_id);

        app(KpiCalculatorService::class)->generate($period);

        Notification::make()
            ->title('Generate KPI berhasil')
            ->body('Nilai KPI seluruh karyawan berhasil dihitung.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [

            Action::make('generate')

                ->label('Generate KPI')

                ->icon('heroicon-o-play')

                ->color('success')

                ->form([

                    Select::make('period_id')
                    ->label('Periode KPI')
                    ->options(
                        KpiPeriod::query()
                            ->where('is_active', true)
                            ->orderByDesc('start_date')
                            ->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
                ])

                ->action(function (array $data) {

                    $period = KpiPeriod::findOrFail($data['period_id']);

                    app(KpiCalculatorService::class)->generate($period);

                    Notification::make()
                        ->title('Generate KPI Berhasil')
                        ->body("Periode {$period->name} berhasil dihitung.")
                        ->success()
                        ->send();
                })
                ->modalHeading('Generate KPI')
                ->modalDescription('Perhitungan KPI untuk periode yang dipilih akan diperbarui jika sudah pernah digenerate.')
                ->requiresConfirmation(),

        ];
    }
}
