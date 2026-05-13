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
        $builder->select('conges.*, employes.nom, employes.prenom, employes.departement_id, types_conge.libelle');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->join('types_conge', 'types_conge.id = conges.type_conge_id');
        $builder->where('conges.id', $id);
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

    public function getDemandeEnAttente()
    {
        $builder = $this->builder();
        $builder->select('conges.*, employes.nom, employes.prenom, types_conge.libelle');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->join('types_conge', 'types_conge.id = conges.type_conge_id');
        $builder->where('conges.statut', 'en_attente');
        $builder->orderBy('conges.created_at', 'DESC');
        return $builder->get()->getResult();
    }

    public function countCongesByStatut($statut = 'en_attente')
    {
        $builder = $this->builder();
        $builder->where('statut', $statut);
        return $builder->countAllResults();
    }

    public function getEmployesAbsents()
    {
        $builder = $this->builder();
        $builder->select('employes.nom, employes.prenom, conges.date_debut, conges.date_fin');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->where('conges.statut', 'accepte');
        $builder->where('date_debut <= CURDATE()', null, false);
        $builder->where('date_fin >= CURDATE()', null, false);
        return $builder->get()->getResult();
    }

    public function countEmployesAbsents()
    {
        $builder = $this->builder();
        $builder->where('statut', 'accepte');
        $builder->where('date_debut <= CURDATE()', null, false);
        $builder->where('date_fin >= CURDATE()', null, false);
        return $builder->countAllResults();
    }

    public function getCongeParStatut($statut = null)
    {
        $builder = $this->builder();
        $builder->select('conges.*, employes.nom, employes.prenom, types_conge.libelle');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->join('types_conge', 'types_conge.id = conges.type_conge_id');

        if (!empty($statut)) {
            $builder->where('conges.statut', $statut);
        }

        $builder->orderBy('conges.created_at', 'DESC');
        return $builder->get()->getResult();
    }

    public function getCongeParDepartement($departement_id)
    {
        $builder = $this->builder();
        $builder->select('conges.*, employes.nom, employes.prenom, types_conge.libelle');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->join('types_conge', 'types_conge.id = conges.type_conge_id');
        $builder->where('employes.departement_id', $departement_id);
        $builder->orderBy('conges.created_at', 'DESC');
        return $builder->get()->getResult();
    }

    public function getCongesFiltered($departement_id = null, $statut = null)
    {
        $builder = $this->builder();
        $builder->select('conges.*, employes.nom, employes.prenom, types_conge.libelle, employes.departement_id');
        $builder->join('employes', 'employes.id = conges.employe_id');
        $builder->join('types_conge', 'types_conge.id = conges.type_conge_id');

        if (!empty($departement_id)) {
            $builder->where('employes.departement_id', $departement_id);
        }

        if (!empty($statut)) {
            $builder->where('conges.statut', $statut);
        }

        $builder->orderBy('conges.created_at', 'DESC');
        return $builder->get()->getResult();
    }

    public function accepterConge($id, $rh_id, $commentaire = '')
    {
        $conge = $this->getCongeById($id);
        if (empty($conge)) {
            return false;
        }

        $annee = date('Y', strtotime($conge->date_debut));
        $soldeModel = new \App\Models\SoldeModel();
        $solde = $soldeModel->getSoldeFor($conge->employe_id, $conge->type_conge_id, $annee);

        if (empty($solde)) {
            return false;
        }

        $restant = $solde->jours_attribues - $solde->jours_pris;
        if ($conge->nb_jours > $restant) {
            return ['success' => false, 'error' => 'Solde insuffisant'];
        }

        $db = db_connect();
        $db->transStart();

        $this->update($id, [
            'statut' => 'accepte',
            'traite_par' => $rh_id,
            'commentaire_rh' => $commentaire,
        ]);

        $soldeModel->adjustJoursPris($solde->id, $conge->nb_jours);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'error' => 'Erreur base de données lors de l\'approbation'];
        }

        return ['success' => true];
    }

    public function refuserConge($id, $rh_id, $commentaire = '')
    {
        $conge = $this->getCongeById($id);
        if (empty($conge)) {
            return false;
        }

        $wasAccepted = ($conge->statut === 'accepte');

        $db = db_connect();
        $db->transStart();

        $this->update($id, [
            'statut' => 'refuse',
            'traite_par' => $rh_id,
            'commentaire_rh' => $commentaire,
        ]);

        if ($wasAccepted) {
            $annee = date('Y', strtotime($conge->date_debut));
            $soldeModel = new \App\Models\SoldeModel();
            $solde = $soldeModel->getSoldeFor($conge->employe_id, $conge->type_conge_id, $annee);
            if (!empty($solde)) {
                $soldeModel->adjustJoursPris($solde->id, -1 * $conge->nb_jours);
            }
        }

        $db->transComplete();

        return $db->transStatus();
    }
}