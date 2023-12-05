<?php 
class M_sys_profil extends MY_Model
{
	public $id_type_profil;
	public $libelle_type_profil;
	public $etat;
	
	private $insert_role = '';
	private $update_role = '';


	public function get_db_table()
	{
		return 'sys_type_profil';;
	}
	public function get_db_table_pk(){
		return 'id_type_profil';
	}

	public function get_data_liste()
	{
		$sql = "SELECT * FROM sys_type_profil WHERE etat='1'";
		$query = $this->db->query($sql);
		return $query->result();
	}

    public function get_db_table_etat()
    {
        return 'etat';
    }

}
