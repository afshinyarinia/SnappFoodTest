<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetEstimationsService
{
    public function getEstimations(): array
    {
        // get the new estimation from the external API
        if(config('services.estimation.type') === 'test'){
            return [
                'estimation' => random_int(1,40),
            ];
        }
        return Http::get(config('services.estimation.url'))->json();
    }
}
