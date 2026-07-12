<?php

namespace App\Repositories;

use App\Models\FGTradingMass;

class MassTemplateRepository
{
    /**
     * Get all mass templates.
     */
    public function getAll()
    {
        return FGTradingMass::all();
    }

    /**
     * Create a new mass template.
     */
    public function create(array $data)
    {
        return FGTradingMass::create($data);
    }

    /**
     * Bulk insert multiple mass templates.
     */
    public function createMany(array $data)
    {
        return FGTradingMass::insert($data); // Fast bulk insert
    }

    /**
     * Find a mass template by ID.
     */
    public function find(int $id)
    {
        return FGTradingMass::findOrFail($id);
    }

    /**
     * Update a mass template.
     */
    public function update(int $id, array $data)
    {
        return FGTradingMass::where('id', $id)->update($data);
    }

    /**
     * Delete a mass template.
     */
    public function delete(int $id)
    {
        return FGTradingMass::destroy($id);
    }

    /**
     * Bulk delete multiple mass templates.
     */
    public function deleteMany(array $ids)
    {
        return FGTradingMass::whereIn('id', $ids)->delete();
    }
}
