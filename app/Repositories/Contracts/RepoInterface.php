<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface RepoInterface
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param $model
     *
     * @return mixed
     */
    public function set($model);

    /**
     * @return mixed
     */
    public function all(Request $request);

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request);

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request);

    /**
     * @return mixed
     */
    public function delete();

}