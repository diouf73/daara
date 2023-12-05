<?php

class M_sys_menu extends MY_Model
{
	public $id_menu;
	public $code;
	public $libelle;
	public $etat;

	public function get_db_table_pk()
	{
		return 'id_menu';
	}

	public function get_db_table_etat()
	{
		return 'etat';
	}

	public function get_active_data()
	{
		return $this->db->where('etat', '1')
			->get($this->get_db_table())
			->result();
	}

	public function get_db_table()
	{
		return 'sys_menu' ;
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


