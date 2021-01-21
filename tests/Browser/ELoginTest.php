<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ELoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/giris-yap')
                    ->type('input[name="email"]','test2@test.com')
                    ->type('input[name="pass"]','123')
                    ->check('input[name="rememberme"]')
                    ->click('button[name="login"]')
                    ->waitForLocation('/')
                    ->assertPathIs('/');
        });
    }
}
