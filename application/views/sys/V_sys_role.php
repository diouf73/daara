<style>
.table > tbody > tr > td,
{
  padding: 2px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}

.titre{
	color:#FFF;
	font-weight:bold;
	background-color: #0099FF;
}

.thtitre{
	color:#FFF;
	font-weight:bold;
	background-color:#09F;
}

.table th, .table td { 
        border-top: none !important;
        border-left: none !important;
    }

</style>

<form id="form_role" method="post">
<input type="hidden" name="id_role_profil" id="id_role_profil" value="<?php echo $id_profil ?>">
<input type="button" id="btn-role-save" class="btn btn-lg btn-success" value="Enregistrer"/>
<br><br>
<legend></legend>
<div class="clearfix"></div>
<div class="row">
<?php 
$js_menu 	= '';
$js_smenu 	= '';
$js_tgl 	= '';

?>
	<div class="col-md-3">
    	<table width="100%" class="table table-striped" cellpadding="0" border="0">
        <tr><th colspan="2" class="thtitre">LISTE DES MENUS</th></tr>
        <?php 
		$data_val 	= 0; ///Pour les numeros de data-val dans le a-href
		$pmenu		= '';  //Pour la liste des elements de data-val de la fonction jquery
		$cur_mn = '';  ///Pour connaitre le menu courant
		$rpr_data_val = 0;  //Repere pour le premier parcours
		
		foreach($data_menu as $menu)
		{
			if($cur_mn != $menu->m_libelle)
			{
				$cur_mn		= $menu->m_libelle;
				$data_val	= $menu->id_menu;
				
				if($rpr_data_val == 0)
				{
					$pmenu .= "#pmenu_$data_val";
				}else
				{
					$pmenu .= ", #pmenu_$data_val";
				}
		?>
        		<tr><th><a href="#" class="link" data-val="<?php echo $data_val ?>"><?php echo $menu->m_libelle ?></a></th></tr>
        <?php 	
				$rpr_data_val = $data_val;
			}
			
		}
		?>
        </table>   
    </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-8">
    <?php 
	$k = 0;  ///Incremente les parcours de la table data_menu
	$i = 0;  /// Pointeur sur les menus
	
	$menu_parent = '';
	foreach($data_menu as $smenu)
	{
		$k = $smenu->id_sous_menu;
		
		if($i != $smenu->id_menu)
		{
			$i = $smenu->id_menu;
			
			if($menu_parent != '')  ///On a dépassé le premier tour
			{
			?>
			</table>
			<?php 		
			}
			
			///Cela nous servira de repere pour pouvoir fermer le tableau
			$menu_parent = $smenu->m_libelle;
		?>
    		<table class="table table-striped" width="98%" id="pmenu_<?php echo $i ?>" style="display:none;">
        		<tr>
            		<thead class="titre">
                	<td><input type="checkbox" name="menu_<?php echo $i ?>" class="pmenu_<?php echo $i ?>"></td>
                    <?php 
						///Bout de code js
						$js_menu .= "$('.pmenu_$i').click(function(){
			 
							//on cherche les checkbox à l'intérieur de l'id  
							var pmenu_$i = $('#pmenu_$i').find(':checkbox'); 
							if(this.checked)
							{ // si 'checkAll' est coché
							  pmenu_$i.prop('checked', true); 
							}else
							{ // si on décoche 'checkAll'
							  pmenu_$i.prop('checked', false);
							}        
						});";
						 
					?>
                    <td>SOUS-MENUS</td>
                    <td>Lecture</td>
                    <td>Ajout</td>
                    <td>Modif</td>
                    <td>Suppr</td>
                </thead>
            </tr>
            
            <tr id="psmenu_<?php echo $k ?>">
            	<td><input type="checkbox" name="menu_<?php echo $k ?>" class="psmenu_<?php echo $k ?>"></td>
                <?php 
						///Bout de code js
						$js_smenu .= "
						
						$('.psmenu_$k').click(function(){
 
						//on cherche les checkbox à l'intérieur de l'id  
						var psmenu_$k = $('#psmenu_$k').find(':checkbox'); 
						if(this.checked)
						{ // si 'checkAll' est coché
						  psmenu_$k.prop('checked', true); 
						}else
						{ // si on décoche 'checkAll'
						  psmenu_$k.prop('checked', false);
						}        
					});";
						
						///Bout de code js
						$js_smenu .= "
						
						$(':checkbox.smenu_$k').click(function(){
							$(':checkbox.pmenu_$i').prop('checked', false);
							$(':checkbox.psmenu_$k').prop('checked', false);
						});
						
						$(':checkbox.psmenu_$k').click(function(){
							$(':checkbox.pmenu_$i').prop('checked', false);
						});";
					?>
                <td><?php echo $smenu->sm_libelle ?></td>
                <td><input type="checkbox" name="btn_role[]" value="read_<?php echo $k ?>" <?php echo $smenu->d_read; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="add_<?php echo $k ?>" <?php echo $smenu->d_add; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="upd_<?php echo $k ?>" <?php echo $smenu->d_upd; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="del_<?php echo $k ?>" <?php echo $smenu->d_del; ?> class="smenu_<?php echo $k ?>"></td>
            </tr>
        <?php 
		}else
		{
		?>
			<tr id="psmenu_<?php echo $k ?>">
            	<td><input type="checkbox" name="menu_<?php echo $k ?>" class="psmenu_<?php echo $k ?>"></td>
                <?php 
						///Bout de code js
						$js_smenu .= "
						
						$('.psmenu_$k').click(function(){
 
						//on cherche les checkbox à l'intérieur de l'id  
						var psmenu_$k = $('#psmenu_$k').find(':checkbox'); 
						if(this.checked)
						{ // si 'checkAll' est coché
						  psmenu_$k.prop('checked', true); 
						}else
						{ // si on décoche 'checkAll'
						  psmenu_$k.prop('checked', false);
						}        
					});";
						
						///Bout de code js
						$js_smenu .= "
						
						$(':checkbox.smenu_$k').click(function(){
							$(':checkbox.pmenu_$i').prop('checked', false);
							$(':checkbox.psmenu_$k').prop('checked', false);
						});
						
						$(':checkbox.psmenu_$k').click(function(){
							$(':checkbox.pmenu_$i').prop('checked', false);
						});";
					?>
                <td><?php echo $smenu->sm_libelle ?></td>
                <td><input type="checkbox" name="btn_role[]" value="read_<?php echo $k ?>" <?php echo $smenu->d_read; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="add_<?php echo $k ?>" <?php echo $smenu->d_add; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="upd_<?php echo $k ?>" <?php echo $smenu->d_upd; ?> class="smenu_<?php echo $k ?>"></td>
                <td><input type="checkbox" name="btn_role[]" value="del_<?php echo $k ?>" <?php echo $smenu->d_del; ?> class="smenu_<?php echo $k ?>"></td>
            </tr>
		<?php
		}
	}
	?>
    </div>
</div>
</form>

<script>
$(document).ready(function (){
	
	$('#btn-role-save').on('click', function (event){
		
		$.ajax({
			url: "<?php echo site_url('sys/C_sys_profil/save_role_action')?>",
			type: "POST",
			data: $('#form_role').serialize(),
			dataType: "JSON",
			success: function (data){
		   
			   if(data.status == 'success')
			   {
				   $.Notification.autoHideNotify('success', 'bottom right', data.message);
				   $('#modal_role').modal('hide');
			   }else
			   {
				   $.Notification.autoHideNotify('error', 'bottom right', data.message)
			   }
			 
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erreur envoi');
			}
		});
	});	
});

</script>


<script>
////Niveau Sous-menu
<?php echo $js_menu ?>

////Niveau Menu
<?php echo $js_smenu ?>
</script>

<script>

$(document).ready(function (){		
	$('.link').click(function (event) {
		var val = $(this).data('val'); 
		//$('#pmenu_0,#pmenu_1').hide();
		$('<?php echo $pmenu; ?>').hide();
		$('#pmenu_'+val ).show();
		return false;
	});
});
</script>
 