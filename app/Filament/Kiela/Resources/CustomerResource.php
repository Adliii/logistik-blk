<?php

namespace App\Filament\Kiela\Resources;

use App\Filament\Kiela\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction; // Tambahan untuk export banyak

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- KODE SILUMAN (Otomatis Generate CST-000X) ---
                Forms\Components\Hidden::make('kode_customer')
                    ->default(function () {
                        $lastCustomer = \App\Models\Customer::orderBy('customers_id', 'desc')->first();
            
                        if (! $lastCustomer) {
                            return 'CST-0001';
                        }
            
                        $lastCode = $lastCustomer->kode_customer;
                        $numberOnly = (int) substr($lastCode, 4);
                        $newNumber = $numberOnly + 1;
            
                        return 'CST-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                    }),

                Forms\Components\TextInput::make('nama_customer')
                    ->required(),
                Forms\Components\TextInput::make('telepon')
                    ->tel(),
                Forms\Components\TextInput::make('alamat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Menampilkan Angka ID Asli
                // Tables\Columns\TextColumn::make('customers_id')
                //     ->label('ID Customer')
                //     ->sortable()
                //     ->searchable(),
                
                // Kolom 2: Menampilkan Kode (CST-0001)
                Tables\Columns\TextColumn::make('kode_customer')
                    ->label('Kode Customer')
                    ->sortable()
                    ->searchable(),

                // Kolom 3: Menampilkan Nama Asli
                Tables\Columns\TextColumn::make('nama_customer')
                    ->label('Nama Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('telepon'),
                
                Tables\Columns\TextColumn::make('alamat')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()->label('Export Excel'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(), // Agar bisa di-export kalau dichecklist banyak
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}