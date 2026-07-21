<?php

namespace App\Filament\Kpi\Resources\KpiIndicators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KpiIndicatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Indikator KPI')
                    ->description('Masukkan informasi dasar mengenai indikator KPI yang akan digunakan dalam proses penilaian kinerja.')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                Select::make('kpi_categories_id')
                                    ->label('Kategori KPI')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Pilih kategori KPI')
                                    ->helperText('Pilih kategori yang sesuai untuk indikator ini.'),

                                TextInput::make('name')
                                    ->label('Nama Indikator')
                                    ->placeholder('Contoh: Penyelesaian Tugas')
                                    ->helperText('Masukkan nama indikator KPI.')
                                    ->required()
                                    ->maxLength(100),

                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan tujuan dan cara penilaian indikator ini...')
                            ->helperText('Deskripsi akan membantu administrator memahami fungsi indikator.')
                            ->rows(4)
                            ->columnSpanFull(),

                    ]),

                Section::make('Konfigurasi Perhitungan')
                    ->description('Atur metode perhitungan dan bobot indikator.')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                Select::make('formula')
                                    ->label('Metode Perhitungan')
                                    ->placeholder('Pilih metode perhitungan')
                                    ->helperText('Menentukan bagaimana sistem menghitung nilai indikator.')
                                    ->options([
                                        'task_completion' => 'Penyelesaian Tugas',
                                        'on_time_completion' => 'Ketepatan Waktu',
                                        'revision_rate' => 'Jumlah Revisi',
                                        'approval_rate' => 'Tingkat Persetujuan',
                                    ])
                                    ->required(),

                                TextInput::make('weight')
                                    ->label('Bobot')
                                    ->numeric()
                                    ->suffix('%')
                                    ->default(0)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->placeholder('0')
                                    ->helperText('Bobot indikator terhadap total nilai KPI.')
                                    ->required(),

                                TextInput::make('max_score')
                                    ->label('Nilai Maksimum')
                                    ->numeric()
                                    ->default(100)
                                    ->placeholder('100')
                                    ->helperText('Nilai maksimum yang dapat diperoleh.')
                                    ->required(),

                            ]),

                    ]),

                Section::make('Otomatisasi')
                    ->description('Tentukan apakah indikator dihitung secara otomatis oleh sistem.')
                    ->schema([

                        Toggle::make('is_auto')
                            ->label('Hitung Otomatis')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Jika aktif, sistem akan menghitung indikator secara otomatis berdasarkan data proyek.'),

                    ]),
            ]);
    }
}
