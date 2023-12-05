<?php
class M_sys_niits extends MY_Model
{
    public $id ;
    public $ien ;
    public $email ;
    public $id_profil;
    public $code_str;
    public $password;
    public $statut;

    public function get_data(){
        return $this->db->select('us.*, p.libelle_type_profil,a.email_agent as email')
                    ->from($this->get_db_table().' us')
                    ->join('sys_type_profil p','p.id_type_profil = us.id_profil')
                    ->join('agent a','a.IEN = us.ien')
                    ->get()
                    ->result();
    }

    public function get_db_table()
    {
        return 'sys_user';
    }

    public function get_db_table_pk()
    {
        return 'id';
    }
    public function get_db_table_etat()
    {
        return 'statut';
    }
}
