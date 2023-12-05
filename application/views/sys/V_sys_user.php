<?php
//var_dump($_SESSION);exit();

btn_add_action('USR') ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Liste des utilisateurs</h3>
            </div>
            <div class="panel-body">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>IEN</th>
                        <th>Prenom Nom</th>
                        <th>Profil</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_data as $value)
					{ ?>
                        <tr>
                            <td><?=$value->ien; ?></td>
                            <td><?=strtoupper($value->prenom).' '.strtoupper($value->nom) ; ?></td>
                            <td><?=$value->libelle_type_profil; ?></td>
                            <td style="width: 1%; white-space: nowrap">
                               <!-- <?php /*btn_edit_action($value->ien,'USR')  */?>&nbsp;&nbsp;-->
                                <?php info_conn($value->ien,'USR') ?>&nbsp;&nbsp;
                                <?php btn_delete_action($value->id,'USR')  ?>&nbsp;&nbsp;
                               <!-- --><?php /*btn_show_action($value->ien, 'USR')  */?>
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

                  <!--  <input type="hidden" name="statut" id="statut" />
                    <input type="hidden" name="code_acces" id="code_acces" />
                    <input type="hidden" name="email_pro" id="email_pro" />-->

                    <div class="form-body">
                        <div class="form-group">

                            <label class="control-label col-md-3">Ien</label>

                            <div class="col-md-9">
                                <input name="ien" id="ien"
                                       class="form-control" type="text" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Profile</label>

                            <div class="col-md-9">
                                <select name="id_profil" id="id_profil" class="form-control" required>
                                        <?php echo $select_profile; ?>
                                </select>
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
    $(document).ready(function (){

        $('#datatable').managing_ajax({
            id_modal_form: 'modal_form', //id du modal qui contient le formulaire

            id_form: 'form', //id du formulaire
            url_submit: "<?php echo site_url('sys/C_sys_user/save')?>", //url du save (données envoyés par post)

            title_modal_add: 'Nouveau utilisateur', //Title du modal à l'ouverture en mode ajout
            focus_add: 'ien', //l'emplacement du focus en mode ajout

            title_modal_edit: 'Edition utilisateur', //Title du modal à l'ouverture en mode edit
            focus_edit: 'ien',//l'emplacement du focus en mode edit

            url_edit: "<?php echo site_url('sys/C_sys_user/get_record')?>", //url le fonction qui recupére la données de la ligne
            url_delete: "<?php echo site_url('sys/C_sys_user/delete')?>", //url de la fonction supprimé
        });

        $('#datatable tbody').on('click', '.info_conn', function () {

            $('#modal_form').modal('hide');

//console.log($(this).attr('id'));
            var href = "<?php echo site_url('C_connexions/gen_pass/')?>" + $(this).attr('id');

            $('#loadingModal').modal('show');
            $.ajax({
                url:href,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    /*$('#loadingModal').modal('hide');*/
                    $('#loadingModal').modal('hide');
                    $.Notification.autoHideNotify(data.status, 'bottom right', 'Sending', data.message);
                    $('#'+menu_encours).click();
                },
                error: function(jqXHR) {
                    content.html(jqXHR.responseText);
                    content.show();
                }

            });

            return false;

        });


    });
</script>
