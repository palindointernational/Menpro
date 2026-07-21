<?php

namespace App\Filament\Kpi\Resources\KpiSummaries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KpiSummarieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('period_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('total_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('grade'),
                TextInput::make('rank')
                    ->numeric(),
                TextInput::make('completed_task')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('late_task')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('approved_task')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('revision_task')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
