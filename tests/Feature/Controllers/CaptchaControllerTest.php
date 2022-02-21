<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class CaptchaControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function itShouldGetTheJsonListWithPublishedImages()
    {
        $response = $this->get('/reload-captcha');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('captcha')
        );
    }

}
