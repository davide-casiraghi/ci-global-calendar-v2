<?php

namespace Tests\Feature\Controllers;

use App\Models\HomepageMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class HomepageMessageControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private HomepageMessage $homepageMessage1;
    private HomepageMessage $homepageMessage2;
    private HomepageMessage $homepageMessage3;

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

        $this->homepageMessage1 = HomepageMessage::factory()->create();
        $this->homepageMessage2 = HomepageMessage::factory()->create();
        $this->homepageMessage3 = HomepageMessage::factory()->create();
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheHomepageMessagesIndexPageToLoginPage()
    {
        $response = $this->get('homepageMessages');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheHomepageMessagesIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('homepageMessages');

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutHomepageMessageIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('homepageMessages');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheHomepageMessagesIndexViewToAdminWithHomepageMessageIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('homepage_messages.view');

        $response = $this->get('homepageMessages');

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.index');
    }

    /** @test */
    public function itShouldNotDisplayTheHomepageMessagesShowViewToGuestUser()
    {
        $response = $this->get("/homepageMessages/{$this->homepageMessage1->id}");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheHomepageMessagesCreatePageToLoginPage()
    {
        $response = $this->get('/homepageMessages/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheHomepageMessagesCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/homepageMessages/create");

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheHomepageMessageCreatePageWithoutHomepageMessageCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/homepageMessages/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheHomepageMessagesCreateViewToManagerWithHomepageMessageCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('homepage_messages.create');

        $response = $this->get("/homepageMessages/create");

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheHomepageMessagesEditPageToLoginPage()
    {
        $response = $this->get("/homepageMessages/{$this->homepageMessage1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheHomepageMessagesEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/homepageMessages/{$this->homepageMessage1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheHomepageMessageEditPageWithoutHomepageMessageEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/homepageMessages/{$this->homepageMessage1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheHomepageMessageEditViewToManagerWithHomepageMessageEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('homepage_messages.edit');

        $response = $this->get("/homepageMessages/{$this->homepageMessage1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('homepageMessages.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteHomepageMessages()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/homepageMessages/{$this->homepageMessage1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/homepageMessages');
        $this->assertModelMissing($this->homepageMessage1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAHomepageMessageWithoutHomepageMessageDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/homepageMessages/{$this->homepageMessage1->id}");
        $response->assertRedirect('/homepageMessages');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAHomepageMessageWithHomepageMessageDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('homepage_messages.delete');

        $response = $this->delete("/homepageMessages/{$this->homepageMessage1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/homepageMessages');
        $this->assertNull($this->homepageMessage1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidHomepageMessage()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title',
            'body' => 'test body',
            'color' => 'gray',
        ];
        $response = $this->post('/homepageMessages', $parameters);

        $response->assertRedirect('/homepageMessages');
        $this->assertDatabaseHas('homepage_messages', [
            'title' => 'test title',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidHomepageMessage()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/homepageMessages', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidHomepageMessage()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title updated',
            'body' => 'test body',
            'color' => 'gray',
        ];
        $response = $this->put("/homepageMessages/{$this->homepageMessage1->id}", $parameters);

        $this->assertDatabaseHas('homepage_messages', [
            'title' => "test title updated",
        ]);
        $response->assertRedirect('/homepageMessages');
    }

}
