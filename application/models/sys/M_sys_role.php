<?php 
class M_sys_role extends MY_Model
{
	public $id_actions;
	public $id_type_profil;
	public $id_sous_menu;
	public $d_read;
	public $d_add;
	public $d_upd;
	public $d_del;

	public function get_db_table_pk(){
		return 'id_actions';
	}

	public function delete_all($id_sous_menu)
	{
		$this->db->where($this->get_db_table_fk(), $id_sous_menu);
		$this->db->delete($this->get_db_table());
	}

	public function get_db_table_fk()
	{
		return 'id_sous_menu';
	}

	public function get_db_table($alias = NULL)
	{
		return 'sys_type_action' . db_alias($alias);;
	}
	
	////Recupere la liste des menus et sous menus pour le profil selectionné avec les droits

	public function get_menu_liste($id_type_profil)
	{
		$sql = "SELECT 
					m.id_menu, 
					m.code as m_code, 
					m.libelle as m_libelle, 
					
					sm.id_sous_menu, 
					sm.code as sm_code, 
					sm.libelle as sm_libelle, 
					
					a.id_type_profil, 
					
					CASE a.d_read 
						WHEN '1' THEN 'checked' 
                        ELSE ''  
					END d_read, 
					
					CASE a.d_add 
						WHEN '1' THEN 'checked' 
                        ELSE '' 
					END d_add, 
					
					CASE a.d_upd  
						WHEN '1' THEN 'checked' 
                        ELSE '' 
					END d_upd, 
					
					CASE a.d_del  
						WHEN '1' THEN 'checked' 
                        ELSE '' 
					END d_del 
					
				FROM 
					sys_sous_menu sm 
				LEFT OUTER JOIN sys_type_action a ON 
					sm.id_sous_menu = a.id_sous_menu AND a.id_type_profil = '$id_type_profil' 
				INNER JOIN sys_menu m ON 
					m.id_menu = sm.id_menu 
				ORDER BY m.id_menu ASC";
					
		$query = $this->db->query($sql, $id_type_profil);
		return $query->result();
	}

	public function save_role_action($id_sous_menu, $id_type_profil, $post_role)
	{
		$sql = "SELECT COUNT(id_sous_menu) as smenu FROM sys_type_action 
				WHERE id_sous_menu = '$id_sous_menu' 
				AND id_type_profil = '$id_type_profil'";
		$query 	= $this->db->query($sql);
		$row = $query->row();
		
		
		
		
		$this->db->trans_begin();
		
		if($row->smenu > 0)
		{
			//echo $row->link;
			$post_role[] 		= $id_type_profil;
			$post_role[] 		= $id_sous_menu;
			
			$this->update_role = "UPDATE sys_type_action SET";
			$this->update_role .= " d_read 	= ?,";
			$this->update_role .= " d_add	= ?,";
			$this->update_role .= " d_upd 	= ?,";
			$this->update_role .= " d_del 	= ?";
			$this->update_role .= " WHERE id_type_profil = ? AND id_sous_menu = ?";
			
			$this->db->query($this->update_role, $post_role);
		}else
		{
			///Les elements ci dessous doivent venir en premier dans le tableau
			$tab_post_role[] 	= $id_type_profil;
			$tab_post_role[] 	= $id_sous_menu;
			
			//on complement les elements de role dans le tebleau
			foreach($post_role as $val_role)
			{
				$tab_post_role[]	= $val_role;
			}
			
			//Gestion des sous menus
			$this->insert_smenu = "INSERT INTO sys_type_action SET";
			$this->insert_smenu .= " id_type_profil = ?,";
			$this->insert_smenu .= " id_sous_menu = ?,";
			$this->insert_smenu .= " d_read = ?,";
			$this->insert_smenu .= " d_add = ?,";
			$this->insert_smenu .= " d_upd = ?,";
			$this->insert_smenu .= " d_del = ?";
			
			$this->db->query($this->insert_smenu, $tab_post_role);
		}
		
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$status = 'error';
			$result = 'Erreur lors de la mise à jour des roles';
		}
		else
		{
			$this->db->trans_commit();
			$status = 'success';
			$result = 'Mise a jour des roles effectuée avec succès';
		}
		
		$d = array();
		$d['status'] = $status;
		$d['message'] = $result;
		return $d;
	}
	
	
	public function raz_sous_menu_active($id_profil)
	{
		///RAZ des sous-menus associés au profil	
		
		$sql_sm = "UPDATE sys_type_action SET 
				d_read = '-1', d_add = '-1', d_upd = '-1', d_del = '-1' 
				WHERE id_type_profil = '$id_profil'";
		
		$this->db->query($sql_sm);
	}
	

	public function get_conn_roles($id_profil /*, $code_str, $ien*/)
	{
		//$pdo =& get_instance();
		$sql = "SELECT
					a.d_read,
					a.d_add,
					a.d_upd,
					a.d_del,
					m.code as mcode,
					m.libelle,
					sm.code as smcode,
					sm.libelle
				FROM
					sys_type_action a
				INNER JOIN sys_sous_menu sm ON
					a.id_sous_menu = sm.id_sous_menu AND a.id_type_profil = ?
					AND a.d_read = '1' 
				INNER JOIN sys_menu m ON
					sm.id_menu = m.id_menu
				INNER JOIN sys_type_profil p ON
					p.id_type_profil = a.id_type_profil
				INNER JOIN sys_user n ON
					n.id_profil = p.id_type_profil
				ORDER BY a.id_actions ASC";

		$query = $this->db->query($sql, array($id_profil));
		$result = $query->result();
		return $result;
	}

	public function get_conn_roles1($id_profil /*, $code_str, $ien*/)
	{
		//$pdo =& get_instance();
		$sql = "SELECT
					a.d_read,
					a.d_add,
					a.d_upd,
					a.d_del,
					m.code as mcode,
					m.libelle,
					sm.code as smcode,
					sm.libelle
				FROM
					sys_type_action a
				INNER JOIN sys_sous_menu sm ON
					a.id_sous_menu = sm.id_sous_menu AND a.id_type_profil = ?
					AND a.d_read = '1' 
				INNER JOIN sys_menu m ON
					sm.id_menu = m.id_menu
				INNER JOIN sys_type_profil p ON
					p.id_type_profil = a.id_type_profil
				INNER JOIN agent_snop n ON
					n.id_profil = p.id_type_profil
				ORDER BY a.id_actions ASC";

		$query = $this->db->query($sql, array($id_profil));
		$result = $query->result();
		return $result;
	}
}