<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    use SerializeDate;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'char';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_page_theme_id',
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
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'update_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['id'] = Str::uuid();
    }

    // Add custom mail
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailAddURL);
    }

    /**
     * Get the user page theme that owns the user.
     */
    public function user_page_theme()
    {
        return $this->belongsTo(UserPageTheme::class);
    }

    /**
     * Get the access logs for the user.
     */
    public function access_logs()
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * Get the club threads for the user.
     */
    public function club_threads()
    {
        return $this->hasMany(ClubThread::class);
    }

    /**
     * Get the college year threads for the user.
     */
    public function college_year_threads()
    {
        return $this->hasMany(CollegeYearThread::class);
    }

    /**
     * Get the contact administrators for the user.
     */
    public function contact_administrators()
    {
        return $this->hasMany(ContactAdministrator::class);
    }

    /**
     * Get the department threads for the user.
     */
    public function department_threads()
    {
        return $this->hasMany(DepartmentThread::class);
    }

    /**
     * Get the hub for the user.
     */
    public function hub()
    {
        return $this->hasMany(Hub::class);
    }

    /**
     * Get the job hunting threads for the user.
     */
    public function job_hunting_threads()
    {
        return $this->hasMany(JobHuntingThread::class);
    }

    /**
     * Get the lecture threads for the user.
     */
    public function lecture_threads()
    {
        return $this->hasMany(LectureThread::class);
    }

    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
