<?php

namespace App\Filament\Resources\SupplyItemResource\Pages;

use App\Filament\Resources\SupplyItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplyItems extends ListRecords
{
    protected static string $resource = SupplyItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
