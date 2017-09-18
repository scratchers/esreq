<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $asu = '"name":"Arkansas State University - Jonesboro","url":"https:\/\/www.astate.edu\/","latitude":35.843086,"longitude":-90.674859';
            $browser
                ->visit('/register')
                ->assertSee('Register')
                ->type('institution', 'Arkansas State University - Jonesboro')
                ->press('Register')
                ->assertPathIs('/institutions/create')
                ->type('url', 'https://www.astate.edu/')
                ->press('Submit')
                ->assertPathIs('/register')
                ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->type('email', 'johndoe@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('Register')
                ->assertPathIs('/home')
                ->visit('/institutions?json')
                ->assertSee($asu)
                ->visit('/shibboleth-logout')
            ;
        });
    }

    public function test_user_can_register_drag_drop_location()
    {
        $this->browse(function (Browser $browser) {
            $asu = '"name":"Arkansas State University - Jonesboro","url":"https:\/\/www.astate.edu\/","latitude":35.843086,"longitude":-95.06939';
            $browser
                ->visit('/register')
                ->assertSee('Register')
                ->type('institution', 'Arkansas State University - Jonesboro')
                ->press('Register')
                ->type('url', 'https://www.astate.edu/')
                ->dragLeft('#map img', 100)
                ->press('Submit')
                ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->type('email', 'johndoe@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('Register')
                ->visit('/institutions?json')
                ->assertSee($asu)
            ;
        });
    }
}
