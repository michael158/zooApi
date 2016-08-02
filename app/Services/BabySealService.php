<?php

namespace App\Services;

use AoScrud\Services\ScrudService;
use App\Models\BabySeal;
use App\Models\Seal;

class BabySealService extends ScrudService
{

    protected $model = BabySeal::class;

    public function __construct()
    {
        parent::__construct();


        // SEARCH // ---------------------------------------------------------------------------------------------------
        $this->search
            ->model($this->model)
            ->columns(['id', 'name', 'date_birth', 'live'])
            ->otherColumns(['seal_id', 'created_at', 'updated_at'])
            ->with([
                'mother' => [
                    'columns' => ['id', 'name', 'qtd_childrens', 'date_birth'],
                    'otherColumns' => ['created_at', 'updated_at']
                ]
            ])
            ->rules([
                'default' => '=',
                [
                    ['name' => '%like%|get:search'],
                    ['live' => '%like%|get:search'],
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
            ->columns(['name', 'date_birth', 'live', 'seal_id'])
            ->rules([
                    'name' => 'required|max:255',
                    'date_birth' => 'required|date',
                    'live' => 'sometimes|int',
                    'seal_id' => 'int|exists:seals,id'
                ]
            )->onExecuteEnd(function ($config, $result) {
                $mother = Seal::find($result->seal_id);
                if ($result->live) {
                    $mother->qtd_childrens++;
                } else {
                    $mother->qtd_deaths++;
                }
                $mother->save();
            });

        // UPDATE // ---------------------------------------------------------------------------------------------------
        $this->update
            ->model($this->model)
            ->columns($this->create->columns()->all())
            ->rules($this->create->rules()->all())
            ->onPrepareEnd(function ($config) {
                $config->data()->put('seal_id', $config->obj()->seal_id);

                if ($config->obj()->live != $config->data()->get('live')) {
                    $config->data()->put('update', 1);
                } else {
                    $config->data()->put('update', 0);
                }
            })
            ->onExecuteEnd(function ($config, $result) {
                if ($config->data()->get('update')) {
                    $mother = Seal::find($config->data()->get('seal_id'));
                    if ($config->data()->get('live') == 0) {
                        $mother->qtd_childrens--;
                        $mother->qtd_deaths++;
                    }else{
                        $mother->qtd_childrens++;
                        $mother->qtd_deaths--;
                    }
                    $mother->save();
                }
            });

        // DESTROY // --------------------------------------------------------------------------------------------------
        $this->destroy
            ->model($this->model)
            ->onPrepareEnd(function ($config) {
                $baby = BabySeal::find($config->data()->get('id'));
                $config->data()->put('seal_id', $baby->seal_id);
            })
            ->onExecuteEnd(function ($config, $result) {
                $mother = Seal::find($config->data()->get('seal_id'));
                $mother->qtd_childrens--;
                $mother->save();
            });

    }


}