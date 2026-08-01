<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\View;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('project.name')
                    ->label('Project')
                    ->collapsible(),
            ])
            // ->defaultGroup('project.name')
            ->columns([
                TextColumn::make('project.name')
                    ->sortable()
                    ->label('Project Name')
                    ->searchable(),
                TextColumn::make('users.name')
                    ->label('User Assigned')
                    ->searchable()
                    ->badge(),
                TextColumn::make('name')
                    ->label('Task Name')
                    ->searchable(),
                TextColumn::make('duration')
                    ->label('Duration')
                    ->suffix(' Day')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('progress')
                    ->query(fn(Builder $query) => $query->where('progress', true)),

            ])
            ->recordActions([
                ViewAction::make(),


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
