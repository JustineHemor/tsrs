<?php

namespace App\Filament\Resources\SupplyItemResource\Pages;

use App\Filament\Resources\SupplyItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplyItem extends EditRecord
{
    protected static string $resource = SupplyItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
