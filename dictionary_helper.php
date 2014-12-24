<?php

include_once ( 'scripts/db.php' );

/***********************************/

/* Measurement Units */

/***********************************/

function measurementunit_render_page
(
	$data
) 
{

	echo '
	  <div class="toolbar">
        <button type="button" class="btn btn-default" aria-label="New row" data-placement="top" title="Новая запись" data-toggle="modal" data-target="#dlgEditMeasurementUnit" data-action="new">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        </button>
      </div>
      <div class="message">

      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><h3>Справочник единиц измерения</h3></div>
        <div class="panel-body">
        ';
    echo '<table class="table table-hover table-bordered">';

    measurementunit_render_table($data);

    echo '</table>';
    echo '
        </div>
      </div>
    	';
}


function measurementunit_render_table
(
	$data
)
{
	echo '<thead>';
	echo '	<tr>';
	echo '		<th>#</th>';
	echo '		<th>Name</th>';
	echo '	</tr>';
	echo '</thead>';

	echo '<tbody>';

	if ( !empty( $data ) ) {
		foreach ( $data as $item ) {
			echo '<tr>';

			$inctive_state = 'glyphicon glyphicon-star-empty';

			if ( $item['inactive'] != 1 ) {
				$inctive_state = 'glyphicon glyphicon-star';
			}
			
			echo '	<th scope="row" class="col-md-2">'.$item['measurementunitid'];
			echo '		<button type="button" 
								class="btn btn-default pull-right btnDelete" 
								aria-label="Delete row" 
								data-toggle="modal" 
								data-placement="top" 
								title="Деактивировать" 
								data-target="#dlgDeleteMeasurementUnit"
								data-measurementunitid="'.$item['measurementunitid'].'"
								data-measurementunitname="'.$item['measurementunitname'].'"
								data-inactive="'.$item['inactive'].'"
								data-action="delete"
						>
				';
  			echo '			<span class="glyphicon '.$inctive_state.'" aria-hidden="true"></span>';
			echo '		</button>';				



			echo '		<button type="button" 
								class="btn btn-default pull-right" 
								aria-label="Edit row" 
								data-toggle="modal" 
								data-placement="top" 
								title="Редактировать" 
								data-target="#dlgEditMeasurementUnit"
								data-measurementunitid="'.$item['measurementunitid'].'"
								data-measurementunitname="'.$item['measurementunitname'].'"
								data-action="edit"
						>
				';
  			echo '			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
			echo '		</button>';
			echo '	</th>';
			echo '	<td>'.$item['measurementunitname'].'</td>';
			echo '</tr>';
		}
	}

    echo '</tbody>';
	echo "
		<script>
			$('.btnDelete').on('click', function () {
				var button = $(this);
				var id = button.data('measurementunitid');
				var next_inactive = !button.data('inactive');
				//alert( id );
				//alert( next_inactive );
		        $.ajax( { 
		            url: 'scripts/provider.php',
		            data: { action: 'measurementUnitDelete', measurementunitid: id, inactive: next_inactive },
		            type: 'POST',
		            success: function( output ) {
		            			//alert ( output );
		                        location.reload();
		                    }
		        });
				event.preventDefault();
			});
		</script>

		";    
}

function measurementunit_render_modal_edit
(
)
{
	echo '<div class="modal fade" id="dlgEditMeasurementUnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	echo '<div class="modal-dialog">';
	echo '  <div class="modal-content">';
	echo '    <div class="modal-header">';
	echo '      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	echo '      <h4 class="modal-title" id="myModalLabel">Edit measurement data</h4>';
	echo '    </div>';
	echo '    <div class="modal-body">';
	echo '
			<div class="alert alert-danger col-sm-14 hidden" role="alert" id="pnlAlert">
				Поле ввода названия должно быть заполнено.
			</div>
		';
	echo '
				<form class="form-horizontal" id="frmEditMeasurementUnit">
				  
				  <div class="form-group" id="pnlWithError">
				    <label for="txtMeasurementUnitName" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="txtMeasurementUnitName">
				      <input type="hidden" class="form-control" id="txtMeasurementUnitId">
				      <input type="hidden" class="form-control" id="txtAction">
				    </div>
				  </div>
<!--
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success">Save</button>
				      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				    </div>
				  </div>
-->
				</form>
	';
	echo '    </div>';
	echo '
			<div class="modal-footer">
		      <button type="button" class="btn btn-success" autocomplete="off" id="btnSave">Save</button>
		      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		';	
	echo '  </div>';
	echo '</div>';
	echo '</div>';

	echo "
		<script>
			$('#dlgEditMeasurementUnit').on('show.bs.modal', function (event) 
			{
				var button = $(event.relatedTarget);
				var name = button.data('measurementunitname');
				var id = button.data('measurementunitid');
				var action = button.data('action');
				var modal = $(this);

				modal.find( '#txtAction' ).val ( action );

				switch ( action ) {
					case 'edit':
						modal.find( '#myModalLabel' ).text( 'Редактирование единицы измерения' );
						modal.find( '#txtMeasurementUnitName' ).val( name );
						modal.find( '#txtMeasurementUnitId' ).val( id );
						break;
					case 'new':
						modal.find( '#myModalLabel' ).text( 'Новая единица измерения' );
						modal.find( '#txtMeasurementUnitName' ).val( '' );
						modal.find( '#txtMeasurementUnitId' ).val( '' );
						break;
					default:
						break;
				}

				$( '#pnlWithError' ).removeClass( 'has-error' );
				$( '#pnlAlert' ).addClass( 'hidden' );

				$( '#txtMeasurementUnitName' ).focus( );
			})
		</script>

		<script>
		/*
			$( '#txtMeasurementUnitName' ).blur( function( ) {
		*/
			function ValidateEdit( ) {
				var res = false;
				var name = $( '#txtMeasurementUnitName' ).val( );
				if ( name == '')
				{
					$( '#pnlWithError' ).addClass( 'has-error' );
					$( '#pnlAlert' ).removeClass( 'hidden' );
				}
				else
				{
					$( '#pnlWithError' ).removeClass( 'has-error' );
					$( '#pnlAlert' ).addClass( 'hidden' );
					res = true;
				}
				return res;
			};
		/*
			});
		*/
			$( '#btnSave' ).on( 'click', function ( ) {
				$( '#frmEditMeasurementUnit' ).submit( );
			});
	
			$( '#frmEditMeasurementUnit' ).submit( function( event ) {
				if ( ValidateEdit( ) )
				{
					var id = $( '#txtMeasurementUnitId' ).val( );
					var name = $( '#txtMeasurementUnitName' ).val( );
					var actionname = $( '#txtAction' ).val( );
					var ajaxactionname = '';

					switch ( actionname ) {
						case 'new':
							ajaxactionname = 'measurementUnitInsert';
							break;
						case 'edit':
							ajaxactionname = 'measurementUnitUpdate';
							break;							
					}

			        $.ajax({ 
			            url: 'scripts/provider.php',
			            data: { action: ajaxactionname, measurementunitid: id, measurementunitname: name },
			            type: 'POST',
			            success: function( output ) {
			            			//alert ( output );
			                        location.reload();
			                    }
			        });
				}
				event.preventDefault();
			});
		</script>

		";	
}

/*
function measurementunit_render_modal_delete
(
)
{
	echo '<div class="modal fade" id="dlgDeleteMeasurementUnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	echo '<div class="modal-dialog">';
	echo '  <div class="modal-content">';
	echo '    <div class="modal-header">';
	echo '      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	echo '      <h4 class="modal-title" id="myModalLabel">Деактивировать запись справочника в системе</h4>';
	echo '    </div>';
	echo '    <div class="modal-body">';
	echo '
				<form class="form-horizontal" id="frmDeleteMeasurementUnit">
				  <div class="form-group">
				  	<div class="col-sm-5">
				    	<label>Вы уверены, что хотите сделать запись неактивной?</label>
				    </div>	
				    <div class="col-sm-offset-2 col-sm-5">
				    	<input type="hidden" class="form-control" id="txtDeleteMeasurementUnitId">
				    	<label id="lblDeleteMeasurementUnitName"></label>
				    </div>
				  </div>
				</form>
	';
	echo '    </div>';
	echo '
			<div class="modal-footer">
		      <button type="button" class="btn btn-danger" autocomplete="off" id="btnDelete">Деактивировать</button>
		      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		';
	echo '  </div>';
	echo '</div>';
	echo '</div>';
	
	echo "
		<script>
			$('#dlgDeleteMeasurementUnit').on('show.bs.modal', function (event) 
			{
				var button = $(event.relatedTarget);
				var name = button.data('measurementunitname');
				var id = button.data('measurementunitid');
				var modal = $(this);
				modal.find('#lblDeleteMeasurementUnitName').text(name);
				modal.find('#txtDeleteMeasurementUnitId').val(id);
			})
		</script>

		<script>
			$('#btnDelete').on('click', function () {
				$( '#frmDeleteMeasurementUnit' ).submit();
			});
			$( '#frmDeleteMeasurementUnit' ).submit( function( event ) {
				var id = $('#txtDeleteMeasurementUnitId').val();
				// alert( id );
		        $.ajax({ 
		            url: 'scripts/provider.php',
		            data: { action: 'measurementUnitDelete', measurementunitid: id },
		            type: 'POST',
		            success: function( output ) {
		            			//alert ( output );
		                        location.reload();
		                    }
		        });
				event.preventDefault();
			});
		</script>

		";
}
*/

/***********************************/

/* Detail Type */

/***********************************/

function detailtype_render_page
(
	$id,
	$data
) 
{

	echo '
	    <div class="input-group col-md-5 pull-right">
	      <input type="text" class="form-control" id="txtSearch" placeholder="Поиск по названию">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button" id="btnSearch"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	      </span>
	    </div> 	
	  <div class="toolbar">
	      <button type="button" class="btn btn-default" aria-label="New row" data-placement="top" title="Новая запись" data-toggle="modal" data-target="#dlgEditDetailType" data-action="new">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        </button>
      </div>
      <div class="message">
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><h3>Справочник типов элементов конструкции</h3></div>
        <div class="panel-body">
        ';
    echo '<table class="table table-hover table-bordered">';

    detailtype_render_table($data);

    echo '</table>';
    echo '
        </div>
      </div>
    	';

	echo "
		<script>
			function DoSearch(searchstring)
			{
				var current_url = location.origin + location.pathname;
				if ( searchstring != null && searchstring != '' ) {
					location.replace(current_url + '?id=".$id."&searchstring=' + searchstring);
				}
				else
				{
					location.replace(current_url + '?id=".$id."');
				}
			};

			$('#txtSearch').bind('enterKey',function(e){
				DoSearch($(this).val());
			});
			$('#txtSearch').keyup(function(e){
				if(e.keyCode == 13)
				{
				  $(this).trigger('enterKey');
				}
			});
 

			$('#btnSearch').on('click', function () {
				DoSearch($('#txtSearch').val());
			});
		</script>

		";      	
}


function detailtype_render_table
(
	$data
)
{
	echo '<thead>';
	echo '	<tr>';
	echo '		<th>#</th>';
	echo '		<th>Наименование</th>';
	echo '		<th>Ед.изм.</th>';
	echo '		<th>Комментарий</th>';
	echo '	</tr>';
	echo '</thead>';

	echo '<tbody>';

	if ( !empty( $data ) ) {
		foreach ( $data as $item ) {
			echo '<tr>';

			$inctive_state = 'glyphicon glyphicon-star-empty';

			if ( $item['inactive'] != 1 ) {
				$inctive_state = 'glyphicon glyphicon-star';
			}
			
			echo '	<th scope="row" class="col-md-2">'.$item['detailtypeid'];
			echo '		<button type="button" 
								class="btn btn-default pull-right btnDelete" 
								aria-label="Delete row" 
								data-placement="top" 
								title="Деактивировать" 
								data-detailtypeid="'.$item['detailtypeid'].'"
								data-detailtypename="'.$item['detailtypename'].'"
								data-inactive="'.$item['inactive'].'"
								data-measurementunitid="'.$item['measurementunitid'].'"
								data-comment="'.$item['detailtypecomment'].'"
								data-action="delete"
						>
				';
  			echo '			<span class="glyphicon '.$inctive_state.'" aria-hidden="true"></span>';
			echo '		</button>';				



			echo '		<button type="button" 
								class="btn btn-default pull-right" 
								aria-label="Edit row" 
								data-toggle="modal" 
								data-placement="top" 
								title="Редактировать" 
								data-target="#dlgEditDetailType"
								data-detailtypeid="'.$item['detailtypeid'].'"
								data-detailtypename="'.$item['detailtypename'].'"
								data-measurementunitid="'.$item['measurementunitid'].'"
								data-comment="'.$item['detailtypecomment'].'"
								data-action="edit"
						>
				';
  			echo '			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
			echo '		</button>';
			echo '	</th>';
			echo '	<td>'.$item['detailtypename'].'</td>';
			echo '	<td class="col-md-1">'.$item['measurementunitname'].'</td>';
			echo '	<td>'.$item['detailtypecomment'].'</td>';
			echo '</tr>';
		}
	}

    echo '</tbody>';
	echo "
		<script>
			$('.btnDelete').on('click', function () {
				var button = $(this);
				var id = button.data('detailtypeid');
				var next_inactive = !button.data('inactive');
				//alert( id );
				//alert( next_inactive );
		        $.ajax( { 
		            url: 'scripts/provider.php',
		            data: { action: 'detailTypeDelete', detailtypeid: id, inactive: next_inactive },
		            type: 'POST',
		            success: function( output ) {
		            			//alert ( output );
		                        location.reload();
		                    }
		        });
				event.preventDefault();
			});
		</script>

		";    
}


function detailtype_render_modal_edit
(
)
{
	echo '<div class="modal fade" id="dlgEditDetailType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	echo '<div class="modal-dialog">';
	echo '  <div class="modal-content">';
	echo '    <div class="modal-header">';
	echo '      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	echo '      <h4 class="modal-title" id="myModalLabel">Edit measurement data</h4>';
	echo '    </div>';
	echo '    <div class="modal-body">';
	echo '
			<div class="alert alert-danger col-sm-14 hidden" role="alert" id="pnlAlert">
				Наименование и единица измерения должны быть заполнены.
			</div>
		';
	echo '
				<form class="form-horizontal" id="frmEditDetailType">
				  
				  <div class="form-group pnlWithError" id="pnlWithError">
				    <label for="txtDetailTypeName" class="col-sm-3 control-label">Наименование</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="txtDetailTypeName">
				      <input type="hidden" class="form-control" id="txtDetailTypeId">
				      <input type="hidden" class="form-control" id="txtMeasurementUnitId">
				      <input type="hidden" class="form-control" id="txtAction">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="txtComment" class="col-sm-3 control-label">Комментарий</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="txtComment">
				    </div>
				  </div>
				  <div class="form-group pnlWithError">
				    <label for="selMeasurementUnit" class="col-sm-3 control-label">Ед.изм.</label>
				    <div class="col-sm-6">
						<select class="form-control" id="selMeasurementUnit">
	';

	echo '<option value="0"></option>';	

	$mu_content = measurementunit_view(null, null);		

	if ( !empty( $mu_content ) ) {
		foreach ( $mu_content as $mu_item ) {	
			echo '<option value="'.$mu_item['measurementunitid'].'">'.$mu_item['measurementunitname'].'</option>';	
		}
	}

	echo '						  
						</select>				    
				    </div>
				  </div>				  
				</form>
	';
	echo '    </div>';
	echo '
			<div class="modal-footer">
		      <button type="button" class="btn btn-success" autocomplete="off" id="btnSave">Сохранить</button>
		      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		';	
	echo '  </div>';
	echo '</div>';
	echo '</div>';

	echo "
		<script>
			$('#dlgEditDetailType').on('show.bs.modal', function (event) 
			{
				var button = $(event.relatedTarget);
				var name = button.data('detailtypename');
				var id = button.data('detailtypeid');
				var mu_id = button.data('measurementunitid');
				var comment = button.data('comment');
				var action = button.data('action');
				var modal = $(this);

				modal.find( '#txtAction' ).val ( action );

				switch ( action ) {
					case 'edit':
						modal.find( '#myModalLabel' ).text( 'Редактирование типа элемента' );
						modal.find( '#txtDetailTypeName' ).val( name );
						modal.find( '#txtDetailTypeId' ).val( id );
						modal.find( '#txtMeasurementUnitId' ).val( mu_id );
						modal.find( '#selMeasurementUnit [value=\'' + mu_id + '\']' ).attr( 'selected', 'selected' );
						modal.find( '#txtComment' ).val( comment );
						break;
					case 'new':
						modal.find( '#myModalLabel' ).text( 'Новый тип элемента' );
						modal.find( '#txtDetailTypeName' ).val( '' );
						modal.find( '#txtDetailTypeId' ).val( '' );
						modal.find( '#txtMeasurementUnitId' ).val( );
						modal.find( '#txtComment' ).val( );
						$('#selMeasurementUnit option:selected').each(function(){
							this.selected=false;
						});
						break;
					default:
						break;
				}

				$( '#pnlWithError' ).removeClass( 'has-error' );
				$( '#pnlAlert' ).addClass( 'hidden' );

				$( '#txtDetailTypeName' ).focus( );
			})
		</script>

		<script>
			function ValidateEdit( ) {
				var res = false;
				var name = $( '#txtDetailTypeName' ).val( );
				var mu_id = $( '#selMeasurementUnit  option:selected' ).val( );
				if ( name == '' || name == null || mu_id == 0 )
				{
					$( '.pnlWithError' ).addClass( 'has-error' );
					$( '#pnlAlert' ).removeClass( 'hidden' );
				}
				else
				{
					$( '.pnlWithError' ).removeClass( 'has-error' );
					$( '#pnlAlert' ).addClass( 'hidden' );
					res = true;
				}
				return res;
			};

			$( '#btnSave' ).on( 'click', function ( ) {
				$( '#frmEditDetailType' ).submit( );
			});
	
			$( '#frmEditDetailType' ).submit( function( event ) {
				if ( ValidateEdit( ) )
				{
					var mu_id = $( '#selMeasurementUnit  option:selected' ).val( );
					var id = $( '#txtDetailTypeId' ).val( );
					var name = $( '#txtDetailTypeName' ).val( );
					var dtcomment = $( '#txtComment' ).val( );
					var actionname = $( '#txtAction' ).val( );
					var ajaxactionname = '';

					switch ( actionname ) {
						case 'new':
							ajaxactionname = 'detailTypeInsert';
							break;
						case 'edit':
							ajaxactionname = 'detailTypeUpdate';
							break;							
					}

			        $.ajax({ 
			            url: 'scripts/provider.php',
			            data: { action: ajaxactionname, detailtypeid: id, detailtypename: name, comment: dtcomment, measurementunitid: mu_id },
			            type: 'POST',
			            success: function( output ) {
			            			//alert ( output );
			                        location.reload();
			                    }
			        });
				}
				event.preventDefault();
			});
		</script>

		";	
}

?>