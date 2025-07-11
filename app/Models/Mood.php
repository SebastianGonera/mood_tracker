<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    /** @use HasFactory<\Database\Factories\MoodFactory> */
    use HasFactory;

    protected $table = "moods";
    protected $fillable = [
        'user_id',
        "emoji",
        "note",
        "rating"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
