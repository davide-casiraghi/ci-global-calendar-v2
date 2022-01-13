<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class StaticPageControllerTest extends TestCase
{
    /** @test */
    public function itShouldDisplayTheAboutMePageToGuestUser()
    {
        $response = $this->get('/about-me');

        $response->assertStatus(200);
        $response->assertViewIs('pages.aboutMe');
    }

    /** @test */
    public function itShouldDisplayTheTreatmentsPageToGuestUser()
    {
        $response = $this->get('/treatments-ilan-lev-method');

        $response->assertStatus(200);
        $response->assertViewIs('pages.treatments');
    }

    /** @test */
    public function itShouldDisplayTheTreatmentsLearnMorePageToGuestUser()
    {
        $response = $this->get('/learn-more-ilan-lev-method');

        $response->assertStatus(200);
        $response->assertViewIs('pages.treatmentsLearnMore');
    }

    /** @test */
    public function itShouldDisplayTheContactImprovisationPageToGuestUser()
    {
        $response = $this->get('/contact-improvisation');

        $response->assertStatus(200);
        $response->assertViewIs('pages.contactImprovisation');
    }

    /** @test */
    public function itShouldDisplayTheWaterContactPageToGuestUser()
    {
        $response = $this->get('/water-contact');

        $response->assertStatus(200);
        $response->assertViewIs('pages.waterContact');
    }
}
