<?php

namespace App\Models;

use App\Models\UserProfile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasStatuses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'name',
        'surname',
        'email',
        'countryId',
        'userLevel',
        'team',
        'status'
    ];

    /**
     * The possible values the status can be.
     */
    public const STATUS = [
        'pending' => 'pending',
        'disabled' => 'disabled',
        'enabled' => 'enabled',
    ];

    /**
     * Returns the posts written by this user.
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Returns the user profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Return true if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Return true if the user is a super administrator.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(['Super Admin']);
    }

    /**
     * Returns the events crated by this user.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Returns the events crated by this user.
     */
    public function organizers()
    {
        return $this->hasMany(Organizer::class);
    }

    /**
     * Returns the events crated by this user.
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Return true if the user is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->latestStatus('disabled', 'enabled') == 'enabled';
    }

    /**
     * Return the user level (Super Admin or Admin).
     *
     * @return string
     */
    public function getLevelAttribute(): string
    {
        if ($this->hasRole(['Super Admin'])) {
            return 'Super Admin';
        }
        if ($this->hasRole(['Admin'])) {
            return 'Admin';
        }

        return '';
    }

    /**
     * Get the admin teams.
     * $user->teams
     *
     * @return Collection
     */
    public function getTeamsAttribute(): Collection
    {
        return $this->roles
            ->whereNotIn('name', ['Super Admin', 'Admin', 'Registered'])
            ->pluck('name');
    }

}
