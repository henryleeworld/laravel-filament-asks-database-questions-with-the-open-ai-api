<?php

namespace App\Filament\Resources\Leads\Pages;

use App\Filament\Imports\LeadImporter;
use App\Filament\Resources\Leads\LeadResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->label(__('Import lead'))
                ->importer(LeadImporter::class)
                ->modalHeading(__('Import lead'))
        ];
    }
}
