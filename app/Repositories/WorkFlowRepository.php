<?php

namespace App\Repositories;

use App\Models\WorkFlow;

class WorkFlowRepository
{
    public function all()
    {
        return WorkFlow::all();
    }

    public function find($id)
    {
        return WorkFlow::findOrFail($id);
    }

    public function create(array $data)
    {
        return WorkFlow::create($data);
    }

    public function update($id, array $data)
    {
        $workflow = WorkFlow::findOrFail($id);
        $workflow->update($data);
        return $workflow;
    }

    public function delete($id)
    {
        $workflow = WorkFlow::findOrFail($id);
        return $workflow->delete();
    }
}
