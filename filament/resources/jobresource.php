<?php

namespace Modules\Job\Filament\Resources;

use Modules\Job\Filament\Resources\JobResource\Pages;
use Modules\Job\Filament\Resources\JobResource\RelationManagers;
use Modules\Job\Models\Job;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Savannabits\FilamentModules\Concerns\ContextualResource;

class JobResource extends Resource
{
    use ContextualResource;
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'jobs';

    protected static ?string $recordTitleAttribute='name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('queue'),
                
                //Tables\Columns\TextColumn::make('payload'),
                Tables\Columns\TextColumn::make('attempts'),
                Tables\Columns\TextColumn::make('reserved_at'),
                Tables\Columns\TextColumn::make('available_at'),
                Tables\Columns\TextColumn::make('created_at'),
                //Tables\Columns\TextColumn::make('created_by'),
                //Tables\Columns\TextColumn::make('updated_by'),
                //Tables\Columns\TextColumn::make('updated_at'),
                Tables\Columns\ViewColumn::make('payload')->view('ui::filament.tables.columns.array'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }    
}
