<?php

namespace App\Http\Controllers;

use AoScrud\Controllers\ScrudController;
use App\Services\SealService;

class SealsController extends ScrudController
{

    public function __construct(SealService $service)
    {
        $this->service = $service;
    }

    public function mostProductive()
    {
        return $this->service->mostProductive();
    }

}
