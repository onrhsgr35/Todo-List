<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BRegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/kayit-ol')
                    ->type('#name','Test 2')
                    ->type('#surname','Kullanıcı')
                    ->type('#email','test2@test.com')
                    ->type('#pass','123')
                    ->click('button')
                    ->waitForLocation('/giris-yap')
                    ->assertPathIs('/giris-yap');
        });
    }
}
