<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->get('/giris-yap')
            ->type('maburkay@gmail.com','email')
            ->type('123321ss','pass')
            ->check('rememberme')
            ->press('Giriş Yap')
            ->seePageIs('/');


        $this->assertTrue(true);
    }
}
