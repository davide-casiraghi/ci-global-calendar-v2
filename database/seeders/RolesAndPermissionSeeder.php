<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CREATE PERMISSIONS

        // User notes
        Permission::create(['name' => 'user_notes.create']);

        // Users
        Permission::create(['name' => 'users.view']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.approve']);


        // User export
        Permission::create(['name' => 'user_export.view']);

        // Database backups
        Permission::create(['name' => 'database_backup.view']);

        // Teams
        Permission::create(['name' => 'teams.view']);
        Permission::create(['name' => 'teams.edit']);
        Permission::create(['name' => 'teams.create']);
        Permission::create(['name' => 'teams.delete']);

        // Permissions
        Permission::create(['name' => 'permissions.edit']);

        // Passwords
        Permission::create(['name' => 'user_passwords.edit']);

        // Posts
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.view']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);

        // Post categories
        Permission::create(['name' => 'post_categories.create']);
        Permission::create(['name' => 'post_categories.view']);
        Permission::create(['name' => 'post_categories.edit']);
        Permission::create(['name' => 'post_categories.delete']);

        // Teachers
        Permission::create(['name' => 'teachers.create']);
        Permission::create(['name' => 'teachers.view']);
        Permission::create(['name' => 'teachers.edit']);
        Permission::create(['name' => 'teachers.delete']);

        // Organizers
        Permission::create(['name' => 'organizers.create']);
        Permission::create(['name' => 'organizers.view']);
        Permission::create(['name' => 'organizers.edit']);
        Permission::create(['name' => 'organizers.delete']);

        // Venues
        Permission::create(['name' => 'venues.create']);
        Permission::create(['name' => 'venues.view']);
        Permission::create(['name' => 'venues.edit']);
        Permission::create(['name' => 'venues.delete']);

        // Events
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.view']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);

        // Event categories
        Permission::create(['name' => 'event_categories.create']);
        Permission::create(['name' => 'event_categories.view']);
        Permission::create(['name' => 'event_categories.edit']);
        Permission::create(['name' => 'event_categories.delete']);

        // Background Images
        Permission::create(['name' => 'background_images.view']);
        Permission::create(['name' => 'background_images.create']);
        Permission::create(['name' => 'background_images.edit']);
        Permission::create(['name' => 'background_images.delete']);

        // Donation Offers
        Permission::create(['name' => 'donation_offer.view']);
        Permission::create(['name' => 'donation_offer.create']);
        Permission::create(['name' => 'donation_offer.edit']);
        Permission::create(['name' => 'donation_offer.delete']);

        // Homepage Messages
        Permission::create(['name' => 'homepage_message.view']);
        Permission::create(['name' => 'homepage_message.create']);
        Permission::create(['name' => 'homepage_message.edit']);
        Permission::create(['name' => 'homepage_message.delete']);

        // HasMedia
        Permission::create(['name' => 'medias.view']);

        // CREATE ROLES


        // Create Super Admin role and attach all permissions
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        // Create Admin role and attach the related permissions
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo([
            'teachers.view',
            'teachers.create',
            'teachers.edit',
            'teachers.delete',
            'organizers.view',
            'organizers.create',
            'organizers.edit',
            'organizers.delete',
            'venues.view',
            'venues.create',
            'venues.edit',
            'venues.delete',
            'events.view',
            'events.create',
            'events.edit',
            'events.delete',
            'posts.view',
            'posts.create',
            'posts.edit',
            'background_images.view',
            'background_images.create',
            'background_images.edit',
            'background_images.delete',
            'donation_offer.view',
            'donation_offer.create',
            'donation_offer.edit',
            'donation_offer.delete',
        ]);

        $role = Role::create(['name' => 'Member']);

        // Team Roles
        $role = Role::create(['name' => 'Post editor']);
        $role->givePermissionTo([
            'posts.view',
            'posts.create',
            'posts.edit',
        ]);

        // All the user that register has this group automatically assigned
        $role = Role::create(['name' => 'Registered']);
        $role->givePermissionTo([
            'teachers.view',
            'teachers.create',
            'organizers.view',
            'organizers.create',
            'venues.view',
            'venues.create',
            'events.view',
            'events.create',
        ]);

    }
}
