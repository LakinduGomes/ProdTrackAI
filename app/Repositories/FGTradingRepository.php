<?php

namespace App\Repositories;

use App\Models\FGTrading;

class FGTradingRepository
{
    protected $model;

    public function __construct(FGTrading $model)
    {
        $this->model = $model;
    }

    // Fetch all FG_Trading records
    public function all()
    {
        return $this->model->all();
    }

    // Fetch a single FG_Trading record by id
    public function find($id)
    {
        return $this->model->find($id);
    }

    // Store a new FG_Trading record
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // Update an existing FG_Trading record
    public function update($id, array $data)
    {
        $fgTrading = $this->model->find($id);
        return $fgTrading->update($data);
    }

    // Delete an FG_Trading record
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
