<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class StaticPageControllerTest extends TestCase
{

    // todo - refactor this test since the static page controller doesn't exist
    /** @test */
    public function itShouldDisplayTheTeachersDirectoryToGuestUser()
    {
        $response = $this->get('/teachersDirectory');

        $response->assertStatus(200);
        $response->assertViewIs('teachers.teachersDirectory');
    }

    /** @test */
    public function itShouldDisplayTheFeedbackFormToGuestUser()
    {
        $response = $this->get('/feedback');

        $response->assertStatus(200);
        $response->assertViewIs('feedback.show');
    }

}
