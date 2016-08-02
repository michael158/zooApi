<?php

namespace App\Http\Controllers;

use AoScrud\Controllers\ScrudController;
use App\Models\Seal;
use App\Services\BabySealService;

class BabySealsController extends ScrudController
{

    public function __construct(BabySealService $service)
    {
        $this->service = $service;
    }

    public function seals()
    {
        return ['data' => Seal::all()];
    }

}
