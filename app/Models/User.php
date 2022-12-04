<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;
    use SerializeDate;

    /**
     * モデルの主キー
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * オートインクリメントのIDのタイプを指定する．
     *
     * @var string
     */
    protected $keyType = 'char';

    /**
     * IDがオートインクリメントであるかどうかを示す．
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * マスアサインメント可能な属性
     *
     * ここに登録している属性にはデータの挿入・更新が出来る．
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent.html
     *
     * @var string[]
     */
    protected $fillable = [
        'user_page_theme_id',
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * シリアライズのために隠すべき属性
     *
     * ここに登録した属性は，管理画面で見ることが出来ない．
     * そのほかの効果は不明．
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-serialization.html
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
     * キャストすべき属性
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-serialization.html
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
     * モデルの配列フォームに追加するアクセサ．
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-serialization.html
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

    /**
     * filament の認証．
     *
     * config('filament.auth.email.verified') の値によってメールの認証の必要性を変更する．
     *
     * @link https://filamentphp.com/docs/2.x/admin/users#authorizing-access-to-the-admin-panel
     *
     * @return boolean
     */
    public function canAccessFilament(): bool
    {
        // メールの検証とドメインの一致が必要
        if (config('filament.auth.email.verified')) {
            return str_ends_with($this->email, config('filament.auth.email.domain')) && $this->hasVerifiedEmail();
        }

        // ドメインのみ一致
        return str_ends_with($this->email, config('filament.auth.email.domain'));
    }

    /**
     * Email確認の際に送信するメールカスタマイズ．
     *
     * @link https://readouble.com/laravel/9.x/ja/verification.html
     * @see \App\Notifications\VerifyEmailNotification
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }

    /**
     * user に関連する access log を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function access_logs()
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * user に関連する club thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function club_threads()
    {
        return $this->hasMany(ClubThread::class);
    }

    /**
     * user に関連する college year thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function college_year_threads()
    {
        return $this->hasMany(CollegeYearThread::class);
    }

    /**
     * user に関連する contact administrator を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function contact_administrators()
    {
        return $this->hasMany(ContactAdministrator::class);
    }

    /**
     * user に関連する department thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function department_threads()
    {
        return $this->hasMany(DepartmentThread::class);
    }

    /**
     * user に関連する hub を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function hub()
    {
        return $this->hasMany(Hub::class);
    }

    /**
     * user に関連する job hunting thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function job_hunting_threads()
    {
        return $this->hasMany(JobHuntingThread::class);
    }

    /**
     * user に関連する lecture thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function lecture_threads()
    {
        return $this->hasMany(LectureThread::class);
    }

    /**
     * user に関連する like を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * user を所有する user page theme を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function user_page_theme()
    {
        return $this->belongsTo(UserPageTheme::class);
    }
}
