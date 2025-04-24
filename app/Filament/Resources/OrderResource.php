<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select};
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Sales';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('customer_id')
                ->label('Customer')
                ->relationship('customer', 'name')
                ->nullable()
                ->preload()
                ->searchable(),

            // TextInput::make('customer_name')
            //     ->required(),

            // TextInput::make('customer_email')
            //     ->email()
            //     ->required(),

            // TextInput::make('quantity')
            //     ->numeric()
            //     ->minValue(1)
            //     ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->label('Order ID')->sortable(),
            
            // Show Customer Name
            TextColumn::make('customer.name')
                ->label('Customer Name')
                ->searchable()
                ->sortable(),

            // Show Customer Email (optional)
            TextColumn::make('customer.email')
                ->label('Customer Email')
                ->searchable(),

            TextColumn::make('product.name')
                ->label('Product Name')
                ->sortable()
                ->searchable(),

            TextColumn::make('quantity')
                ->label('Quantity'),

            TextColumn::make('created_at')
                ->label('Ordered On')
                ->dateTime('M d, Y H:i')
                ->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
