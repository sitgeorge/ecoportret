<?php

function measurementunit_render
(
	$data
)
{
	echo '<thead>';
	echo '	<tr>';
	//echo '		<th></th>';
	echo '		<th>#</th>';
	echo '		<th>Name</th>';
	echo '	</tr>';
	echo '</thead>';

	echo '<tbody>';

	if ( !empty( $data ) ) {
		foreach ( $data as $item ) {
			echo '<tr>';
			echo '	<th scope="row" class="col-md-2">'.$item['measurementunitid'];
			echo '		<button type="button" class="btn btn-default pull-right" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="Edit row">';
  			echo '			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
			echo '		</button>';				
			echo '		<button type="button" class="btn btn-default pull-right" aria-label="Left Align" data-toggle="tooltip" data-placement="top" title="Delete row">';
  			echo '			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
			echo '		</button>';
			echo '	</th>';
			echo '	<td>'.$item['measurementunitname'].'</td>';
			echo '</tr>';
		}
	}

    echo '</tbody>';
}

?>