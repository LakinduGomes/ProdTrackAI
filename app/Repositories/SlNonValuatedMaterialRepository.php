<?php

namespace App\Repositories;

use App\Models\SlNonValuatedMaterial;

class SlNonValuatedMaterialRepository
{
    protected $model;

    public function __construct(SlNonValuatedMaterial $model)
    {
        $this->model = $model;
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

    // Create a new SL Non-Valuated Material
    public function create(array $data)
    {
        return $this->model->create([
            'material_name' => $data['material_name'],
            'material_code' => $data['material_code'],
            // Add more fields as needed
        ]);
    }

    // You can add more methods for updating, deleting, or fetching records as needed.
}
