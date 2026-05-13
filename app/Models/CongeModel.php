<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['employe_id', 'type_conge_id', 'date_debut', 'date_fin', 'nb_jours', 'motif', 'statut', 'commentaire_rh', 'created_at', 'traite_par'];

    protected $validationRules = [
        'employe_id'    => 'required|is_natural_no_zero',
        'type_conge_id' => 'required|is_natural_no_zero',
        'date_debut'    => 'required|valid_date[Y-m-d]',
        'date_fin'      => 'required|valid_date[Y-m-d]',
        'nb_jours'      => 'required|numeric|greater_than[0]',
        'motif'         => 'permit_empty|max_length[255]',
        'statut'        => 'required|in_list[en_attente,accepte,refuse]',
        'traite_par'    => 'permit_empty|is_natural',
    ];

    protected $validationMessages = [
        'employe_id' => [
            'required' => 'L\'identifiant de l\'employé est requis.',
            'is_natural_no_zero' => 'L\'identifiant de l\'employé doit être un entier positif.'
        ],
        'type_conge_id' => [
            'required' => 'Le type de congé est requis.',
            'is_natural_no_zero' => 'Le type de congé doit être un identifiant valide.'
        ],
        'date_debut' => [
            'required' => 'La date de début est requise.',
            'valid_date' => 'La date de début n\'est pas au format attendu (YYYY-MM-DD).'
        ],
        'date_fin' => [
            'required' => 'La date de fin est requise.',
            'valid_date' => 'La date de fin n\'est pas au format attendu (YYYY-MM-DD).'
        ],
        'nb_jours' => [
            'required' => 'Le nombre de jours est requis.',
            'numeric' => 'Le nombre de jours doit être un nombre.',
            'greater_than' => 'Le nombre de jours doit être supérieur à 0.'
        ],
        'motif' => [
            'max_length' => 'Le motif ne peut pas dépasser 255 caractères.'
        ],
        'statut' => [
            'required' => 'Le statut est requis.',
            'in_list' => 'Le statut doit être l\'un des suivants : en_attente, accepte, refuse.'
        ],
        'traite_par' => [
            'is_natural' => 'Le champ traite_par doit être un entier positif.'
        ],
    ];

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
        $result = $this->insert($data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true, 'id' => $this->getInsertID()];
    }

    public function updateConge($id, $data)
    {
        $result = $this->update($id, $data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true];
    }

    public function deleteConge($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}
