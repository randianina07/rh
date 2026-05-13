<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['employe_id', 'type_conge_id', 'annee', 'jours_attribues', 'jours_pris'];

    public function getAllSoldes()
    {
        $builder = $this->builder();
        $builder->select('id, employe_id, type_conge_id, annee, jours_attribues, jours_pris');
        return $builder->get()->getResult();
    }

    public function getSoldeById($id)
    {
        $builder = $this->builder();
        $builder->select('id, employe_id, type_conge_id, annee, jours_attribues, jours_pris');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function createSolde($data)
    {
        $builder = $this->builder();
        return $builder->insert($data);
    }

    public function updateSolde($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteSolde($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}
