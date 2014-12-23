<?php

include_once ( 'scripts/db.php' );

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

			$disabled_state = '';


			$allow_delete = measurementunit_allow_delete( $item['measurementunitid'] );
			

			if ( $allow_delete['cnt'] > 0 ) {
				$disabled_state = 'disabled="disabled"';
			}

			echo '	<th scope="row" class="col-md-2">'.$item['measurementunitid'];
			echo '		<button type="button" 
								class="btn btn-default pull-right" 
								aria-label="Delete row" 
								data-toggle="modal" 
								data-placement="top" 
								title="Delete row" 
								data-target="#dlgDeleteMeasurementUnit"
								data-measurementunitid="'.$item['measurementunitid'].'"
								data-measurementunitname="'.$item['measurementunitname'].'"
								data-action="delete"
								'.$disabled_state.'
						>
				';
  			echo '			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
			echo '		</button>';				



			echo '		<button type="button" 
								class="btn btn-default pull-right" 
								aria-label="Edit row" 
								data-toggle="modal" 
								data-placement="top" 
								title="Edit row" 
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

function measurementunit_render_modal_delete
(
)
{
	echo '<div class="modal fade" id="dlgDeleteMeasurementUnit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	echo '<div class="modal-dialog">';
	echo '  <div class="modal-content">';
	echo '    <div class="modal-header">';
	echo '      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	echo '      <h4 class="modal-title" id="myModalLabel">Delete measurement data</h4>';
	echo '    </div>';
	echo '    <div class="modal-body">';
	echo '
				<form class="form-horizontal" id="frmDeleteMeasurementUnit">
				  <div class="form-group">
				  	<div class="col-sm-5">
				    	<label>Are you sure delete this item?</label>
				    </div>	
				    <div class="col-sm-offset-2 col-sm-5">
				    	<input type="hidden" class="form-control" id="txtDeleteMeasurementUnitId">
				    	<label id="lblDeleteMeasurementUnitName"></label>
				    </div>
				  </div>
<!--				  
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-danger" id="btnDelete">Delete</button>
				      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				    </div>
				  </div>
-->				  
				</form>
	';
	echo '    </div>';
	echo '
			<div class="modal-footer">
		      <button type="button" class="btn btn-danger" autocomplete="off" id="btnDelete">Delete</button>
		      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		';
	echo '  </div>';
	echo '</div>';
	echo '</div>';
	
	/* Gathering info from event's recipient. */

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


/*
function createFolder(locationId, name, comment, isFolder)
{
    if (isFolder == 1) {
        $.ajax({ 
            url: 'scripts/provider.php',
            data: { action: 'folderCreate', location: locationId, filename: name, comment: comment, host: window.location.hostname},
            type: 'POST',
            success: function(output) {
                         location.reload();
                    }
        });
    }
    else {
        $.ajax({ 
            url: 'scripts/provider.php',
            data: { action: 'fileCreate', location: locationId, filename: name, comment: comment, host: window.location.hostname},
            type: 'POST',
            success: function(output) {
                         location.reload();
                    }
        });
    }
}	
*/
		
}

?>