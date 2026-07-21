<?php

namespace App\Filament\Kpi\Resources\KpiPeriods\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KpiPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Periode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_range')
                    ->label('Date Range')
                    ->sortable(),
                BooleanColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
            ])
            ->recordActions([
                Action::make('toggleActive')
                    ->label(fn($record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn($record) => $record->is_active
                        ? 'heroicon-o-lock-closed'
                        : 'heroicon-o-lock-open')
                    ->color(fn($record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'is_active' => ! $record->is_active,
                        ]);
                    })
                    ->successNotificationTitle('Category status updated successfully.'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
