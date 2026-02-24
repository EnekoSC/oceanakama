<?php

namespace App\Filament\Resources\ReservaResource\Pages;

use App\Enums\EstadoReserva;
use App\Filament\Resources\ReservaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReserva extends EditRecord
{
    protected static string $resource = ReservaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('confirmar')
                ->label('Confirmar')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Confirmar reserva')
                ->modalDescription('¿Estás seguro de que quieres confirmar esta reserva? Se enviará un email de confirmación al usuario.')
                ->visible(fn () => $this->record->estado === EstadoReserva::Pendiente)
                ->action(function () {
                    $this->record->update(['estado' => EstadoReserva::Confirmada]);
                    $this->refreshFormData(['estado']);
                }),
            Actions\Action::make('cancelar')
                ->label('Cancelar reserva')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Cancelar reserva')
                ->modalDescription('¿Estás seguro de que quieres cancelar esta reserva? Se liberará la plaza.')
                ->visible(fn () => in_array($this->record->estado, [EstadoReserva::Pendiente, EstadoReserva::Confirmada]))
                ->action(function () {
                    $this->record->update(['estado' => EstadoReserva::Cancelada]);
                    $this->refreshFormData(['estado']);
                }),
        ];
    }
}
