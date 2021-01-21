<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ARegisterExistUserTest extends DuskTestCase
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
                    ->type('#name','Test')
                    ->type('#surname','Kullanıcı')
                    ->type('#email','test@test.com')
                    ->type('#pass','123')
                    ->click('button')
                    ->waitForDialog()
                    ->assertDialogOpened('Bu E-Posta Adresine Ait Bir Kullanıcı Mevcut');
        });
    }
}
