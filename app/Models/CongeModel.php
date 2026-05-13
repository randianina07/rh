<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['employe_id', 'type_conge_id', 'date_debut', 'date_fin', 'nb_jours', 'motif', 'statut', 'commentaire_rh', 'created_at', 'traite_par'];

    public function getAllConges()
    {
        $builder = $this->builder();
        $builder->select('id, employe_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, commentaire_rh, created_at, traite_par');
        return $builder->get()->getResult();
    }

    public function getCongeById($id)
    {
        $builder = $this->builder();
        $builder->select('id, employe_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, commentaire_rh, created_at, traite_par');
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function createConge($data)
    {
        $builder = $this->builder();
        return $builder->insert($data);
    }

    public function updateConge($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteConge($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}
