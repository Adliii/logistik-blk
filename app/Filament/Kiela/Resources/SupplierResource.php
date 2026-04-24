<?php

namespace App\Filament\Kiela\Resources;

use App\Filament\Kiela\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- KODE SILUMAN (Otomatis Generate SPL-000X) ---
                Forms\Components\Hidden::make('kode_supplier')
                    ->default(function () {
                        $lastSupplier = \App\Models\Supplier::orderBy('suppliers_id', 'desc')->first();
            
                        if (! $lastSupplier) {
                            return 'SPL-0001';
                        }
            
                        $lastCode = $lastSupplier->kode_supplier;
                        $numberOnly = (int) substr($lastCode, 4);
                        $newNumber = $numberOnly + 1;
            
                        return 'SPL-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                    }),

                Forms\Components\TextInput::make('nama_supplier')
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
                    // Tables\Columns\TextColumn::make('suppliers_id') 
                    //     ->label('ID Supplier')
                    //     ->sortable()
                    //     ->searchable(),

                // Kolom 2: Menampilkan Kode (SPL-0001)
                Tables\Columns\TextColumn::make('kode_supplier')
                    ->label('Kode Supplier')
                    ->sortable()
                    ->searchable(),
                    
                // Kolom 3: Menampilkan Nama Perusahaan
                Tables\Columns\TextColumn::make('nama_supplier')
                    ->label('Nama Supplier') 
                    ->searchable(),
                    
                // Kolom 4: Telepon
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                    
                // Kolom 5: Alamat
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
                    ExportBulkAction::make(), // Tambahan agar bisa export yang dichecklist
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}