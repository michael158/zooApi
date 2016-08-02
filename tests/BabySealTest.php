<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BabySealTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/baby-seals');
    }

    public function testStore()
    {
        $this->post('/baby-seals', [
            'name' => 'Testing',
            'date_birth' => date('Y-m-d')
        ]);
    }

    public function testUpdate()
    {
        $this->put('/baby-seals/1', [
            'name' => 'Testing',
            'date_birth' => date('Y-m-d')
        ]);
    }

    public function testShow()
    {
        $this->get('/baby-seals/1');
    }

    public function testDelete()
    {
        $this->delete('/baby-seals/1');
    }
}
