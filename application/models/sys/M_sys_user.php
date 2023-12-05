<?php
class M_sys_user extends MY_Model
{

    public $id ;
    public $ien ;
    public $id_profil;
    public $code_acces;
    public $statut;

	public function get_data( /*$code_str*/)

    {
        if ($_SESSION['code_str'] == "1290902230")
            return $this->db->select("usr.*, pers_str.*, ssp.*")
                ->from($this->get_db_table() . ' as usr')
                ->join('personnel as pers_str', 'pers_str.ien = usr.ien')
                ->join('sys_type_profil as ssp', 'ssp.id_type_profil = usr.id_profil')
                ->get()
                ->result();
        else {
            return $this->db->select("usr.*, pers_str.*, ssp.*")
                ->from($this->get_db_table() . ' as usr')
                ->join('personnel as pers_str', 'pers_str.ien = usr.ien')
                ->join('sys_type_profil as ssp', 'ssp.id_type_profil = usr.id_profil')
                ->where('pers_str.code_str', $_SESSION['code_str'])
                ->get()
                ->result();
        }
        /*		$sql = "SELECT
                            usr.id as id_user, CONCAT(UPPER(ens.prenom_ens), ' ',UPPER(ens.nom_ens)) AS prenom_nom,
                            usr.email,
                            pr.libelle_type_profil AS profil,
                            usr.ien
                        FROM
                            sys_niits usr
                        INNER JOIN sys_type_profil pr ON (pr.id_type_profil = usr.id_profil)";
                       WHERE usr.code_str = '$code_str'";

                $query = $this->db->query($sql);*/

    }

    public function verif_ien()
    {
        $sql = "SELECT * FROM personnel_structure AS pers_str 
        WHERE pers_str.ien_personnel = '".$this->ien."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function verif_ienusr($ien)
    {
        $sql = "SELECT * FROM sys_user AS usr 
        WHERE usr.ien = '".$ien."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

	public function get_db_table()
    {
		return 'sys_user';
	}

    public function get_db_table_pk()
    {
        return 'id';
    }


}
