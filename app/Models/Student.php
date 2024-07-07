<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'national_id', 'dob', 'fullName', 'gender'];
    public $timestamps = false;

    //TODO: change the target id of the relationship
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
