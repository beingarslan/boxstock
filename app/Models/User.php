<?php
namespace App\Models;
use App\Mail\PasswordResetVerificationCode;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\EmailVerificationCode;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
//        'contact',
        'email',
        'country',
        'password',
        'phone_number',
        'user_name',
        'street_name',
        'post_code',
        'street_name',
        'image',
        'city'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }


    /**
     * Send Email verification code for registered user
     */
    public function sendEmailVerificationCode()
    {
        $this->generateVerificationCode();
        Mail::to($this)->send( new EmailVerificationCode($this) );
    }



    /**
     * Return generate verification code
     *
     * @return int|mixed
     */
    public function generateVerificationCode()
    {
        $this->verification_code = mt_rand(100000, 999999);
        $this->save();

        return $this->verification_code;
    }

    public function markEmailVerified()
    {
        $this->email_verified_at = Carbon::now();
        $this->verification_code = null;
        $this->save();
    }

    public function changePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }
    public function passwordResetVerificationCode()
    {
        $this->generateVerificationCode();
        Mail::to($this)->send( new PasswordResetVerificationCode($this) );
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function isAdmin() {
//        $user = Auth::user();

        if($this->type !== 'admin' || !$this->approved) {
            return false;
        }

        return true;
    }

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["user", "admin", "manager"][$value],
        );
    }
}
