<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerifyNotification;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Reset Password Mail Notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Send Mail Verification
    public function sendEmailVerificationNotification() {
        $this->notify(new EmailVerifyNotification());
    }

    /*
     * User Event Boot
     * Function Whene Register New User
     * Create Profile
     * User Add Role & Permissions User When Use Fake data Delete Comment
     */
    protected static function boot() {
        parent::boot();
        static::created( function ($user) {
            $user->profile()->create([
                'user_id' => $user->id,
            ]);
            // $user->attachRole('user');
            // $user->attachPermissions(['read_profile', 'update_profile', 'read_setting']);
        });
    }

    public function socialLogin()
    {
        return $this->hasMany(SocialiteLogin::class);
    }

    public function role() {
        return $this->hasOne(Role::class, 'id');
    }

    public function permission() {
        return $this->belongsToMany('App\Permission');
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'id');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

}
