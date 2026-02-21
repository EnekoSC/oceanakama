<?php

namespace App\Filament\Resources;

use App\Enums\EstadoCurso;
use App\Enums\NivelCurso;
use App\Filament\Resources\CursoResource\Pages;
use App\Models\Curso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Cursos';

    protected static ?string $modelLabel = 'Curso';

    protected static ?string $pluralModelLabel = 'Cursos';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información básica')
                    ->schema([
                        Forms\Components\TextInput::make('nombre.es')
                            ->label('Nombre (ES)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('nombre.en')
                            ->label('Nombre (EN)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('nivel')
                            ->options(collect(NivelCurso::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\TextInput::make('certificacion_ssi')
                            ->label('Certificación SSI')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('duracion')
                            ->label('Duración')
                            ->placeholder('Ej: 3 días')
                            ->maxLength(100),
                    ])->columns(2),

                Forms\Components\Section::make('Precio y plazas')
                    ->schema([
                        Forms\Components\TextInput::make('precio')
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->step('0.01'),
                        Forms\Components\TextInput::make('plazas_max')
                            ->label('Plazas máximas')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\TextInput::make('plazas_disponibles')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\Select::make('estado')
                            ->options(collect(EstadoCurso::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required()
                            ->default(EstadoCurso::Proximo->value),
                    ])->columns(2),

                Forms\Components\Section::make('Fechas')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_inicio'),
                        Forms\Components\DatePicker::make('fecha_fin'),
                    ])->columns(2),

                Forms\Components\Section::make('Descripción')
                    ->schema([
                        Forms\Components\RichEditor::make('descripcion.es')
                            ->label('Descripción (ES)')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('descripcion.en')
                            ->label('Descripción (EN)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Imagen')
                    ->schema([
                        Forms\Components\FileUpload::make('imagen_url')
                            ->label('Imagen')
                            ->image()
                            ->directory('cursos')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen_url')
                    ->label('Img')
                    ->circular(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('nivel')
                    ->badge()
                    ->formatStateUsing(fn (NivelCurso $state) => $state->label())
                    ->color(fn (NivelCurso $state) => match ($state) {
                        NivelCurso::Principiante => 'success',
                        NivelCurso::Intermedio => 'info',
                        NivelCurso::Avanzado => 'warning',
                        NivelCurso::Profesional => 'danger',
                    }),
                Tables\Columns\TextColumn::make('precio')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('plazas_disponibles')
                    ->label('Plazas')
                    ->formatStateUsing(fn (Curso $record) => "{$record->plazas_disponibles}/{$record->plazas_max}")
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (EstadoCurso $state) => $state->label())
                    ->color(fn (EstadoCurso $state) => match ($state) {
                        EstadoCurso::Proximo => 'info',
                        EstadoCurso::EnCurso => 'success',
                        EstadoCurso::Completado => 'gray',
                        EstadoCurso::Cancelado => 'danger',
                    }),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservas_count')
                    ->label('Reservas')
                    ->counts('reservas')
                    ->sortable(),
            ])
            ->defaultSort('fecha_inicio', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('nivel')
                    ->options(collect(NivelCurso::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
                Tables\Filters\SelectFilter::make('estado')
                    ->options(collect(EstadoCurso::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCursos::route('/'),
            'create' => Pages\CreateCurso::route('/create'),
            'edit' => Pages\EditCurso::route('/{record}/edit'),
        ];
    }
}
