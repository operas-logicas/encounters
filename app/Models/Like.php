<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [ 'sighting_id', 'user_id' ];

    public function sighting()
    {
        $this->belongsTo(Sighting::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
