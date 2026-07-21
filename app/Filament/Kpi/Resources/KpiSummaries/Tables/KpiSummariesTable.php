<?php

namespace App\Filament\Kpi\Resources\KpiSummaries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\KpiPeriod;

class KpiSummariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->defaultSort('total_score', 'desc')

            ->columns([

                TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable(),

                TextColumn::make('period.name')
                    ->label('Periode'),

                TextColumn::make('total_score')
                    ->label('Nilai')
                    ->numeric(2)
                    ->sortable(),

                TextColumn::make('grade')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'A' => 'success',
                        'B' => 'primary',
                        'C' => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('completed_task')
                    ->label('Selesai'),

                TextColumn::make('late_task')
                    ->label('Terlambat')
                    ->badge()
                    ->color('danger'),

                TextColumn::make('approved_task')
                    ->label('Approved')
                    ->badge()
                    ->color('success'),

                TextColumn::make('revision_task')
                    ->label('Revisi')
                    ->badge()
                    ->color('warning'),

            ])
            ->filters([
                SelectFilter::make('period_id')
                    ->label('Periode')
                    ->relationship('period', 'name'),
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
