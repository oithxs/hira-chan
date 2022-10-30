<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hub extends UuidModel
{
    use HasFactory;
    use SerializeDate;

    /**
     * Database to be connected
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Tables to be associated
     *
     * @var string
     */
    protected $table = 'hub';

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'thread_category_id',
        'user_id',
        'name',
        'is_enabled'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'update_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the access logs for the hub.
     */
    public function access_logs()
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * Get the club threads for the hub.
     */
    public function club_threads()
    {
        return $this->hasMany(ClubThread::class);
    }

    /**
     * Get the college year threads for the hub.
     */
    public function college_year_threads()
    {
        return $this->hasMany(CollegeYearThread::class);
    }

    /**
     * Get the department threads for the hub.
     */
    public function department_threads()
    {
        return $this->hasMany(DepartmentThread::class);
    }

    /**
     * Get the job hunting threads for the hub.
     */
    public function job_hunting_threads()
    {
        return $this->hasMany(JobHuntingThread::class);
    }

    /**
     * Get the lecture threads for the hub.
     */
    public function lecture_threads()
    {
        return $this->hasMany(LectureThread::class);
    }

    /**
     * Get the thread category that owns the hub.
     */
    public function thread_category()
    {
        return $this->belongsTo(ThreadCategory::class);
    }

    /**
     * Get the user that owns the hub.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
