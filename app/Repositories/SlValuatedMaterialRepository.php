<?php

namespace App\Repositories;

use App\Models\SlValuatedMaterial;

class SlValuatedMaterialRepository
{
    protected $model;

    public function __construct(SlValuatedMaterial $slValuatedMaterial)
    {
        $this->model = $slValuatedMaterial;
    }

    // Add any necessary methods here, such as:
    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->model->find($id);
        if ($item) {
            return $item->update($data);
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
