<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['employe_id', 'type_conge_id', 'annee', 'jours_attribues', 'jours_pris'];

    protected $validationRules = [
        'employe_id' => 'required|is_natural_no_zero',
        'type_conge_id' => 'required|is_natural_no_zero',
        'annee' => 'required|is_natural_no_zero|exact_length[4]',
        'jours_attribues' => 'required|numeric|greater_than_equal_to[0]',
        'jours_pris' => 'required|numeric|greater_than_equal_to[0]'
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
        'annee' => [
            'required' => 'L\'année est requise.',
            'exact_length' => 'L\'année doit être au format YYYY.'
        ],
        'jours_attribues' => [
            'required' => 'Le nombre de jours attribués est requis.',
            'numeric' => 'Le nombre de jours attribués doit être un nombre.',
            'greater_than_equal_to' => 'Le nombre de jours attribués doit être supérieur ou égal à 0.'
        ],
        'jours_pris' => [
            'required' => 'Le nombre de jours pris est requis.',
            'numeric' => 'Le nombre de jours pris doit être un nombre.',
            'greater_than_equal_to' => 'Le nombre de jours pris doit être supérieur ou égal à 0.'
        ]
    ];

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
        $result = $this->insert($data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true, 'id' => $this->getInsertID()];
    }

    public function updateSolde($id, $data)
    {
        $result = $this->update($id, $data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true];
    }

    public function deleteSolde($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function getSoldeFor($employe_id, $type_conge_id, $annee)
    {
        return $this->where(['employe_id' => $employe_id, 'type_conge_id' => $type_conge_id, 'annee' => $annee])->first();
    }

    public function adjustJoursPris($id, $delta)
    {
        return $this->set('jours_pris', "jours_pris + ({$delta})", false)
                    ->where('id', $id)
                    ->update();
    }
}
