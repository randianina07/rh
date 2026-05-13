<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'departements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['nom', 'description'];

    protected $validationRules = [
        'nom' => 'required|alpha_space|min_length[2]|max_length[100]',
        'description' => 'permit_empty|max_length[500]'
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom du département est requis.',
            'alpha_space' => 'Le nom ne peut contenir que des lettres et des espaces.',
            'min_length' => 'Le nom doit contenir au moins 2 caractères.',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères.'
        ],
        'description' => [
            'max_length' => 'La description ne peut pas dépasser 500 caractères.'
        ]
    ];

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
        $result = $this->insert($data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true, 'id' => $this->getInsertID()];
    }

    public function updateDepartement($id, $data)
    {
        $result = $this->update($id, $data);
        if ($result === false) {
            return ['success' => false, 'errors' => $this->errors()];
        }

        return ['success' => true];
    }

    public function deleteDepartement($id)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->delete();
    }
}