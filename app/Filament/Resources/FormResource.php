<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form as FormsForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(FormsForm $form): FormsForm
    {
        return $form
            ->schema([
                TextInput::make('store_name')
                    ->label('Nama Toko')
                    ->columnSpanFull(),
                FileUpload::make('store_image')
                    ->disk('public')
                    ->columnSpanFull(),
                FileUpload::make('ktp_image')
                    ->disk('public')
                    ->columnSpanFull(),
                TextInput::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),
                Repeater::make('orders')
                    ->schema([
                        Select::make('product')
                            ->searchable()
                            ->options(fn () => Product::all()->pluck('name', 'name'))
                            ->required(),
                        TextInput::make('qty')->required(),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store_name'),
                TextColumn::make('address'),
                TextColumn::make('orders')
                    ->getStateUsing(fn($record) => collect($record->orders)->count())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListForms::route('/'),
            // 'create' => Pages\CreateForm::route('/create'),
            // 'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
