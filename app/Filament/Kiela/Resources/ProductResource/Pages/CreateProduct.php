<?php

namespace App\Filament\Kiela\Resources\ProductResource\Pages;

use App\Filament\Kiela\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
