<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'album';
    protected $fillable = [
        'name',
        'artist_id',
        'publication_date',
        'numberOfSongs',
        'urlPicture',
    ];
}
