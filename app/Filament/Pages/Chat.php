<?php

namespace App\Filament\Pages;

use App\Services\GPTEngine;
use BackedEnum;
use Exception;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;

class Chat extends Page
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected string $view = 'filament.app.pages.chat';

    public ?array $data = [];
    public bool $waitingForResponse = false;
    public string $reply = '';
    public string $lastQuestion = '';

    public function create(): void
    {
        $this->reply = '';
        $this->waitingForResponse = true;
        $message = $this->form->getState()['message'];
        $this->data['message'] = '';

        $this->dispatch('queryAI', $message);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('message')
                    ->label(__('Message'))
                    ->required()
            ])
            ->statePath('data');
    }

    public function getHeading(): string
    {
        return __('Chats');
    }

    public static function getNavigationLabel(): string
    {
        return __('Chats');
    }

    #[On('queryAI')]
    public function queryAI($message)
    {
        try {
            $this->reply = (new GPTEngine())->ask($message);
        } catch (Exception $e) {
            info($e->getMessage());
            $this->reply = __('Sorry, the AI assistant was unable to answer your question. Please try to rephrase your question.');
            $this->data['message'] = $this->lastQuestion;
        }
        $this->lastQuestion = $message;
        $this->waitingForResponse = false;
    }
}
