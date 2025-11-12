<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('added_on')
                    ->label(__('Added on'))
                    ->required(),
                TextInput::make('lead_name')
                    ->label(__('Lead name'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('sales_rep_name')
                    ->label(__('Sales representative name'))
                    ->maxLength(255)
                    ->required(),
                Toggle::make('is_closed')
                    ->label(__('Is closed'))
                    ->required(),
            ]);
    }
}
