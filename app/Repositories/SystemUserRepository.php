<?php

namespace App\Repositories;

use App\Models\User;

class SystemUserRepository
{
    public function getAll() // ✅ Add this method to match the controller
    {
        return User::all();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}
