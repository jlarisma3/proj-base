<?php

namespace App\Models\System\Route;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'uri',
        'method',
        'middleware'
    ];

    public $timestamps = false;
}
