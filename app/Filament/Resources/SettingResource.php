<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = false;


    protected static ?string $label = 'General Setting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->description('input a general setting to define your website with label and content.')
                    ->aside()
                    ->schema([
                        TextInput::make('label'),
                        RichEditor::make('content')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'redo',
                                'strike',
                                'undo',
                            ])
                    ]),
                Section::make('Meta')
                    ->description('Optional data, allow you to make more complex information.')
                    ->aside()
                    ->schema([
                        KeyValue::make('meta'),
                    ]),
                Section::make('Publish')
                    ->description('Publish or hide this setting.')
                    ->aside()
                    ->schema([
                        Toggle::make('is_active')
                        ->reactive()
                        ->label(function ($state) {
                            return $state == 1 ? 'Active' : 'Inactive';
                        })
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->searchable(),
                ToggleColumn::make('is_active'),
                TextColumn::make('created_at')
                ->sortable()
                ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
