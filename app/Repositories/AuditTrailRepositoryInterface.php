<?php

namespace App\Repositories;

interface AuditTrailRepositoryInterface
{
    public function getAll();
    public function logAction($action, $model, $userId);
}
