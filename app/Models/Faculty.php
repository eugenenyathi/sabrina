<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['faculty_id', 'faculty'];

    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
