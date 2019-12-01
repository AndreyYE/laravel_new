<?php

namespace App\Entity;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Network\Network;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use http\Exception\InvalidArgumentException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * An Eloquent Model: 'User'
 *
 * @package App\Entity
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property bool $phone_auth
 * @property bool $phone_verified
 * @property string $phone_verify_token
 * @property Carbon $phone_verify_token_expire
 * @property string $status
 * @property string $role
 * @property string $email_verified_at
 * @mixin \Eloquent
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhoneVerifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhoneVerifyTokenExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhoneAuth($value)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN= 'admin';
    public const ROLE_MODER = 'moder';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status','email_verified_at','role', 'last_name','phone','rhone_auth','phone_verified','phone_verify_token','phone_verify_token_expire',
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
        'phone_verify_token_expire' => 'datetime',
        'phone_verified' => 'boolean',
        'phone_auth' => 'boolean'
    ];

    public static function rolesList()
    {
        return [
            self::ROLE_USER => 'user',
            self::ROLE_ADMIN => 'admin',
            self::ROLE_MODER => 'moder',
        ];
    }

    public static function register(string $name, string $email, string $password):self
    {
        return self::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => User::STATUS_WAIT,
                'role' => User::ROLE_USER
            ]
        );
    }

    public static function new(string $name, string $email, string $role):self
    {
        return self::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random()),
                'email_verified_at' => Carbon::now(),
                'status' => User::STATUS_ACTIVE,
                'role' => $role
            ]
        );
    }

    public function isWait():bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive():bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isAdmin()
    {
        return $this->role ===self::ROLE_ADMIN;
    }

    public function isModerator()
    {
        return $this->role ===self::ROLE_MODER;
    }


    public function changeRole($role)
    {
        if(!in_array($role, [self::ROLE_ADMIN, self::ROLE_USER, self::ROLE_MODER], true)){
            throw new \InvalidArgumentException('You picked the wrong role');
        }
        if($this->role !== $role){
            return $this->update([
                'role'=> $role
            ]);
        }else{
            throw new \DomainException('The role is already assigned');
        }
    }

    public function verify():void
    {
        if($this->isWait() && $this->email_verified_at === null){
             $this->update(
                [
                    'status' => User::STATUS_ACTIVE,
                    'email_verified_at' => Carbon::now()
                ]);
        }else{
            throw new \DomainException('User is already verified');
        }
    }

    public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->phone_auth = false;
        $this->saveOrFail();
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty.');
        }
        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new \DomainException('Token is already requested.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();
        return $this->phone_verify_token;
    }

    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token.');
        }
        if ($this->phone_verify_token_expire->lt($now)) {
            throw new \DomainException('Token is expired.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function enablePhoneAuth(): void
    {
        if (!empty($this->phone) && !$this->isPhoneVerified()) {
            throw new \DomainException('Phone number is empty.');
        }
        $this->phone_auth = true;
        $this->saveOrFail();
    }

    public function disablePhoneAuth(): void
    {
        $this->phone_auth = false;
        $this->saveOrFail();
    }

    public function addToFavorites($id): void
    {
        if ($this->hasInFavorites($id)) {
            throw new \DomainException('This advert is already added to favorites.');
        }
        $this->favorites()->attach($id);
    }

    public function removeFromFavorites($id): void
    {
        $this->favorites()->detach($id);
    }

    public function hasInFavorites($id): bool
    {
        return $this->favorites()->where('id', $id)->exists();
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }

    public function isPhoneAuthEnabled(): bool
    {
        return (bool)$this->phone_auth;
    }

    public function hasFilledProfile(): bool
    {
        return !empty($this->name) && !empty($this->last_name) && $this->isPhoneVerified();
    }
    public function favorites()
    {
        return $this->belongsToMany(Advert::class, 'advert_favorites','user_id','advert_id');
    }

    public function network()
    {
        return $this->hasMany(Network::class, 'user_id','id');
    }
    public function findForPassport($identifier)
    {
        return self::where('email', $identifier)->where('status', self::STATUS_ACTIVE)->first();
    }
}
