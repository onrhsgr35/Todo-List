<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FCreateProjectTest extends DuskTestCase
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
                    ->click('a[href="yeni-proje-ekle"]')
                    ->type('input[name="date"]','15.01.2021')
                    ->type('input[name="name"]','Proje Adı')
                    ->type('input[name="technician"]','Teknik Uzman')
                    ->type('input[name="actualtime"]','100')
                    ->type('textarea[name="desc"]','Açıklama')
                    ->type('textarea[name="notes"]','Notlar')
                    ->click('button[name="create"]')
                    ->waitForDialog()
                    ->assertDialogOpened('Proje oluşturma işlemi başarı ile tamamlandı.');
        });
    }
}
