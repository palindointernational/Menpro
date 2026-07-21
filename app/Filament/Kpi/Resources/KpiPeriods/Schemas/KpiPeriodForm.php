<?php

namespace App\Filament\Kpi\Resources\KpiPeriods\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KpiPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form Periode KPI')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Periode')
                            ->required(),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required(),
                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->required(),
                            ]),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false)
                            ->columnSpanFull(),
                    ])->columnSpanFull()
            ]);
    }
}
