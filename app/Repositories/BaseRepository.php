<?php

namespace App\Repositories;

use App\Interfaces\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function update(int $id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }
}
