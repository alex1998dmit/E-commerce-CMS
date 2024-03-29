<?php

namespace App;

use App\Notifications\EmailVerifyRequest;
use Mail;
use App\Mail\SendEmailNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'verification_token'
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

    // RELATHIONSHIPS

    public function wishList()
    {
        return $this->hasMany('App\WishList', 'user_id', 'id');
    }

    public function shoppingCart()
    {
        return $this->hasMany('App\ShoppingCart');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function discount()
    {
        return $this->belongsTo('App\Discount');
    }

    // NOT RELATHIONSHIPS
    // Check User Role
    /**
    * @param string|array $roles
    */

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles);
        }

        return $this->hasRole($roles);
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        return null !== $this->role()->whereIn('name', $roles)->first();
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->role()->where('name', $role)->first();
    }

    // verify email
    public function sendEmailVerificationNotification()
    {
        $this->notify(
            new EmailVerifyRequest($this->email, $this->verification_token)
        );
    }
}
