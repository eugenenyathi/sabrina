<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteCount extends Model
{
    use HasFactory;

    protected $table = 'votes_count';
    public $timestamps = false;
    public $fillable = ['candidate_id', 'votes'];
}
