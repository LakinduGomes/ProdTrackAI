<?php

namespace App\Repositories;
use App\Models\AuditTrail;

class AuditTrailRepository
{
    public function create(array $data)
    {
        return AuditTrail::create($data);
    }

    public function getAll()
    {
        return AuditTrail::latest()->get();
    }
}
