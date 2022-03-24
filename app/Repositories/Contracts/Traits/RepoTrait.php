<?php

namespace App\Repositories\Contracts\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait RepoTrait
{
    /**
     * @var
     */
    private $model;

    /**
     * @param $model
     *
     * @return mixed|void
     */
    public function set($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param \Illuminate\Support\Facades\Request $request
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request, $callback = null)
    {
        $m = $this->save($request);

        if(is_null($callback))
            return $m;

        return $callback($m);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    private function save(Request $request)
    {
        foreach ($request->all() as $attr => $value) {
            if(! Schema::connection(
                $this->model
                    ->getConnection()
                    ->getName()
            )->hasColumn($this->model->getTable(), $attr))
                continue;

            if(is_null($value))
                continue;

            $this->model->{$attr} = $value;
        }

        $this->model->save();

        return $this->model;
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        return $this->model->delete();
    }
}