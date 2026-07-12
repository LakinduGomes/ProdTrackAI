<?php

namespace App\Repositories;

use App\Models\SFG;

class SFGRepository
{
    public function getAll()
    {
        return SFG::all();
    }

    public function getById($id)
    {
        return SFG::findOrFail($id);
    }

    public function create(array $data)
    {
        return SFG::create($data);
    }

    public function update($id, array $data)
    {
        $sfg = SFG::findOrFail($id);
        $sfg->update($data);
        return $sfg;
    }

    public function delete($id)
    {
        return SFG::destroy($id);
    }
}
