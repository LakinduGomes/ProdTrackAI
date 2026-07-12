<?php

namespace App\Repositories;

use App\Models\MasterSlValuated;

class MasterSlValuatedRepository
{
    protected $model;

    public function __construct(MasterSlValuated $model)
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
