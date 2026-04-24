<?php

namespace App\Filament\Kiela\Resources;

use App\Filament\Kiela\Resources\ProductResource\Pages;
use App\Filament\Kiela\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- KODE SILUMAN (Otomatis Generate BRG-000X) ---
                Forms\Components\Hidden::make('kode_barang')
                    ->default(function () {
                        $lastProduct = Product::orderBy('product_id', 'desc')->first();
            
                        if (! $lastProduct) {
                            return 'BRG-0001';
                        }
            
                        $lastCode = $lastProduct->kode_barang;
                        $numberOnly = (int) substr($lastCode, 4);
                        $newNumber = $numberOnly + 1;
            
                        return 'BRG-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                    }),
                    
                Forms\Components\TextInput::make('nama_barang')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->required(),
                    
                Forms\Components\TextInput::make('stok')
                    ->numeric()
                    ->default(0)
                    ->disabled() // Menonaktifkan kolom agar tidak bisa diketik
                    ->dehydrated(false) // Mencegah nilai kosong ditimpa saat di-save
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel'), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}