<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('added_on')
                    ->label(__('Added on'))
                    ->required(),
                Forms\Components\TextInput::make('lead_name')
                    ->label(__('Lead name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sales_rep_name')
                    ->label(__('Sales representative name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_closed')
                    ->label(__('Is closed'))
                    ->required(),
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('Lead');
    }

    public static function getModelLabel(): string
    {
        return __('lead');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('added_on')
                    ->label(__('Added on'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lead_name')
                    ->label(__('Lead name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_rep_name')
                    ->label(__('Sales representative name'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_closed')
                    ->label(__('Is closed'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ]),
            ]);
    }
}
