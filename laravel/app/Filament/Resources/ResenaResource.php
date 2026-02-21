<?php

namespace App\Filament\Resources;

use App\Enums\EstadoResena;
use App\Filament\Resources\ResenaResource\Pages;
use App\Models\Resena;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ResenaResource extends Resource
{
    protected static ?string $model = Resena::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reseñas';

    protected static ?string $modelLabel = 'Reseña';

    protected static ?string $pluralModelLabel = 'Reseñas';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'email')
                            ->disabled(),
                        Forms\Components\Select::make('curso_id')
                            ->label('Curso')
                            ->relationship('curso', 'nombre')
                            ->disabled(),
                        Forms\Components\TextInput::make('puntuacion')
                            ->label('Puntuación')
                            ->disabled(),
                        Forms\Components\Select::make('estado')
                            ->options(collect(EstadoResena::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\Textarea::make('texto')
                            ->disabled()
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso.nombre')
                    ->label('Curso')
                    ->limit(25),
                Tables\Columns\TextColumn::make('puntuacion')
                    ->label('Nota')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('texto')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (EstadoResena $state) => $state->label())
                    ->color(fn (EstadoResena $state) => match ($state) {
                        EstadoResena::Pendiente => 'warning',
                        EstadoResena::Aprobada => 'success',
                        EstadoResena::Rechazada => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options(collect(EstadoResena::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
            ])
            ->actions([
                Tables\Actions\Action::make('aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Resena $record) => $record->estado === EstadoResena::Pendiente)
                    ->action(fn (Resena $record) => $record->update(['estado' => EstadoResena::Aprobada])),
                Tables\Actions\Action::make('rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Resena $record) => $record->estado === EstadoResena::Pendiente)
                    ->action(fn (Resena $record) => $record->update(['estado' => EstadoResena::Rechazada])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResenas::route('/'),
            'edit' => Pages\EditResena::route('/{record}/edit'),
        ];
    }
}
