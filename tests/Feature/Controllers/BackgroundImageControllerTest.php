<?php

namespace Tests\Feature\Controllers;

use App\Models\BackgroundImage;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class BackgroundImageControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private BackgroundImage $backgroundImage1;
    private BackgroundImage $backgroundImage2;
    private BackgroundImage $backgroundImage3;

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

        $this->backgroundImage1 = BackgroundImage::factory()->create();
        $this->backgroundImage2 = BackgroundImage::factory()->create();
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheBackgroundImagesIndexPageToLoginPage()
    {
        $response = $this->get('backgroundImages');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheBackgroundImagesIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('backgroundImages');

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutBackgroundImageIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('backgroundImages');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheBackgroundImagesIndexViewToAdminWithBackgroundImageIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('background_images.view');

        $response = $this->get('backgroundImages');

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.index');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheBackgroundImagesCreatePageToLoginPage()
    {
        $response = $this->get('/backgroundImages/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheBackgroundImagesCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/backgroundImages/create");

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheBackgroundImageCreatePageWithoutBackgroundImageCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/backgroundImages/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheBackgroundImagesCreateViewToManagerWithBackgroundImageCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('background_images.create');

        $response = $this->get("/backgroundImages/create");

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheBackgroundImagesEditPageToLoginPage()
    {
        $response = $this->get("/backgroundImages/{$this->backgroundImage1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheBackgroundImagesEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/backgroundImages/{$this->backgroundImage1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheBackgroundImageEditPageWithoutBackgroundImageEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/backgroundImages/{$this->backgroundImage1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheBackgroundImageEditViewToManagerWithBackgroundImageEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('background_images.edit');

        $response = $this->get("/backgroundImages/{$this->backgroundImage1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('backgroundImages.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteBackgroundImages()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/backgroundImages/{$this->backgroundImage1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/backgroundImages');
        $this->assertModelMissing($this->backgroundImage1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteABackgroundImageWithoutBackgroundImageDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/backgroundImages/{$this->backgroundImage1->id}");
        $response->assertRedirect('/backgroundImages');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteABackgroundImageWithBackgroundImageDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('background_images.delete');

        $response = $this->delete("/backgroundImages/{$this->backgroundImage1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/backgroundImages');
        $this->assertNull($this->backgroundImage1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidBackgroundImage()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test backgroundImage title',
            'description' => 'text description ',
            'photographer' => 'John Smith',
            'orientation' => 'horizontal',
        ];
        $response = $this->post('/backgroundImages', $parameters);

        $response->assertRedirect('/backgroundImages');
        $this->assertDatabaseHas('background_images', [
            'title' => 'test backgroundImage title',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidBackgroundImage()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/backgroundImages', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidBackgroundImage()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test backgroundImage title updated',
            'description' => 'text description ',
            'photographer' => 'John Smith',
            'orientation' => 'horizontal',
        ];
        $response = $this->put("/backgroundImages/{$this->backgroundImage1->id}", $parameters);

        $this->assertDatabaseHas('background_images', [
            'title' => 'test backgroundImage title updated',
        ]);
        $response->assertRedirect('/backgroundImages');
    }

    /** @test */
    public function itShouldGetTheJsonListWithPublishedImages()
    {
        $response = $this->get('/backgroundImages/jsonList');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $this->backgroundImage1->title,
            'description' => $this->backgroundImage1->description,
            'photographer' => $this->backgroundImage1->photographer,
            'orientation' => $this->backgroundImage1->orientation,
        ]);

        $response->assertJsonFragment([
            'title' => $this->backgroundImage2->title,
        ]);
    }

}
