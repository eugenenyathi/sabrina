<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrcPost extends Model
{
    use HasFactory;

    protected $table = 'src_posts';
    public $timestamps = false;
    public $fillable = ['src_post_id', 'post'];
}
