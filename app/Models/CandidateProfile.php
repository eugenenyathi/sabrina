<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['student_id', 'profile_url', 'bio', 'catch_phrase', 'contact'];
}
