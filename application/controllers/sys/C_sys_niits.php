<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sys_niits extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/M_sys_niits', 'user');
        $this->load->model('sys/M_sys_profil', 'profil');

    }

    public function index()
    {
        $user_data = $this->user->get_data();
        $data['all_data'] = $user_data;

        $profil = $this->profil->get_data();
        $data['select_profile'] = create_select_list($profil, 'id_type_profil', 'libelle_type_profil');

        $this->load->view('sys/V_sys_niits', $data);
    }

    public function save()
    {
        if ($this->input->post('id') != '')
            $this->user->id = $this->input->post('id');

        $this->user->ien = $this->input->post('ien');
        $this->user->email = $this->input->post('email');
        $this->user->id_profil = $this->input->post('id_profil');
        $this->user->code_str = $this->input->post('code_str');
        $this->user->password = $this->input->post('password');
        $this->user->statut = $this->input->post('statut');

        echo json_encode($this->user->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function get_record()
    {
       $args = func_get_args();
       $this->user->id = $args[0];
       $this->user->get_record();
       echo json_encode($this->user, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }


    public function delete()
    {
        $args = func_get_args();
        $this->user->id = $args[0];

        echo json_encode($this->user->delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

}
