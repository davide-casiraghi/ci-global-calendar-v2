<?php

namespace Tests\Feature\Controllers;

use App\Models\DonationOffer;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class DonationOfferControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private DonationOffer $donationOffer1;
    private DonationOffer $donationOffer2;
    private DonationOffer $donationOffer3;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->user1 = User::factory()->create(['email' => 'admin@gmail.com']);
        $userProfile = UserProfile::factory()->create(['user_id' => $this->user1->id]);

        $this->donationOffer1 = DonationOffer::factory()->create(['user_id' => 1]);
        //$this->donationOffer2 = DonationOffer::factory()->create(['user_id' => 1]);
        //$this->donationOffer3 = DonationOffer::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheDonationOffersIndexPageToLoginPage()
    {
        $response = $this->get('donationOffers');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheDonationOffersIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('donationOffers');

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutDonationOfferIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('donationOffers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheDonationOffersIndexViewToAdminWithDonationOfferIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('donation_offer.view');

        $response = $this->get('donationOffers');

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.index');
    }

    /** @test */
    public function itShouldNotDisplayTheDonationOffersShowViewToGuestUser()
    {
        // Not show, since the donationOffer info are shown just in the events.show view

        $response = $this->get("/donationOffers/{$this->donationOffer1->id}");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheDonationOffersCreatePageToLoginPage()
    {
        $response = $this->get('/donationOffers/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheDonationOffersCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/donationOffers/create");

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheDonationOfferCreatePageWithoutDonationOfferCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/donationOffers/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheDonationOffersCreateViewToManagerWithDonationOfferCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('donation_offer.create');

        $response = $this->get("/donationOffers/create");

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheDonationOffersEditPageToLoginPage()
    {
        $response = $this->get("/donationOffers/{$this->donationOffer1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheDonationOffersEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/donationOffers/{$this->donationOffer1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheDonationOfferEditPageWithoutDonationOfferEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/donationOffers/{$this->donationOffer1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheDonationOfferEditViewToManagerWithDonationOfferEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('donation_offer.edit');

        $response = $this->get("/donationOffers/{$this->donationOffer1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('donationOffers.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteDonationOffers()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/donationOffers/{$this->donationOffer1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/donationOffers');
        $this->assertModelMissing($this->donationOffer1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteADonationOfferWithoutDonationOfferDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/donationOffers/{$this->donationOffer1->id}");
        $response->assertRedirect('/donationOffers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteADonationOfferWithDonationOfferDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('donation_offer.delete');

        $response = $this->delete("/donationOffers/{$this->donationOffer1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/donationOffers');
        $this->assertNull($this->donationOffer1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidDonationOffer()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'user_id' => 1,
            'country_id' => '1',
            'name' => 'test name',
            'surname' => 'test surname',
            'email' => 'test@sdfsd.it',
            'offer_kind' => 'financial',
            'language_spoken' => 'English, Italian',
        ];
        $response = $this->post('/donationOffers', $parameters);

        $response->assertRedirect('/donationOffers');
        $this->assertDatabaseHas('donation_offers', [
            'name' => 'test name',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidDonationOffer()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/donationOffers', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidDonationOffer()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'user_id' => 1,
            'country_id' => '1',
            'name' => 'test name updated',
            'surname' => 'test surname',
            'email' => 'test@sdfsd.it',
            'offer_kind' => 'financial',
            'language_spoken' => 'English, Italian',
        ];
        $response = $this->put("/donationOffers/{$this->donationOffer1->id}", $parameters);

        $this->assertDatabaseHas('donation_offers', [
            'name' => "test name updated",
        ]);
        $response->assertRedirect('/donationOffers');
    }

}
