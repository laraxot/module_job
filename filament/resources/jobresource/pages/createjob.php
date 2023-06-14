<?php

namespace Modules\Job\Filament\Resources\JobResource\Pages;

use Modules\Job\Filament\Resources\JobResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;
}
