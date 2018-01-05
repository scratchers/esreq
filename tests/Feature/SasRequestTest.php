<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEsrequest;
use App\Platform;
use App\Esrequest;

class SasRequestTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_request_sas_platform()
    {
        Mail::fake();

        $request = make(Esrequest::class)->toArray();
        $data = $request;
        $sas = Platform::where('name', 'SAS')->first();
        $data['platform'] = [$sas->id];

        $response = $this
            ->signIn()
            ->post('/requests', $data)
            ->assertStatus(302)
        ;

        $this->assertDatabaseHas('esrequests', $request);

        $request = Esrequest::where('user_comment', $request['user_comment'])->first();

        $response->assertRedirect("/requests/{$request->id}");

        $this
            ->get("/requests/{$request->id}")
            ->assertSee(e($request->user_comment))
        ;

        $this->assertDatabaseHas('esrequest_platform', [
            'esrequest_id' => $request->id,
            'platform_id' => $sas->id,
        ]);

        Mail::assertSent(NewEsrequest::class, function ($mail) use ($request) {
            return $mail->esrequest->id === $request->id;
        });
    }

    public function test_non_uark_users_cannot_request_sas()
    {
        Mail::fake();

        $data = make(Esrequest::class)->toArray();
        $sas = Platform::where('name', 'SAS')->first();
        $data['platform'] = [$sas->id];

        $this
            ->signIn()
            ->post('/requests', $data)
            ->assertStatus(403)
        ;
    }
}
