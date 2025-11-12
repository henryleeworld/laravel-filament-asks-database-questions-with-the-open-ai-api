<?php

namespace App\Filament\Imports;

use App\Models\Lead;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class LeadImporter extends Importer
{
    protected static ?string $model = Lead::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('added_on')
                ->label(__('Added on'))
                ->rules(['required', 'date'])
                ->requiredMapping(),
            ImportColumn::make('lead_name')
                ->label(__('Lead name'))
                ->rules(['required', 'max:255'])
                ->requiredMapping(),
            ImportColumn::make('sales_rep_name')
                ->label(__('Sales representative name'))
                ->rules(['required', 'max:255'])
                ->requiredMapping(),
            ImportColumn::make('is_closed')
                ->label(__('Is closed'))
                ->boolean()
                ->rules(['required', 'boolean'])
                ->requiredMapping(),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = __('Your lead import has completed and ') . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . __(' imported.');

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . __(str('row')->plural($failedRowsCount)) . __(' failed to import.');
        }

        return $body;
    }

    public function resolveRecord(): Lead
    {
        /*
        return Lead::firstOrNew([
            'id' => $this->data['id'],
        ]);
        */
        return new Lead();
    }
}
