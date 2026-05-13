<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'departements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['nom', 'description'];

    public function getAllDepartements()
    {
        $builder = $this->builder();
        $builder->select('nom, description');
        return $builder->get()->getResult();
    }

    public function getDepartementById($id)
    {
        $builder = $this->builder();
        $builder->select('nom, description');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function createDepartement($data)
    {
        $builder = $this->builder();
        return $builder->insert($data);
    }

    public function updateDepartement($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteDepartement($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}