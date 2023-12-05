<?php btn_add_action('LST_MENU'); ?>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Liste des menus </h3>
                </div>

                <div class="panel-body">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 9%">Code</th>
                            <th style="width: 35%">Libellé</th>
                            <th></th>
                        </tr>

                        </thead>
                        <tbody>
                        <?php foreach ($menu_liste as $value): ?>
                            <tr>
                                <td><?= $value->code ?></td>
                                <td><?= $value->libelle ?></td>

                                <td class="actions" style="width: 1%; text-align: center; white-space: nowrap">
                                    <?php btn_edit_action($value->id_menu, 'LST_MENU'); ?> &nbsp;
                                    <?php btn_delete_action($value->id_menu, 'LST_MENU'); ?>&nbsp;
                                    <?php btn_show_action($value->id_menu, 'LST_MENU'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


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
                        <input type="hidden" id="id_menu" name="id_menu"/>

                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-4">Code <span class="text-danger">*</span></label>

                                <div class="col-md-8">
                                    <input name="code" id="code" type="text"
                                           class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4">Libelle <span class="text-danger">*</span></label>

                                <div class="col-md-8">
                                    <input name="libelle" id="libelle" type="text"
                                           class="form-control" required>
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

        $(document).ready(function () {

            $('#datatable-buttons').managing_ajax({
                id_modal_form: 'modal_form',

                id_form: 'form',
                url_submit: "<?php echo site_url('sys/C_sys_menu/save_menu')?>",

                title_modal_add: 'Ajouter un menu',
                focus_add: 'code',

                title_modal_edit: 'Modifier un menu',
                focus_edit: 'libelle',

                url_edit: "<?php echo site_url('sys/C_sys_menu/get_record_menu')?>",
                url_delete: "<?php echo site_url('sys/C_sys_menu/delete_menu')?>",
            });

        });

    </script>
<?php if (ENVIRONMENT !== 'production'): ?>{elapsed_time} seconds&nbsp;|&nbsp;{memory_usage}<?php endif ?>