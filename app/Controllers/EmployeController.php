<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class EmployeController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        
    }

    /**
     * Index redirige vers la liste des congés
     */
    public function index()
    {
        return $this->mesConges();
    }

    /**
     * Affiche la liste des congés de l'employé
     * Route: /employe/conges
     */
    public function mesConges()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('conges c');
        $builder->select('c.*, tc.libelle as type_nom'); 
        $builder->join('types_conge tc', 'tc.id = c.type_conge_id');
        $builder->where('c.employe_id', session()->get('user_id'));
        $builder->orderBy('c.created_at', 'DESC');
    
        $data['conges'] = $builder->get()->getResultArray();
        $data['title'] = "Mes demandes";
    
        return view('employe/index', $data); 
    }

   
  /**
     * Affiche le formulaire de création de congé
     */
    public function newConge()
    {
        $userId = session()->get('user_id');
        $currentYear = date('Y');
    
        // 1. Récupération des types avec calcul du solde restant pour le <select>
        $data['types'] = $this->db->table('types_conge tc')
            ->select('tc.*, (s.jours_attribues - s.jours_pris) as jours_restants')
            ->join('soldes s', 's.type_conge_id = tc.id')
            ->where('s.employe_id', $userId)
            ->where('s.annee', $currentYear)
            ->get()->getResultArray();
        
        // 2. Récupération des soldes pour le panneau latéral (Barres de progression)
        $data['soldes'] = $this->db->table('soldes s')
            ->select('s.*, tc.libelle, (s.jours_attribues - s.jours_pris) as jours_restants')
            ->join('types_conge tc', 'tc.id = s.type_conge_id')
            ->where('s.employe_id', $userId)
            ->where('s.annee', $currentYear)
            ->get()->getResultArray();
    
        $data['title'] = "Nouvelle demande";
        return view('employe/create', $data);
    }
    /**
     * Traite la soumission du formulaire
     * Route: /employe/conges/create
     */
    public function createConge()
    {
        $date_debut = $this->request->getPost('date_debut');
        $date_fin = $this->request->getPost('date_fin');

        // Calcul de la durée
        $diff = (strtotime($date_fin) - strtotime($date_debut)) / (60 * 60 * 24);
        $nb_jours = abs(round($diff)) + 1;

        $data = [
            'employe_id'     => session()->get('user_id'),
            'type_conge_id'  => $this->request->getPost('type_conge_id'),
            'date_debut'     => $date_debut,
            'date_fin'       => $date_fin,
            'nb_jours'       => $nb_jours,
            'motif'          => $this->request->getPost('motif'),
            'statut'         => 'en_attente',
            'created_at'     => date('Y-m-d H:i:s')
        ];

        $this->db->table('conges')->insert($data);
        return redirect()->to(base_url('employe/conges'))->with('success', 'Demande de congé envoyée avec succès.');
    }

    /**
     * Annule une demande (seulement si en attente)
     * Route: /employe/conges/annuler/(:num)
     */
    public function annulerConge($id)
    {
        $builder = $this->db->table('conges');
        
        $builder->where('id', $id);
        $builder->where('employe_id', session()->get('user_id'));
        $builder->where('statut', 'en_attente');

        // Au lieu de supprimer, on peut aussi passer le statut en 'annulee'
        $builder->update(['statut' => 'annulee']);
        
        return redirect()->to(base_url('employe/conges'))->with('success', 'Demande annulée.');
    }

    /**
     * Affiche le profil de l'employé
     * Route: /employe/profil
     */
    public function profil()
    {
        $data['user'] = $this->db->table('employes')
            ->where('id', session()->get('user_id'))
            ->get()->getRowArray();
            
        $data['title'] = "Mon profil";
        return view('employe/profil', $data);
    }

    /**
     * Met à jour le profil (nom, prénom, mot de passe)
     * Route: /employe/profil/update
     */
    public function updateProfil()
    {
        $data = [
            'nom'    => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->table('employes')
            ->where('id', session()->get('user_id'))
            ->update($data);

        // Mettre à jour le nom en session pour l'affichage immédiat
        session()->set('nom', trim($data['prenom'] . ' ' . $data['nom']));

        return redirect()->to(base_url('employe/profil'))->with('success', 'Profil mis à jour.');
    }
}