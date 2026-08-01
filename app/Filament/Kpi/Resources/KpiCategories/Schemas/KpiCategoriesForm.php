<?php

namespace App\Filament\Kpi\Resources\KpiCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KpiCategoriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Category')
                    ->description('Tentukan kategori KPI yang akan digunakan dalam evaluasi kinerja karyawan.')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->placeholder('Contoh: Inovasi')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(100),

                                TextInput::make('weight')
                                    ->label('Bobot (%)')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->required(),
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Jelaskan kategori KPI ini...')
                            ->rows(4)
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull(),


            ]);
    }
}
