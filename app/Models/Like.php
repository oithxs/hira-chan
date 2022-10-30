<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
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
    protected $table = 'likes';

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'club_thread_id',
        'college_year_thread_id',
        'department_thread_id',
        'job_hunting_thread_id',
        'lecture_thread_id',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'thread_id',
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
     * Get the club thread that owns the like.
     */
    public function club_thread()
    {
        return $this->belongsTo(ClubThread::class);
    }

    /**
     * Get the college year thread that owns the like.
     */
    public function college_year_thread()
    {
        return $this->belongsTo(CollegeYearThread::class);
    }

    /**
     * Get the department thread that owns the like.
     */
    public function department_thread()
    {
        return $this->belongsTo(DepartmentThread::class);
    }

    /**
     * Get the job hunting thread that owns the like.
     */
    public function job_hunting_thread()
    {
        return $this->belongsTo(JobHuntingThread::class);
    }

    /**
     * Get the user that owns the like.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
