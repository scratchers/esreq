<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Institution;

class RegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $asu = '35.843086';
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
                ->assertSourceHas($asu)
                ->visit('/shibboleth-logout')
            ;
        });
    }

    public function test_user_can_register_drag_drop_location()
    {
        $this->browse(function (Browser $browser) {
            $asu = '35.843086';
            $browser
                ->visit('/register')
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
                ->assertPathIs('/home')
                ->visit('/institutions?json')
                ->assertSourceHas($asu)
                ->visit('/shibboleth-logout')
            ;
        });
    }

    public function test_user_can_register_with_existing_institution()
    {
        $this->browse(function (Browser $browser) {
            $institution = create(Institution::class);

            $browser
                ->visit('/register')
                ->type('institution', substr($institution->name, 0, -1))
                ->waitFor('#ui-id-1')
                ->click('#ui-id-1 li:first-child')
                ->press('Register')
                ->assertPathIs('/register')
                ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->type('email', 'johndoe@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('Register')
                ->assertPathIs('/home')
                ->visit('/shibboleth-logout')
            ;
        });
    }
}
