<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\MediaLibrary\HasMedia;

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

        // Members notes
        Permission::create(['name' => 'member_notes.create']);

        // Users
        Permission::create(['name' => 'users.view']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);

        // Teams
        Permission::create(['name' => 'teams.view']);
        Permission::create(['name' => 'teams.edit']);
        Permission::create(['name' => 'teams.create']);


        // Permissions
        Permission::create(['name' => 'permissions.edit']);

        // Passwords
        Permission::create(['name' => 'user_passwords.edit']);

        // Posts
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.view']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);
        Permission::create(['name' => 'posts.approve']);

        // Teachers
        Permission::create(['name' => 'teachers.create']);
        Permission::create(['name' => 'teachers.view']);
        Permission::create(['name' => 'teachers.edit']);
        Permission::create(['name' => 'teachers.delete']);
        Permission::create(['name' => 'teachers.approve']);

        // Organizers
        Permission::create(['name' => 'organizers.create']);
        Permission::create(['name' => 'organizers.view']);
        Permission::create(['name' => 'organizers.edit']);
        Permission::create(['name' => 'organizers.delete']);
        Permission::create(['name' => 'organizers.approve']);

        // Venues
        Permission::create(['name' => 'venues.create']);
        Permission::create(['name' => 'venues.view']);
        Permission::create(['name' => 'venues.edit']);
        Permission::create(['name' => 'venues.delete']);
        Permission::create(['name' => 'venues.approve']);

        // Events
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.view']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);
        Permission::create(['name' => 'events.approve']);

        // Testimonials
        Permission::create(['name' => 'testimonials.create']);
        Permission::create(['name' => 'testimonials.view']);
        Permission::create(['name' => 'testimonials.edit']);
        Permission::create(['name' => 'testimonials.delete']);
        Permission::create(['name' => 'testimonials.approve']);

        // Insights
        Permission::create(['name' => 'insights.view']);
        Permission::create(['name' => 'insights.create']);
        Permission::create(['name' => 'insights.edit']);
        Permission::create(['name' => 'insights.delete']);

        // HasMedia
        Permission::create(['name' => 'medias.view']);

        // CREATE ROLES

        // Create Super Admin role and attach all permissions
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        // Create Admin role and attach the related permissions
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('teams.edit');

        // All the user that register has this group automatically assigned
        $role = Role::create(['name' => 'Registered']);

        // Team Roles
        $role = Role::create(['name' => 'Post editor']);
        $role->givePermissionTo([
            'posts.view',
            'posts.create',
            'posts.view',
            'posts.approve'
        ]);

        $role = Role::create(['name' => 'Event editor']);
        $role->givePermissionTo([
            'events.view',
            'events.create',
            'events.view',
            'events.approve'
        ]);

        /*$role = Role::create(['name' => 'Member']);
        $role->givePermissionTo([
            'teachers.create',
            'teachers.edit',
            'organizers.create',
            'teachers.edit',
            'venues.create',
            'venues.edit',
            'events.create',
            'events.edit',
        ]);*/


    }
}
