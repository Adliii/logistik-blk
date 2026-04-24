<?php

namespace App\Filament\Kiela\Resources\CustomerResource\Pages;

use App\Filament\Kiela\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
