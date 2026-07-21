<?php

namespace App\Filament\Widgets;

use App\Models\TaskItem;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class MyTaskWidget extends TableWidget
{
    protected static ?string $heading = 'Task Saya';

    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return auth()->user()->role != 'admin';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                TaskItem::query()
                ->whereHas('task.taskUsers', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->latest()
                ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label('Task'),
                // BadgeColumn::make('status'),
                TextColumn::make('status')
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'done'       => 'success',
                        default      => 'primary',
                    })
                    ->badge(),
                TextColumn::make('due_date')
                    ->date('d M Y'),
            ]);
    }
}
