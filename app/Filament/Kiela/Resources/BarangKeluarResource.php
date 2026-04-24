<?php

namespace App\Filament\Kiela\Resources;

use App\Filament\Kiela\Resources\BarangKeluarResource\Pages;
use App\Filament\Kiela\Resources\BarangKeluarResource\RelationManagers;
use App\Models\BarangKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Barang Keluar';
    protected static ?string $pluralModelLabel = 'Barang Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'nama_barang')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'nama_customer') // HARUS 'customer', bukan 'supplier'
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->required()
                    ->rules([
                        fn (\Filament\Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            // Ambil ID produk yang sedang dipilih di form
                            $productId = $get('product_id'); 
                            
                            if ($productId) {
                                // Cari data produk tersebut di database
                                $product = Product::find($productId);
                                
                                // Jika jumlah yang diketik lebih besar dari stok asli...
                                if ($product && $value > $product->stok) {
                                    // Gagalkan proses dan munculkan tulisan merah ini!
                                    $fail("Stok kurang kocak: {$product->stok}");
                                }
                            }
                        },
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.kode_barang')
                    ->label('Kode Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.nama_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.nama_customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ExportAction::make()
            ->label('Export Excell')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBarangKeluars::route('/'),
            'create' => Pages\CreateBarangKeluar::route('/create'),
            'edit' => Pages\EditBarangKeluar::route('/{record}/edit'),
        ];
    }
}