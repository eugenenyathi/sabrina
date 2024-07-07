<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCouncil extends Model
{
    use HasFactory;

    protected $table = 'student_council';
    public $timestamps = false;
    public $fillable = ['student_id', 'src_post_id', 'profile_url', 'contact'];
}
