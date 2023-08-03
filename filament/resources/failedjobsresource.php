<?php

namespace Modules\Job\Filament\Resources;

use Filament\Resources\Form;
use Webmozart\Assert\Assert;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Job\Models\FailedJob;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Artisan;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;
use Savannabits\FilamentModules\Concerns\ContextualResource;
use Modules\Job\Filament\Resources\FailedJobsResource\Pages\ListFailedJobs;

class FailedJobsResource extends Resource
{
	use ContextualResource;

	protected static ?string $model = FailedJob::class;

	protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

	protected static ?string $navigationGroup = 'jobs';

	protected static function getNavigationBadge(): ?string
	{
		return (string) FailedJob::query()->count();
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				TextInput::make('uuid')->disabled()->columnSpan(4),
				TextInput::make('failed_at')->disabled(),
				TextInput::make('id')->disabled(),
				TextInput::make('connection')->disabled(),
				TextInput::make('queue')->disabled(),

				// make text a little bit smaller because often a complete Stack Trace is shown:
				TextArea::make('exception')->disabled()->columnSpan(4)->extraInputAttributes(['style' => 'font-size: 80%;']),
				JSONEditor::make('payload')->disabled()->columnSpan(4),
			])->columns(4);
	}

	public static function table(Table $table): Table
	{
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')->sortable()->searchable()->toggleable(),
				TextColumn::make('failed_at')->sortable()->searchable(false)->toggleable(),
				TextColumn::make('exception')
					->sortable()
					->searchable()
					->toggleable()
					->wrap()
					->limit(200)
					->tooltip(fn (FailedJob $record) => "{$record->failed_at} UUID: {$record->uuid}; Connection: {$record->connection}; Queue: {$record->queue};"),
				TextColumn::make('uuid')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('connection')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('queue')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([])
			->bulkActions([
				BulkAction::make('retry')
					->label('Retry')
					->requiresConfirmation()
					->action(function (Collection $records): void {
						foreach ($records as $record) {
							//Cannot access property $uuid on mixed.
							Assert::isInstanceOf($record,FailedJob::class);
							Artisan::call("queue:retry {$record->uuid}");
						}
						Notification::make()
							->title("{$records->count()} jobs have been pushed back onto the queue.")
							->success()
							->send();
					}),
			])
			->actions([
				DeleteAction::make('Delete'),
				ViewAction::make('View'),
				Action::make('retry')
					->label('Retry')
					->requiresConfirmation()
					->action(function (FailedJob $record): void {
						Artisan::call("queue:retry {$record->uuid}");
						Notification::make()
							->title("The job with uuid '{$record->uuid}' has been pushed back onto the queue.")
							->success()
							->send();
					}),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => ListFailedJobs::route('/'),
		];
	}
}
