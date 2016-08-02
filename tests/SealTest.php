<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SealTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/seals');
    }

    public function testStore()
    {
        $this->post('/seals', [
            'name' => 'Testing',
            'date_birth' => date('Y-m-d')
        ]);
    }

    public function testUpdate()
    {
        $this->put('/seals/1', [
            'name' => 'Testing',
            'date_birth' => date('Y-m-d')
        ]);
    }

    public function testShow()
    {
        $this->get('/seals/1');
    }

    public function testDelete()
    {
        $this->delete('/seals/1');
    }
}
