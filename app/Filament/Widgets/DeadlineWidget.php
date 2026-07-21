<?php

namespace App\Filament\Widgets;

use App\Models\TaskItem;
use App\Models\TaskUser;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeadlineWidget extends TableWidget
{
    protected static ?string $heading = 'Deadline Terdekat';
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
                ->where('status', '!=', 'done')
                ->latest()
                ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('task.name')
                    ->label('Task'),
                TextColumn::make('due_date')
                    ->label('Deadline')
                    ->date('d M Y')
                    ->color(fn($record) => $record->due_date < now()
                        ? 'danger'
                        : 'warning'),

            ]);
    }
}
