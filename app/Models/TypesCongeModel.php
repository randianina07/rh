<?php

namespace App\Models;

use CodeIgniter\Model;

class TypesCongeModel extends Model
{
    protected $table = 'types_conge';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['libelle', 'jours_annuels', 'deductibles'];

    public function getAllTypesConge()
    {
        $builder = $this->builder();
        $builder->select('id, libelle, jours_annuels, deductibles');
        return $builder->get()->getResult();
    }

    public function getTypeCongeById($id)
    {
        $builder = $this->builder();
        $builder->select('id, libelle, jours_annuels, deductibles');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function createTypeConge($data)
    {
        $builder = $this->builder();
        return $builder->insert($data);
    }

    public function updateTypeConge($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteTypeConge($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}