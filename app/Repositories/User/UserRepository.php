<?php

namespace App\Repositories\User;

use App\Models\User\User as User;
use App\Repositories\Contracts\RepoInterface;
use App\Repositories\Contracts\Traits\RepoTrait;
use Illuminate\Http\Request;

/**
 * Class UserRepository
 *
 * @package App\Repositories\User
 */
class UserRepository implements RepoInterface
{
    use RepoTrait;

    public function init()
    {
        $this->set(new User);

        return $this;
    }

    public function all(Request $request) {}
}
