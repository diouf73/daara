<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_sys_menu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sys/M_sys_menu', 'menu');
        $this->load->model('sys/M_sys_sous_menu', 'sous_menu');
        $this->load->model('sys/M_sys_role', 'role');
      //  $this->load->helper('form');
    }

    public function index()
    {
        $menu_liste 			= $this->menu->get_menu_liste();
		$data['menu_liste'] 	= $menu_liste;
        $this->load->view('sys/V_sys_menu', $data);
    }


    public function list_menu()
    {
        $data['menu_liste'] = $this->menu->get_active_data();
        $this->load->view('sys/V_list_menu', $data);
    }

    public function get_record_menu()
    {
        $args = func_get_args();
        $this->menu->id_menu = $args[0];
        $this->menu->get_record();

        echo json_encode($this->menu, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function save_menu()
    {

        if ($this->input->post('id_menu') != '')
            $this->menu->id_menu = $this->input->post('id_menu');

        $this->menu->code = $this->input->post('code');
        $this->menu->libelle = $this->input->post('libelle');
        $this->menu->etat = '1';
        echo json_encode($this->menu->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function delete_menu()
    {
        $args = func_get_args();
        $list_sous_menu = $this->sous_menu->get_list_sous_menu($args[0]);
        foreach ($list_sous_menu as $sous_menu) {
            $this->delete_sous_menu($sous_menu->{$this->sous_menu->get_db_table_pk()});
        }
        $this->menu->id_menu = $args[0];
        echo json_encode($this->menu->fake_delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function delete_sous_menu($id_sous_menu)
    {
        $this->role->delete_all($id_sous_menu);
        $this->sous_menu->id_sous_menu = $id_sous_menu;
        echo json_encode($this->sous_menu->fake_delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function list_sous_menu()
    {
        $data_menu = $this->menu->get_data();

        $data['select_data_menu'] = create_select_list($data_menu, 'id_menu', 'libelle');
        $data['sous_menu_liste'] = $this->sous_menu->get_active_data();
        $this->load->view('sys/V_list_sous_menu', $data);

    }

    public function get_record_sous_menu()
    {
        $args = func_get_args();
        $this->sous_menu->id_sous_menu = $args[0];
        $this->sous_menu->get_record();
        echo json_encode($this->sous_menu, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public function save_sous_menu()
    {
        $id_menu = $this->input->post('id_sous_menu');
        if (isset($id_menu) && $id_menu != "")
            $this->sous_menu->id_sous_menu = $this->input->post('id_sous_menu');
        $this->sous_menu->id_menu = $this->input->post('id_menu');
        $this->sous_menu->code = $this->input->post('code');
        $this->sous_menu->libelle = $this->input->post('libelle');
        $this->sous_menu->etat = '1';
        echo json_encode($this->sous_menu->save(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
}
