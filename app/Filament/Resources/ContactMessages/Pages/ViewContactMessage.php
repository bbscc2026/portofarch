<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Read-only view of an enquiry; opening it marks it as read.
 */
class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! $this->record->read_at) {
            $this->record->update(['read_at' => now()]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->label('Reply by email')
                ->icon('heroicon-o-envelope')
                ->url(fn () => 'mailto:'.$this->record->email.'?subject='.rawurlencode('Re: your project enquiry')),
            DeleteAction::make(),
        ];
    }
}
