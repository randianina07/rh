<?php

namespace App\Models;

use CodeIgniter\Model;

class TypesCongeModel extends Model
{
    protected $table = 'types_conge';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['libelle', 'jours_annuels', 'deductibles'];

    protected $validationRules = [
        'libelle' => 'required|min_length[2]|max_length[100]',
        'jours_annuels' => 'required|numeric|greater_than_equal_to[0]',
        'deductibles' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'libelle' => [
            'required' => 'Le libellé est requis.',
            'min_length' => 'Le libellé doit contenir au moins 2 caractères.',
            'max_length' => 'Le libellé ne peut pas dépasser 100 caractères.'
        ],
        'jours_annuels' => [
            'required' => 'Le nombre de jours annuels est requis.',
            'numeric' => 'Le nombre de jours annuels doit être un nombre.',
            'greater_than_equal_to' => 'Le nombre de jours annuels doit être supérieur ou égal à 0.'
        ],
        'deductibles' => [
            'required' => 'Le champ deductibles est requis.',
            'in_list' => 'Le champ deductibles doit être 0 ou 1.'
        ]
    ];

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
        $result = $this->insert($data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true, 'id' => $this->getInsertID()];
    }

    public function updateTypeConge($id, $data)
    {
        $result = $this->update($id, $data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true];
    }

    public function deleteTypeConge($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}