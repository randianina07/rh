<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\DepartementModel;
use CodeIgniter\HTTP\IncomingRequest;

class RhController extends BaseController
{
    public function index()
    {
        $congeModel = new CongeModel();
        $departementModel = new DepartementModel();

        $data = [
            'en_attente' => $congeModel->getDemandeEnAttente(),
            'nb_en_attente' => $congeModel->countCongesByStatut('en_attente'),
            'nb_accepte' => $congeModel->countCongesByStatut('accepte'),
            'nb_refuse' => $congeModel->countCongesByStatut('refuse'),
            'nb_absents' => $congeModel->countEmployesAbsents(),
            'departements' => $departementModel->getAllDepartements(),
        ];
        return view('rh/index', $data);
    }

    public function listeConges()
    {
        $request = service('request');
        $departement = $request->getGet('departement');
        $statut = $request->getGet('statut');

        $congeModel = new CongeModel();
        $departementModel = new DepartementModel();

        $data = [
            'conges' => $congeModel->getCongesFiltered($departement, $statut),
            'departements' => $departementModel->getAllDepartements(),
            'selected_departement' => $departement,
            'selected_statut' => $statut,
        ];

        return view('rh/liste_conges', $data);
    }

    public function filtrerStatut($statut)
    {
        return redirect()->to(site_url('rh/conges') . '?statut=' . urlencode($statut));
    }

    public function filtrerDepartement($id)
    {
        return redirect()->to(site_url('rh/conges') . '?departement=' . urlencode($id));
    }

    public function detailConge($id)
    {
        $model = new CongeModel();
        $data = ['conge' => $model->getCongeById($id)];
        return view('rh/detail_conge', $data);
    }

    public function approuver($id)
    {
        $rh_id = session()->get('user_id') ?? null;
        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            session()->setFlashdata('message', 'Le commentaire est requis pour approuver une demande.');
            return redirect()->back();
        }

        $model = new CongeModel();
        $res = $model->accepterConge($id, $rh_id, $commentaire);
        if (is_array($res) && isset($res['success']) && $res['success'] === true) {
            session()->setFlashdata('message', 'Demande approuvée.');
        } else {
            $err = is_array($res) && isset($res['error']) ? $res['error'] : 'Erreur lors de l\'approbation.';
            session()->setFlashdata('message', $err);
        }
        return redirect()->to(site_url('rh/conges'));
    }

    public function refuser($id)
    {
        $rh_id = session()->get('user_id') ?? null;
        $commentaire = $this->request->getPost('commentaire') ?? '';
        $model = new CongeModel();
        $res = $model->refuserConge($id, $rh_id, $commentaire);
        if ($res) {
            session()->setFlashdata('message', 'Demande refusée.');
        } else {
            session()->setFlashdata('message', 'Erreur lors du refus.');
        }
        return redirect()->to(site_url('rh/conges'));
    }
}