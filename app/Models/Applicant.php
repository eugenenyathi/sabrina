<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['student_id', 'src_post_id', 'profile_url', 'approval_status'];
}
