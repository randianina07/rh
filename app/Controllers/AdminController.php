<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;
use App\Models\CongeModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    protected EmployeModel    $employeModel;
    protected DepartementModel $departementModel;
    protected TypeCongeModel  $typeCongeModel;
    protected SoldeModel      $soldeModel;
    protected CongeModel      $congeModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request,
                                   \CodeIgniter\HTTP\ResponseInterface $response,
                                   \Psr\Log\LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->employeModel     = new EmployeModel();
        $this->departementModel = new DepartementModel();
        $this->typeCongeModel   = new TypeCongeModel();
        $this->soldeModel       = new SoldeModel();
        $this->congeModel       = new CongeModel();
    }

    public function index(): string
    {
        $data = [
            'title'      => 'Tableau de bord',
            'stats'      => $this->congeModel->getStats(),
            'absences'   => $this->congeModel->getAbsencesMoisEnCours(),
            'nb_employes'=> count($this->employeModel->where('actif', 1)->findAll()),
            'nb_departs' => count($this->departementModel->findAll()),
        ];
        return view('admin/dashboard', $data);
    }

    public function employes(): string
    {
        $data = [
            'title'    => 'Gestion des employés',
            'employes' => $this->employeModel->getAllWithDepartement(),
        ];
        return view('admin/employes/index', $data);
    }

    public function newEmploye(): string
    {
        $data = [
            'title'        => 'Nouvel employé',
            'departements' => $this->departementModel->findAll(),
            'validation'   => \Config\Services::validation(),
        ];
        return view('admin/employes/form', $data);
    }

    public function createEmploye(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'nom'            => 'required|min_length[2]|max_length[100]',
            'prenom'         => 'required|min_length[2]|max_length[100]',
            'email'          => 'required|valid_email|is_unique[employes.email]',
            'password'       => 'required|min_length[8]',
            'role'           => 'required|in_list[employe,rh,admin]',
            'departement_id' => 'required|is_not_unique[departements.id]',
            'date_embauche'  => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->employeModel->insert([
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => 1,
        ]);

        return redirect()->to('/admin/employes')->with('success', 'Employé créé avec succès.');
    }

    public function editEmploye(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $employe = $this->employeModel->find($id);
        if (! $employe) {
            return redirect()->to('/admin/employes')->with('error', 'Employé introuvable.');
        }

        $data = [
            'title'        => 'Modifier l\'employé',
            'employe'      => $employe,
            'departements' => $this->departementModel->findAll(),
            'validation'   => \Config\Services::validation(),
        ];
        return view('admin/employes/form', $data);
    }

    public function updateEmploye(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $employe = $this->employeModel->find($id);
        if (! $employe) {
            return redirect()->to('/admin/employes')->with('error', 'Employé introuvable.');
        }

        $rules = [
            'nom'            => 'required|min_length[2]|max_length[100]',
            'prenom'         => 'required|min_length[2]|max_length[100]',
            'email'          => "required|valid_email|is_unique[employes.email,id,{$id}]",
            'role'           => 'required|in_list[employe,rh,admin]',
            'departement_id' => 'required|is_not_unique[departements.id]',
            'date_embauche'  => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => $this->request->getPost('actif') ? 1 : 0,
        ];

        $newPassword = $this->request->getPost('password');
        if ($newPassword && strlen($newPassword) >= 8) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->employeModel->update($id, $updateData);

        return redirect()->to('/admin/employes')->with('success', 'Employé mis à jour avec succès.');
    }

    public function deleteEmploye(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $employe = $this->employeModel->find($id);
        if (! $employe) {
            return redirect()->to('/admin/employes')->with('error', 'Employé introuvable.');
        }

        $this->employeModel->update($id, ['actif' => 0]);

        return redirect()->to('/admin/employes')->with('success', 'Employé désactivé avec succès.');
    }

    public function departements(): string
    {
        $data = [
            'title'        => 'Gestion des départements',
            'departements' => $this->departementModel->getAllWithCount(),
            'validation'   => \Config\Services::validation(),
        ];
        return view('admin/departements/index', $data);
    }

    public function createDepartement(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'nom'         => 'required|min_length[2]|max_length[100]|is_unique[departements.nom]',
            'description' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->departementModel->insert([
            'nom'         => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département créé avec succès.');
    }

    public function deleteDepartement(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $dep = $this->departementModel->find($id);
        if (! $dep) {
            return redirect()->to('/admin/departements')->with('error', 'Département introuvable.');
        }

        $nb = $this->employeModel->where('departement_id', $id)->where('actif', 1)->countAllResults();
        if ($nb > 0) {
            return redirect()->to('/admin/departements')
                             ->with('error', "Impossible de supprimer : {$nb} employé(s) rattaché(s).");
        }

        $this->departementModel->delete($id);

        return redirect()->to('/admin/departements')->with('success', 'Département supprimé.');
    }

    public function typesConge(): string
    {
        $data = [
            'title'       => 'Types de congé',
            'types'       => $this->typeCongeModel->findAll(),
            'validation'  => \Config\Services::validation(),
        ];
        return view('admin/types_conge/index', $data);
    }

    public function createTypeConge(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'libelle'       => 'required|min_length[2]|max_length[100]|is_unique[types_conge.libelle]',
            'jours_annuels' => 'required|integer|greater_than[0]',
            'deductible'    => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->typeCongeModel->insert([
            'libelle'       => $this->request->getPost('libelle'),
            'jours_annuels' => $this->request->getPost('jours_annuels'),
            'deductible'    => $this->request->getPost('deductible'),
        ]);

        return redirect()->to('/admin/types-conge')->with('success', 'Type de congé créé.');
    }

    public function deleteTypeConge(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $type = $this->typeCongeModel->find($id);
        if (! $type) {
            return redirect()->to('/admin/types-conge')->with('error', 'Type introuvable.');
        }

        // Vérifier si des congés existent pour ce type
        $nb = (new CongeModel())->where('type_conge_id', $id)->countAllResults();
        if ($nb > 0) {
            return redirect()->to('/admin/types-conge')
                             ->with('error', "Impossible : {$nb} demande(s) liée(s) à ce type.");
        }

        $this->typeCongeModel->delete($id);

        return redirect()->to('/admin/types-conge')->with('success', 'Type de congé supprimé.');
    }


    public function soldes(): string
    {
        $annee = (int)($this->request->getGet('annee') ?? date('Y'));

        $data = [
            'title'  => 'Gestion des soldes',
            'soldes' => $this->soldeModel->getAllDetailed($annee),
            'annee'  => $annee,
            'employes' => $this->employeModel->where('actif', 1)->findAll(),
            'types'    => $this->typeCongeModel->findAll(),
        ];
        return view('admin/soldes/index', $data);
    }

    public function initialiserSoldes(): \CodeIgniter\HTTP\RedirectResponse
    {
        $annee = (int)($this->request->getPost('annee') ?? date('Y'));

        if ($annee < 2000 || $annee > 2100) {
            return redirect()->to('/admin/soldes')->with('error', 'Année invalide.');
        }

        $nb = $this->soldeModel->initialiserPourTous($annee);

        return redirect()->to("/admin/soldes?annee={$annee}")
                         ->with('success', "{$nb} solde(s) initialisé(s) pour {$annee}.");
    }

    public function updateSolde(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $solde = $this->soldeModel->find($id);
        if (! $solde) {
            return redirect()->to('/admin/soldes')->with('error', 'Solde introuvable.');
        }

        $rules = [
            'jours_attribues' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->soldeModel->update($id, [
            'jours_attribues' => $this->request->getPost('jours_attribues'),
        ]);

        $annee = $solde['annee'];
        return redirect()->to("/admin/soldes?annee={$annee}")
                         ->with('success', 'Solde mis à jour.');
    }

    public function historique(): string
    {
        $statut       = $this->request->getGet('statut')        ?? null;
        $departementId = $this->request->getGet('departement_id') ? (int)$this->request->getGet('departement_id') : null;

        $data = [
            'title'        => 'Historique des demandes',
            'conges'       => $this->congeModel->getAllDetailed($statut, $departementId),
            'departements' => $this->departementModel->findAll(),
            'statut'       => $statut,
            'departement_id' => $departementId,
        ];
        return view('admin/historique/index', $data);
    }
}