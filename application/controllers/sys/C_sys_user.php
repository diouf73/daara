<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sys_user extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/M_sys_user', 'user');
        $this->load->model('sys/M_sys_profil', 'profil');
        $this->load->model('M_personnel', 'pers');
        //$this->load->model('M_table_param');
    }

    public function index()
    {

        $user_data = $this->user->get_data();
        $data['all_data'] = $user_data;

        $profil = $this->profil->get_data();
        $data['select_profile'] = create_select_list($profil, 'id_type_profil', 'libelle_type_profil');

        $this->load->view('sys/V_sys_user', $data);
    }

    public function save()
    {
        $ien = trim($this->input->post('ien'));
        if (!empty($this->user->verif_ienusr($ien)))
        {
            $d=array("status" => "error", "message" =>"Ien deja utilisateur" );

            echo json_encode($d, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            die();
        }
        $info = file_get_contents("http://apps.education.sn/C_personnel_api/getIEN_info_all?ien=".$ien);
        $infos = json_decode($info,true ) ;
        if ($infos["code"] == 1 or $info == false)
        {
            $d=array("status" => "error", "message" =>"Ien introuvable" );

            echo json_encode($d, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            die();
        }
        $infos = $infos["record"];

        if (empty($this->pers->get_personnel_ien($ien)))
        {
            $this->pers->ien = $ien;
            $this->pers->prenom =  $infos["prenom"];
            $this->pers->nom =  $infos["nom"];
            $this->pers->code_str =  $infos["code_str"];
            $this->pers->email_pro =  $infos["email_pro"];
            $this->pers->save();
        }
//var_dump($infos);exit();

        // echo json_encode($this->pers->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);exit();
        $this->user->ien = $ien ;
        $this->user->id_profil = $this->input->post('id_profil');
        $this->user->code_str =  $infos["code_str"];
        $this->user->statut    = '1';

        echo json_encode($this->user->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }

    public function get_record()
    {
        $args = func_get_args();
        $this->user->ien = $args[0];
        $this->user->get_record();
        echo json_encode($this->user, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }


    public function delete()
    {
        $args = func_get_args();
        $this->pers->id = $args[0];
        $this->user->id = $args[0];
        $this->user->delete();
        echo json_encode($this->pers->delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

}
