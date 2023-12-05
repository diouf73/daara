<?php

class M_sys_sous_menu extends MY_Model
{
    public $id_sous_menu;
    public $id_menu;
    public $code;
    public $libelle;
    public $etat;

    public function fake_delete_all($id_menu)
    {
        $this->db->set($this->get_db_table_etat(), '-1');
        $this->db->where($this->get_db_table_fk(), $id_menu);
        $this->db->update($this->get_db_table());
    }

    public function get_db_table_etat()
    {
        return 'etat';
    }

    public function get_db_table_fk()
    {
        return 'id_menu';
    }

    public function get_db_table()
    {
        return 'sys_sous_menu';
    }

    public function get_list_sous_menu($id_menu)
    {
        return $this->db->select($this->get_db_table_pk())
            ->from($this->get_db_table())
            ->where($this->get_db_table_fk(), $id_menu)
            ->get()->result();
    }

    public function get_db_table_pk()
    {
        return 'id_sous_menu';
    }

    public function get_active_data()
    {
        return $this->db->select('sm.*, m.libelle as menu')
            ->where('sm.etat', '1')
            ->join('sys_menu m', 'm.id_menu = sm.id_menu')
            ->get($this->get_db_table().' as sm')
            ->result();
    }

    public function get_menu_liste()
    {
        $sql = "SELECT
					m.id_menu,
					m.libelle as m_libelle,
					
					sm.id_sous_menu,
					sm.libelle as sm_libelle
				FROM
					sys_sous_menu sm
				INNER JOIN sys_menu m ON
					m.id_menu = sm.id_menu
				ORDER BY m.libelle ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }
}


