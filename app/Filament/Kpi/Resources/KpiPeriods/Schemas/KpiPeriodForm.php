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
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                                    if ($get('end_date') && Carbon::parse($get('end_date'))->lt(Carbon::parse($state))) {
                                        $set('end_date', $state);
                                    }
                                    }), 
                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->live()
                                    ->required()
                                    ->minDate(function ($get) {
                                    return $get('start_date');
                                    }),
                            ]),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false)
                            ->columnSpanFull(),
                    ])->columnSpanFull()
            ]);
    }
}
