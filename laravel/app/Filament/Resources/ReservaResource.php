<?php

namespace App\Filament\Resources;

use App\Enums\EstadoReserva;
use App\Filament\Resources\ReservaResource\Pages;
use App\Models\Reserva;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ReservaResource extends Resource
{
    protected static ?string $model = Reserva::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Reservas';

    protected static ?string $modelLabel = 'Reserva';

    protected static ?string $pluralModelLabel = 'Reservas';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de la reserva')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('curso_id')
                            ->label('Curso')
                            ->relationship('curso', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('estado')
                            ->options(collect(EstadoReserva::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                            ->required()
                            ->default(EstadoReserva::Pendiente->value),
                        Forms\Components\TextInput::make('precio_pagado')
                            ->numeric()
                            ->prefix('€')
                            ->step('0.01'),
                    ])->columns(2),

                Forms\Components\Section::make('Stripe')
                    ->schema([
                        Forms\Components\TextInput::make('stripe_session_id')
                            ->label('Session ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('stripe_payment_intent_id')
                            ->label('Payment Intent ID')
                            ->disabled(),
                        Forms\Components\TextInput::make('metodo_pago')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('pagado_en')
                            ->disabled(),
                    ])->columns(2)->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('curso.nombre')
                    ->label('Curso')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (EstadoReserva $state) => $state->label())
                    ->color(fn (EstadoReserva $state) => match ($state) {
                        EstadoReserva::Pendiente => 'info',
                        EstadoReserva::PendientePago => 'warning',
                        EstadoReserva::Confirmada => 'success',
                        EstadoReserva::Cancelada => 'danger',
                    }),
                Tables\Columns\TextColumn::make('precio_pagado')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pagado_en')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options(collect(EstadoReserva::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),
            ])
            ->actions([
                Action::make('confirmar')
                    ->label('Confirmar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar reserva')
                    ->modalDescription('¿Estás seguro de que quieres confirmar esta reserva? Se enviará un email de confirmación al usuario.')
                    ->visible(fn (Reserva $record) => $record->estado === EstadoReserva::Pendiente)
                    ->action(fn (Reserva $record) => $record->update(['estado' => EstadoReserva::Confirmada])),
                Action::make('cancelar')
                    ->label('Cancelar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancelar reserva')
                    ->modalDescription('¿Estás seguro de que quieres cancelar esta reserva? Se liberará la plaza.')
                    ->visible(fn (Reserva $record) => in_array($record->estado, [EstadoReserva::Pendiente, EstadoReserva::Confirmada]))
                    ->action(fn (Reserva $record) => $record->update(['estado' => EstadoReserva::Cancelada])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservas::route('/'),
            'edit' => Pages\EditReserva::route('/{record}/edit'),
        ];
    }
}
