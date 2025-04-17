<?php

namespace Modules\Job\Filament\Resources\FailedJobsResource\Pages;

use Modules\Job\Models\FailedJob;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Modules\Job\Filament\Resources\FailedJobsResource;


class ListFailedJobs extends ListRecords
{
    protected static string $resource = FailedJobsResource::class;

    public function getActions(): array
    {
        return [
            Action::make('retry_all')
                ->label('Retry all failed Jobs')
                ->requiresConfirmation()
                ->action(function (): void {
                    Artisan::call('queue:retry all');
                    Notification::make()
                        ->title('All failed jobs have been pushed back onto the queue.')
                        ->success()
                        ->send();
                }),

            Action::make('delete_all')
                ->label('Delete all failed Jobs')
                ->requiresConfirmation()
                ->color('danger')
                ->action(function (): void {
                    FailedJob::truncate();
                    Notification::make()
                        ->title('All failed jobs have been removed.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
