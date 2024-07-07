<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalStatus extends Model
{
    use HasFactory;

    protected $table = 'portal_status';
    public $timestamps = false;
    public $fillable = ['status', 'active', 'opening_date', 'closing_date'];
}
