<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model {
    protected $connection = 'mysql_keiziban';
    protected $fillable = ['thread_id', 'message_id', 'user_id'];
}
