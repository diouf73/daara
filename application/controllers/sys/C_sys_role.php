<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sys_role extends CI_Controller //r�les && links
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/M_sys_role', 'm_mod_name');
        $this->load->model('Global_bdd', 'gl_bdd');
        //$this->load->model('M_type_batiment', 'type_batiment');
    }

    public function index()
    {
        $all_data 			= $this->m_mod_name->get_data_liste();
        $all_type_status	= $this->m_mod_name->get_data_forform_etat();
      
        $data['all_data'] 			= $all_data;
       // $data['all_type_elts'] 		= $all_type_elts;
        $data['dat_form_statut'] = $all_type_status;
        $data['dat_form_liens'] 	= $this->gl_bdd->get_data_for_combo("sys_nav_liens", "id_lien", "libelle_text"	, " WHERE `etat`='1'");
        $data['dat_form_profils'] = $this->gl_bdd->get_data_for_combo("sys_s_profil", "id_type_profil", "libelle_type_profil", " WHERE `etat`='1'");
             

        $this->load->view('sys/v_sys_role', $data);
    }

    public function get_record()
    {
        $args = func_get_args();
        $this->m_mod_name->id_actions = $args[0];
        $this->m_mod_name->get_record();
        echo json_encode($this->m_mod_name, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function delete()
    {
        $args = func_get_args();
        $this->m_mod_name->id_actions = $args[0];
        echo json_encode($this->m_mod_name->delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function save()
    {
		 $input_post = $this->input->post('id_actions');
		 if(!empty($input_post))
		 {
				 $this->m_mod_name->id_actions 	= $this->input->post('id_actions');
		}
//print_r($this->input->post('d_ajouter'));    
//break;   
        $this->m_mod_name->id_type_profil 	= $this->input->post('id_type_profil');
        $this->m_mod_name->id_lien 			= $this->input->post('id_lien');
        $this->m_mod_name->d_consultation 	= $this->conv_checkbox($this->input->post('d_consultation'));
        $this->m_mod_name->d_ajouter 		= $this->conv_checkbox($this->input->post('d_ajouter'));
        $this->m_mod_name->d_modifier 		= $this->conv_checkbox($this->input->post('d_modifier'));
        $this->m_mod_name->d_supprimer 		= $this->conv_checkbox($this->input->post('d_supprimer'));


        echo json_encode($this->m_mod_name->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }


	public function conv_checkbox($val)
	{
		if($val=='on')
			return '1';
		else
			return '-1';
	}

}
