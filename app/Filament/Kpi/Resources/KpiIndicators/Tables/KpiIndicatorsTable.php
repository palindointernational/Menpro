<?php

namespace App\Filament\Kpi\Resources\KpiIndicators\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KpiIndicatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Indikator')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('formula')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'task_completion' => 'Penyelesaian Tugas',
                        'on_time_completion' => 'Ketepatan Waktu',
                        'revision_rate' => 'Jumlah Revisi',
                        'approval_rate' => 'Tingkat Persetujuan',
                        default => $state,
                    }),

                TextColumn::make('weight')
                    ->label('Bobot')
                    ->suffix('%')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('max_score')
                    ->label('Nilai Maksimum')
                    ->alignCenter(),

                IconColumn::make('is_auto')
                    ->label('Otomatis')
                    ->boolean(),
            ])
            ->defaultSort('category.name')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
