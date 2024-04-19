<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetEstimationsService
{
    public function getEstimations(): array
    {
        // get the new estimation from the external API
        return Http::get(config('services.estimation.url'))->json();
    }
}
