<?php

include_once ( 'db.php' );


// file insert
$id_1 = file_insert ( null, 'test_folder_1', null, 1, 0, 'test_comment_1', 'gbsnix' ); echo "\r\n";
$sub_id_1_1 = file_insert ( $id_1, 'test_folder_1_1', null, 1, 0, 'test_comment_1_1', 'gbsnix' ); echo "\r\n";

$id_2 = file_insert ( null, 'test_folder_2', null, 1, 0, 'test_comment_2', 'gbsnix' ); echo "\r\n";
$sub_id_2_1 = file_insert ( $id_2, 'test_folder_2_1', null, 1, 0, 'test_comment_2_1', 'gbsnix' ); echo "\r\n";

echo '!!!!!!!!!!!!!!! *********************** AFTER FILE_INSERT';
echo "<pre>";
var_dump(file_flat_view($id_1)); echo "\r\n";
echo "</pre>";
echo "<pre>";
var_dump(file_flat_view($id_2)); echo "\r\n";
echo "</pre>";



//file update
echo file_update( $sub_id_1_1, 'test_folder_1_1_a', 'test_comment_1_1_a', 'gbsnix' ); echo "\r\n";

echo '!!!!!!!!!!!!!!! *********************** AFTER FILE_UPDATE';
echo "<pre>";
var_dump(file_flat_view($id_1)); echo "\r\n";
echo "</pre>";
echo "<pre>";
var_dump(file_flat_view($id_2)); echo "\r\n";
echo "</pre>";



// file copy

echo 'Copy '.$sub_id_2_1.' under '.$sub_id_1_1;

echo file_copy($sub_id_2_1, $sub_id_1_1, 'gbsnix');

echo '!!!!!!!!!!!!!!! *********************** AFTER FILE_COPY';
echo "<pre>";
var_dump(file_flat_view($sub_id_1_1)); echo "\r\n";
echo "</pre>";

//echo "<pre>";
//var_dump(file_flat_view($id_2)); echo "\r\n";
//echo "</pre>";



// file move

echo 'Move '.$sub_id_1_1.' under '.$sub_id_2_1;

echo file_move($sub_id_1_1, $sub_id_2_1, 'gbsnix');

echo '!!!!!!!!!!!!!!! *********************** AFTER FILE_MOVE';
echo "<pre>";
var_dump(file_flat_view($sub_id_2_1)); echo "\r\n";
echo "</pre>";

//echo "<pre>";
//var_dump(file_flat_view($id_2)); echo "\r\n";
//echo "</pre>";

// file delete

/*
echo file_delete($id_1);

echo '!!!!!!!!!!!!!!! *********************** AFTER FILE_DELETE';
echo "<pre>";
var_dump(file_flat_view($id_1)); echo "\r\n";
echo "</pre>";
*/