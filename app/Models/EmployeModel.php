<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model {
    protected $table      = "employes";
    protected $primaryKey = "id";

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields  = true;


    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'departement_id',
        'date_embauche',
        'actif'
    ];

    protected $validationRules = [
        'nom'            => "required|regex_match[/^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,255}$/]|max_length[255]",
        'prenom'         => "required|regex_match[/^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,255}$/]|max_length[255]",
        'email'          => 'required|valid_email|is_unique[employes.email,id,{id}]',
        'password'       => 'required|min_length[6]',
        'departement_id' => 'required|numeric',
        'date_embauche'  => 'required|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'nom' => [
            'required'    => 'Le nom est requis',
            'regex_match' => 'Le nom contient des caractères invalides',
        ],
        'prenom' => [
            'required'    => 'Le prénom est requis',
            'regex_match' => 'Le prénom contient des caractères invalides',
        ],
        'email' => [
            'required'    => 'L\'email est requis',
            'valid_email' => 'L\'email doit être valide',
            'is_unique'   => 'Cet email est déjà utilisé',
        ],
        'password' => [
            'required'   => 'Le mot de passe est requis',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}