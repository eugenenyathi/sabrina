<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'program_id', 'part', 'student_type', 'enrolled'];
    public $timestamps = false;

    //TODO: Adjust the keys
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function program()
    {
        return $this->hasOne(Program::class);
    }
}
