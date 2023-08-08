<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "uid";
    protected $fillable = ["sender_name", "email", "body", "is_archived"];
    protected $casts = [
        'is_archived' => 'boolean'
    ];
}
