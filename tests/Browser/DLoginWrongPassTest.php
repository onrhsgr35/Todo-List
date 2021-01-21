<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DLoginWrongPassTest extends DuskTestCase
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
                    ->type('input[name="pass"]','1234')
                    ->check('input[name="rememberme"]')
                    ->click('button[name="login"]')
                    ->waitForDialog()
                    ->assertDialogOpened('Girmiş Olduğunuz Şifre Yanlış');
        });
    }
}
