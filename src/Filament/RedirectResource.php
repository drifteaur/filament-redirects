<?php

namespace Codedor\FilamentRedirects\Filament;

use Codedor\FilamentRedirects\Filament\RedirectResource\Pages\ManageRedirects;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RedirectResource extends Resource
{
    protected static ?string $model = \Codedor\FilamentRedirects\Models\Redirect::class;

    protected static ?string $navigationGroup = 'SEO';

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('from')
                    ->required(),

                Forms\Components\TextInput::make('to')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        301 => __('301 - Permanent redirect'),
                        302 => __('302 - Temporary redirect'),
                        410 => __('410 - Gone (for page that once existed, but is gone now)'),
                    ]),

                Forms\Components\Toggle::make('pass_query_string')
                    ->default(false),

                Forms\Components\Toggle::make('online')
                    ->default(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from')
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRedirects::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->ordered();
    }
}
