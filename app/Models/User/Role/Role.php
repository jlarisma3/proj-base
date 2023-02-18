<?php

namespace App\Models\User\Role;

use App\Models\System\Auth\RoleEndpoint;
use App\Models\System\Route\Endpoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function endpoints()
    {
        return $this->belongsToMany(
            Endpoint::class,
            RoleEndpoint::class
        );
    }
}
