<?php

namespace App\Services;

use AoScrud\Services\ScrudService;
use App\Models\Seal;
use App\Utils\DateHelper;

class SealService extends ScrudService
{

    protected $model = Seal::class;

    public function __construct()
    {
        parent::__construct();


        // SEARCH // ---------------------------------------------------------------------------------------------------
        $this->search
            ->model($this->model)
            ->columns(['id', 'name' ,'date_birth' , 'qtd_childrens','qtd_deaths'])
            ->otherColumns(['created_at', 'updated_at'])
            ->orders(['id'])
            ->with([
                'babies' => [
                    'columns' => ['id', 'name', 'live', 'date_birth','seal_id'],
                    'otherColumns' => ['created_at', 'updated_at']
                ]
            ])
            ->rules([
                'default' => '=',
                [
                    ['name' => '%like%|get:search'],
                    ['qtd_childrens' => '%like%|get:search'],
                ]
            ]);

        // READ // -----------------------------------------------------------------------------------------------------
        $this->read
            ->model($this->model)
            ->columns($this->search->columns()->all())
            ->otherColumns($this->search->otherColumns()->all())
            ->with($this->search->with()->all());

        // CREATE // ---------------------------------------------------------------------------------------------------
        $this->create
            ->model($this->model)
            ->columns(['name', 'date_birth'])
            ->rules([
                    'name' => 'required|max:255',
                    'date_birth' => 'required|date'
                ]
            );

        // UPDATE // ---------------------------------------------------------------------------------------------------
        $this->update
            ->model($this->model)
            ->columns($this->create->columns()->all())
            ->rules($this->create->rules()->all());

        // DESTROY // --------------------------------------------------------------------------------------------------
        $this->destroy
            ->model($this->model);

    }


    public function mostProductive()
    {
        $model = app()->make($this->model);
        $seal = $model->orderBy('qtd_childrens','desc')->first();

        $seal->age = DateHelper::getAge($seal->date_birth);

        return $seal;
    }


}