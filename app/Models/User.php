<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements \Laravel\Cashier\Order\Contracts\ProvidesInvoiceInformation
{
    use \Laravel\Cashier\Billable;

    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
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
     * The attributes that should be cast.
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

    public function mollieCustomerFields() {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }

    /**
    * Get the receiver information for the invoice.
    * Typically includes the name and some sort of (E-mail/physical) address.
    *
    * @return array An array of strings
    */
    public function getInvoiceInformation()
    {
        return [$this->name, $this->email];
    }

    /**
    * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
    *
    * @return string|null
    */
    public function getExtraBillingInformation()
    {
        return null;
    }
}
