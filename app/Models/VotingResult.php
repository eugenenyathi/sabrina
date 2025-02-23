<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingResult extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = ['candidate_id', 'votes'];
}
