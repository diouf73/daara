<?php
btn_add_action('PROFIL')
?>

<style>
.modal-dialog{
   width: 80%;
   margin: auto;
}
</style>
<!-- Page-Title -->

<!--  Modal content for the above example -->
<div id="modal_role" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="row">
	<div class="col-md-12">
    	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">
                CONFIGURATION DES ROLES POUR <span style="color:#F00; text-transform:uppercase;" id="role_profil"> <?php ///echo $value->libelle_type_profil ; ?></span>
                </h4>
            </div>
            <div class="modal-body" id="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div>
    </div>
</div>
    
    <!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Liste des profils </h3>
            </div>
            <div class="panel-body">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Libelle</th>
                        <th width="9%">Roles</th>
                        <th width="5%">Etat</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_data as $value)
					{?>
                        <tr>
                            <td><?=$value->libelle_type_profil; ?></td>
                             <td>
                             <a href="#"
                             	profil="<?php echo $value->libelle_type_profil;?>" 
                                id_profil="<?php echo $value->id_type_profil;?>"
                             class="btn-role btn btn-inverse waves-effect waves-light btn-xs m-b-5">
                             <i class="fa fa-cog fa-lg"></i><span> Role</span></a>
                             </td>
                            <td>
								<?php
                                if ($value->etat)
								{ 
								?>
                                <button class="btn btn-icon waves-effect waves-light btn-success btn-xs m-b-5">
                                <i class="fa fa-toggle-on fa-lg"></i>
                                </button> 
								
								<?php
								}else
								{
								?> 
                                <button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5">
                                <i class="fa fa-toggle-off fa-lg"></i>
                                </button> 
								<?php 
								}
								?>
                                 </td>
                            <td class="actions" style="width: 1%; text-align: center; white-space: nowrap">
                                <a href="#" class="on-default btn_edit" id='<?php echo $value->id_type_profil; ?>'><i class="fa fa-pencil"></i></a>
                                &nbsp;
                                <a href="#" class="on-default btn_delete" id='<?php echo $value->id_type_profil; ?>'><i class="fa fa-trash-o"
                                                                             style="color:red"></i></a>
                                &nbsp;
                                <a href="#" class="on-default btn_edit" id='<?php echo $value->id_type_profil; ?>'><i class="fa fa-eye" style="color:#CCCCCC"></i></a>
                            </td>
                        </tr>
                    <?php
                    }
					?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> <!-- End Row -->


<!-- sample modal content -->
<div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_formLabel"
     aria-hidden="true">
    <form action="#" id="form" class="form-horizontal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="modal_formLabel">Title</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_type_profil" name="id_type_profil"/>
					
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Libelle</label>

                            <div class="col-md-9">
                                <input name="libelle_type_profil" id="libelle_type_profil"
                                       class="form-control" type="text" required>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Enregistrer"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->


<script type="text/javascript">
 
	$(document).ready(function ()
	{
		
		$('#datatable-buttons').managing_ajax(
		{
			id_menu: 'menu_sys_profils', //id du menu dans le fichier de (navigation) dans notre cas left_side_bar
			id_modal_form: 'modal_form', //id du modal qui contient le formulaire

			id_form: 'form', //id du formulaire
            url_submit: "<?php echo site_url('sys/C_sys_profil/save')?>", //url du save (données envoyés par post)
			
			title_modal_add: 'Nouveau profil', //Title du modal à l'ouverture en mode ajout
			focus_add: 'libelle', //l'emplacement du focus en mode ajout

			title_modal_edit: 'Edition de profil', //Title du modal à l'ouverture en mode edit
			focus_edit: 'libelle',//l'emplacement du focus en mode edit

            url_edit: "<?php echo site_url('sys/C_sys_profil/get_record')?>", //url le fonction qui recupére la données de la ligne
            url_delete: "<?php echo site_url('sys/C_sys_profil/delete')?>", //url de la fonction supprimé
		});
		
		$('.btn-role').on('click', function (event)
		{
			var id_cur_profil 	= $(this).attr('id_profil');
			var cur_profil 		= $(this).attr('profil');

			//Appel controller/action/id
			$.ajax(
			{
                url: '<?php echo site_url('sys/C_sys_profil/get_menu_liste/') ?>' + id_cur_profil,
				type: "GET",
				dataType: "HTML",
				success: function (data) {
					//alert(data);
					$('#modal-body').html(data);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Error adding / update data');
				}
			});

			$("#role_profil").text(cur_profil);
			$("#id_role_profil").val(id_cur_profil);
			$('#modal_role').modal('show');
		});
	
	});
  
</script>