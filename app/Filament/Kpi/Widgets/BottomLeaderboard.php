<?php

namespace App\Filament\Kpi\Widgets;

use App\Models\KpiPeriod;
use App\Models\KpiSummarie;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Livewire\Attributes\On;

class BottomLeaderboard extends TableWidget
{
    protected static ?string $heading = 'Bottom Leaderboard';
    protected int|string|array $columnSpan = 1;

    public function getDescription(): ?string
    {
        return 'Daftar karyawan dengan nilai KPI terendah.';
    }

    public ?int $periodId = null;

    public function mount()
    {
        $this->periodId = KpiPeriod::query()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->value('id');
    }

    #[On('periodChanged')]
    public function changePeriod($periodId)
    {
        $this->periodId = $periodId;
        $this->resetTable();
    }

    public function table(Table $table): Table
    {
        $latestPeriod = KpiPeriod::find($this->periodId);

        return $table
            ->paginated(false)
            ->searchable(false)
            ->query(
                KpiSummarie::query()
                    ->with('user')
                    ->where('period_id', optional($latestPeriod)->id)
                    ->orderBy('total_score')
                    ->limit(3)
            )

            ->columns([


                TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable(),

                TextColumn::make('total_score')
                    ->label('Nilai')
                    ->numeric(2),

                TextColumn::make('grade')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'A' => 'success',
                        'B' => 'primary',
                        'C' => 'warning',
                        default => 'danger',
                    }),

            ]);
    }
}
