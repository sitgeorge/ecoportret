<?php
	
include_once ( 'db.php' );

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'fileMove' : 
            $destination = $_POST['destination'];
            if ($destination == "")
                $destination = null;
            $host = $_POST['host'];
            $fileIds = $_POST['fileIds'];
            $filesArray = explode(",", $fileIds);
            for ($i = 0; $i < count($filesArray); $i++){
                file_move($filesArray[$i], $destination, $host);
            }
            break;
        case 'POSTFolderContent' : 
        	$result = file_flat_view(Null);
        	echo "<pre>";
        	var_dump($result); 
        	echo "</pre>";
        	break;
        case 'fileCopy' : 
            $destination = $_POST['destination'];
            if ($destination == ""){
                $destination = null;
            }
            $host = $_POST['host'];
            $fileIds = $_POST['fileIds'];
            $filesArray = explode(",", $fileIds);
            for ($i =0; $i < count($filesArray); $i++){
                file_copy($filesArray[$i], $destination, $host);
            }
            break;
        case 'fileDelete' : 
            $fileIds = $_POST['fileIds'];
            $filesArray = explode(",", $fileIds);
            for ($i =0; $i < count($filesArray); $i++){
                file_delete($filesArray[$i]);
            }
            break;
        case 'fileEdit' : 
            $fileid = $_POST['fileid'];
            $filename = $_POST['filename'];
            $comment = $_POST['comment'];
            $host = $_POST['host'];
            file_update($fileid, $filename, $comment, $host);
            break;
        case 'fileCreate' : 
            $parentid = $_POST['location'];
            $filename = $_POST['filename'];
            $filetypeid = 1;
            $isfolder = 0;
            $isprotected = 1;
            $comment = $_POST['comment'];
            $host = $_POST['host'];
            file_insert($parentid, $filename, $filetypeid, $isfolder, $isprotected, $comment, $host);
            break;
        case 'folderCreate' : 
            $parentid = $_POST['location'];
            $filename = $_POST['filename'];
            $filetypeid = Null;
            $isfolder = 1;
            $isprotected = 0;
            $comment = $_POST['comment'];
            $host = $_POST['host'];
            file_insert($parentid, $filename, $filetypeid, $isfolder, $isprotected, $comment, $host);
            break;
        /*  D I C T I O N A R I E S */

        /* Measurement Unit */

        case 'measurementUnitInsert':
            $measurementunitname = $_POST['measurementunitname'];
            measurementunit_insert($measurementunitname);
            break;
        case 'measurementUnitDelete':
            $measurementunitid = $_POST['measurementunitid'];
            $inactive = $_POST['inactive'];
            measurementunit_delete($measurementunitid, $inactive);
            break;            
        case 'measurementUnitUpdate':
            $measurementunitid = $_POST['measurementunitid'];
            $measurementunitname = $_POST['measurementunitname'];
            measurementunit_update( $measurementunitid, $measurementunitname );
            break;            

        /* Detail Type */

        case 'detailTypeDelete':
            $detailtypeid = $_POST['detailtypeid'];
            $inactive = $_POST['inactive'];
            detailtype_delete($detailtypeid, $inactive);
            break;
        case 'detailTypeUpdate':
            $detailtypeid = $_POST['detailtypeid'];
            $measurementunitid = $_POST['measurementunitid'];
            $detailtypename = $_POST['detailtypename'];
            $comment = $_POST['comment'];
            detailtype_update( $detailtypeid, $detailtypename, $comment, $measurementunitid );
            break;
        case 'detailTypeInsert':
            $measurementunitid = $_POST['measurementunitid'];
            $detailtypename = $_POST['detailtypename'];
            $comment = $_POST['comment'];
            detailtype_insert( $detailtypename, $comment, $measurementunitid );
            break;
    }
}
?>