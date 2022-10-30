<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
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
    protected $table = 'admin_menu';

    /**
     * The attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'order',
        'icon',
        'uri',
        'permission',
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
}
