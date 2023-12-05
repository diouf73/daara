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

<div class="row">
<div class="col-md-8">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Liste des menus</h3></div>
<div class="panel-body">
<table id="datatable-buttons" class="table table-striped table-bordered">
<?php 
$k = 0;  ///Incremente les parcours de la table data_menu
$i = 0;  /// Pointeur sur les menus

$menu_parent = '';
foreach($menu_liste as $smenu)
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
		<table  width="100%" id="datatable-buttons" class="table table-striped table-bordered">
			<tr>
				<thead class="titre">
				<td width="30%">MENUS</td>
				<td>SOUS-MENUS</td>
			</thead>
		</tr>
		
		<tr>
			<td><b><?php echo $menu_parent;?></b></td>
			<td><?php echo $smenu->sm_libelle ?></td>
		</tr>
	<?php 
	}else
	{
	?>
		<tr>
			<td></td>
			<td><?php echo $smenu->sm_libelle ?></td>
		</tr>
	<?php
	}
}
?>

</div>
</div>
</div>
</div>

 