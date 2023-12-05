<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sys_profil extends MY_Controller
{
    //Initialisation des roles à -1
	var $tab_post_role	= array('-1','-1','-1','-1');
	
	public function __construct()
    {
		parent::__construct();
        $this->load->model('sys/M_sys_profil', 'profil');
		$this->load->model('sys/M_sys_role', 'role');
    }

    public function index()
    {
        $all_data = $this->profil->get_data_liste();

        $data['all_data'] = $all_data;
        $this->load->view('sys/V_sys_profil', $data);
    }
	
	public function get_menu_liste()
	{
		$args = func_get_args();
		$data['data_menu'] 	= $this->role->get_menu_liste($args[0]);
		$data['id_profil']	=  $args[0];
		$this->load->view('sys/V_sys_role', $data);
	}

	public function save_role_action()
	{
		//Repérage des liens
		$cur_id_lk = 0;
		$tab_temp_role = array();
		$id_pfl = $this->input->post('id_role_profil');

		///RAZ des sous-menus associés au profil
		$this->role->raz_sous_menu_active($id_pfl);

		//print_r($_POST['btn_role']);
		//exit;
		foreach ($_POST['btn_role'] as $btn_role)
		{
			$tab_role = explode('_', $btn_role);
			$role = $tab_role[0];
			$id_lk = $tab_role[1];

			if ($cur_id_lk != $id_lk) //Chagement de lien
			{
				if ($cur_id_lk != 0)  ///Passage Nx
				{
					$this->role->save_role_action($cur_id_lk, $id_pfl, $this->tab_post_role);
					$this->tab_post_role = array('-1', '-1', '-1', '-1');

					$this->tab_post_role = $this->curent_role($role, $this->tab_post_role);

				} else //Passage N0
				{
					$this->tab_post_role = $this->curent_role($role, $this->tab_post_role);
				}

				$cur_id_lk = $id_lk;
			} else {
				$this->tab_post_role = $this->curent_role($role, $this->tab_post_role);
			}
		}

		if ($cur_id_lk != 0)  ///On est pas au premier parcours
		{
			$d = $this->role->save_role_action($cur_id_lk, $id_pfl, $this->tab_post_role);
			$this->tab_post_role = array('-1', '-1', '-1', '-1');
		}

		echo json_encode($d, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}
	
	//Enregistrer les modifs sur les roles

	protected function curent_role($role, $tab_role)
	{
		switch ($role)
		{
			case 'read':
				$tab_role[0] = '1';
				break;

			case 'add':
				$tab_role[1] = '1';
				break;

			case 'upd':
				$tab_role[2] = '1';
				break;

			case 'del':
				$tab_role[3] = '1';
				break;
		}
		return $tab_role;
	}
		
    public function get_record()
    {
        $args = func_get_args();
        $this->profil->id_type_profil = $args[0];
        $this->profil->get_record();
        echo json_encode($this->profil, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function delete()
    {
        $args = func_get_args();
        $this->profil->id_type_profil = $args[0];
        echo json_encode($this->profil->delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function save()
    {
		$post_id_type_profil = $this->input->post('id_type_profil');
		if($post_id_type_profil != '')
		{
			   $this->profil->id_type_profil = $this->input->post('id_type_profil');
		}
		
        $this->profil->libelle_type_profil 	= $this->input->post('libelle_type_profil');
		$this->profil->etat = '1';   //$this->input->post('etat');


        echo json_encode($this->profil->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }
}
