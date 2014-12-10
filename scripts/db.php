<?php

include_once ( 'configuration.php' );


/* db constants */
/*
(1, 'detail', 1, 1, 1, 1, 1),
(2, 'ms-word', 0, 0, 1, 0, 1),
(3, 'ms-excel', 0, 0, 1, 0, 1),
(4, 'image', 0, 0, 1, 0, 1),
(5, 'dictionary', 1, 1, 1, 0, 1);
*/

class DBConstant {
	const filetype_detail 		= 1;
	const filetype_msword 		= 2;
	const filetype_msexcel 		= 3;
	const filetype_image 		= 4;
	const filetype_dictionary 	= 5;
}

/*
if ((require_once 'configuration.php') == 'OK' )
{
	echo 'OK';
}
*/

/* file object hierarchy*/

$dbref = null;

function opensql( )
{
	global $sqlservername;
	global $sqldbuser;
	global $sqldbpassword;
	global $sqldbname;
	global $dbref;

	$dbref = new mysqli( $sqlservername, $sqldbuser, $sqldbpassword, $sqldbname );
	if( $dbref->connect_errno )
	    die( 'DB connection error: '.$dbref->connect_error );
}

function closesql( )
{
	global $dbref;

	if ( $dbref )
		$dbref->close();
}

/*

Insert an new entry below a parent (by id)
Returns an entry's id

*/

function file_insert
(
	$parentid /*int(10)*/, 			/* should have null or 0 value for upper level */
	$filename /*varchar(100)*/, 
	$filetypeid /*int(10)*/, 		/* the entry's type. null if $isfolder = 1 */
	$isfolder /* bit */, 			/* the entry is folder */
	$isprotected /* bit */,			/* the entry is protected (client can't delete entry). for dictionaries */
	$comment /*varchar(1000)*/,
	$createdby /*varchar(50)*/ 		/* client host name */
) 
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL file_insert (?, ?, ?, ?, ?, ?, ?)' );
	
	$statement->bind_param( 'isiiiss', $parentid, $filename, $filetypeid, $isfolder, $isprotected, $comment, $createdby );

	$statement->execute();
	$statement->bind_result($result);
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Delete an entry by id (all nested entries will be deleted too).
Returns row's count

*/

function file_delete
(
	$fileid /* int(10) */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL file_delete (?)' );
	
	$statement->bind_param('i', $fileid);

	$statement->execute();
	$statement->bind_result($result);
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Update entry's name and comment. There are restrictions that belongs different entry's types.
Returns id of updated entry.

*/

function file_update
(
	$fileid,
	$filename /*varchar(100)*/,
	$comment /*varchar(1000)*/,
	$updatedby /*varchar(50)*/ 	/* client host name */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL file_update (?, ?, ?, ?)' );
	
	$statement->bind_param( 'isss', $fileid, $filename, $comment, $updatedby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Move an entry (with nested siblings) to another parent.
Returns count of moved entries.

*/

function file_move
(
	$fileid,
	$dest_ancestorid /* int(10) */,
	$createdby /*varchar(50)*/ 		/* client host name */
)
{
	global $dbref;

	opensql();

	if ($dest_ancestorid == '' || is_null($dest_ancestorid)) $dest_ancestorid = 'null';
/*
	echo 'CALL file_copy ('.$fileid.', '.$dest_ancestorid.', \''.$createdby.'\')';
	return;
*/
	if (!$dbref->multi_query('CALL file_move ('.$fileid.', '.$dest_ancestorid.', \''.$createdby.'\')')) {
	    echo "There was an error during file_move''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	do {
	    if ($res = $dbref->store_result()) {
	        $result = $res->fetch_all();
	        $res->free();
	    } else {
	        if ($dbref->errno) {
	            echo 'Cant gather results from file_move: (' . $dbref->errno . ') ' . $dbref->error;
	        }
	    }
	} while ($dbref->more_results() && $dbref->next_result());

	$result = 1;
	closesql();
	return $result;	

/*
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL file_move (?, ?, ?)' );
	
	$statement->bind_param( 'iis', $fileid, $dest_ancestorid, $createdby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;	
*/	
}

/*

Copy an entry (with nested siblings) to another parent.
Returns count of moved entries.

*/

function file_copy
(
	$fileid,
	$dest_ancestorid /* int(10) */,
	$createdby /*varchar(50)*/ 		/* client host name */
)
{
	global $dbref;

	opensql();

	if ($dest_ancestorid == '' || is_null($dest_ancestorid)) $dest_ancestorid = 'null';
/*
	echo 'CALL file_copy ('.$fileid.', '.$dest_ancestorid.', \''.$createdby.'\')';
	return;
*/
	if (!$dbref->multi_query('CALL file_copy ('.$fileid.', '.$dest_ancestorid.', \''.$createdby.'\')')) {
	    echo "There was an error during file_copy''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	do {
	    if ($res = $dbref->store_result()) {
	        $result = $res->fetch_all();
	        $res->free();
	    } else {
	        if ($dbref->errno) {
	            echo 'Cant gather results from file_copy: (' . $dbref->errno . ') ' . $dbref->error;
	        }
	    }
	} while ($dbref->more_results() && $dbref->next_result());


	/*if ($dest_ancestorid == 0 ) $dest_ancestorid = null;*/
/*
	$statement = $dbref->prepare ( 'CALL file_copy (?, ?, ?)' );
	$statement->bind_param( 'iis', $fileid, $dest_ancestorid, $createdby );

	$statement->execute();

	$res = $statement->get_result();
	$res->fetch_all();
	
	$statement->bind_result( $result );
	$statement->fetch();
	
	$statement->close();
*/

	$result = 1;
	closesql();
	return $result;	
}

/*

Flat view. Fetch nested siblings of level = 1. 

*/

/*

	TODO: !!! Sort order !!!

*/

function file_flat_view
(
	$ancestorid /* int(10) */
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
	if (is_null($ancestorid))
	{
		$recordset = $dbref->query
		(
			'select t.fileid, t.filename, t.filetypeid, t.isfolder, t.sortorder, t.isprotected, t.comment, t.created,
				t.createdby, 
				case when t.updated is null then t.created else t.updated end as updated, 
				case when t.updatedby is null then t.createdby else t.updatedby end as updatedby,
				ft.*			
			from filetreepath as c1
			join file t on t.fileid = c1.descendantid
			left outer join filetype as ft on t.filetypeid = ft.filetypeid 
			where t.fileid not in 
			(
			select t.fileid
			from filetreepath as c1
			join file t on t.fileid = c1.descendantid and c1.level > 0
			)
			order by t.isfolder desc, t.filename asc'
		);
	}
	else
	{
		$recordset = $dbref->query
		(
			'select t.fileid, t.filename, t.filetypeid, t.isfolder, t.sortorder, t.isprotected, t.comment, t.created,
				t.createdby, 
				case when t.updated is null then t.created else t.updated end as updated, 
				case when t.updatedby is null then t.createdby else t.updatedby end as updatedby,
				ft.*
			from
			filetreepath as c1 join file t on t.fileid = c1.descendantid 
			left outer join filetype as ft on t.filetypeid = ft.filetypeid
			where c1.ancestorid = '.$ancestorid.' and c1.level = 1
			order by t.isfolder desc, t.filename asc'
		);
	}

	while ( $data = $recordset->fetch_assoc() )
	{
		$result[] = $data;
	}

	//$result = $recordset->fetch_result();

	$recordset->close();

	closesql();
	return $result;	
}


function file_get_breadcrumbs
(
	$fileid
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
	$recordset = $dbref->query
		(
			'select group_concat(distinct breadcrumb.ancestorid order by breadcrumb.level desc) as breadcrumbs,
			  group_concat(distinct fcrumb.filename order by breadcrumb.level desc separator "/") as breadcrumbsname
			from file as f1
				join filetreepath as ftp1 on (ftp1.ancestorid = f1.fileid)
				join file as f2 on (ftp1.descendantid = f2.fileid)
					left outer join filetreepath AS ftp2 on (ftp2.descendantid = f2.fileid and ftp2.level = 1)
					join filetreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
			        inner join file as fcrumb on breadcrumb.ancestorid = fcrumb.fileid
			where f2.fileid = '.$fileid.'
			group by ftp1.descendantid
			order by breadcrumbs'
		);
			
	while ( $data = $recordset->fetch_assoc() )
	{
		$result[] = $data;
	}

	//$result = $recordset->fetch_result();

	$recordset->close();

	closesql();
	return $result;
}

/*

Insert an new entry below a parent (by id)
Returns an entry's id

*/

function detail_insert
(
	$parentid /*int(10)*/, 			/* should have null or 0 value for upper level */
	$fileid,
	$detailname /*varchar(2000)*/, 
	$detaildescription /*varchar(255)*/,
	$detailgost /*varchar(255)*/,
	$amount /*long*/,
	$measurementunitid,
	$amountmaterial /*float*/,
	$comment /*varchar(1000)*/,
	$createdby /*varchar(50)*/ 		/* client host name */
) 
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_insert (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)' );
	
	$statement->bind_param( 'iisssiidss', $parentid, $fileid, $detailname, $detaildescription, $detailgost, $amount, $measurementunitid, $amountmaterial, $comment, $createdby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Delete an entry by id (all nested entries will be deleted too).
Returns row's count

*/

function detail_delete
(
	$detailid /* int(10) */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_delete (?)' );
	
	$statement->bind_param('i', $detailid);

	$statement->execute();
	$statement->bind_result($result);
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Update entry's name and comment. There are restrictions that belongs different entry's types.
Returns id of updated entry.

*/

function detail_update
(
	$detailid,
	$detailname /*varchar(2000)*/,
	$detaildescription /*varchar(255)*/,
	$detailgost /*varchar(255)*/,
	$amount /*long*/,
	$measurementunitid,
	$amountmaterial /*float*/,
	$comment /*varchar(1000)*/,
	$updatedby /*varchar(50)*/ 	/* client host name */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_update (?, ?, ?, ?, ?, ?, ?, ?, ?' );
	
	$statement->bind_param( 'isssiidss', $detailid, $detailname, $detaildescription, $detailgost, $amount, $measurementunitid, $amountmaterial, $comment, $createdby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;
}

/*

Move an entry (with nested siblings) to another parent.
Returns count of moved entries.

*/

function detail_move
(
	$detailid,
	$dest_ancestorid /* int(10) */,
	$createdby /*varchar(50)*/ 		/* client host name */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_move (?, ?, ?)' );
	
	$statement->bind_param( 'iis', $detailid, $dest_ancestorid, $createdby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;	
}

/*

Copy an entry (with nested siblings) to another parent.
Returns count of moved entries.

*/

function detail_copy
(
	$detailid,
	$dest_ancestorid /* int(10) */,
	$createdby /*varchar(50)*/ 		/* client host name */
)
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_copy (?, ?, ?)' );
	$statement->bind_param( 'iis', $detailid, $dest_ancestorid, $createdby );

	$statement->execute();
	$statement->bind_result( $result );
	$statement->fetch();
	$statement->close();

	closesql();
	return $result;	
}

/*
select f2.*, ftp2.ancestorid as `_parent`, ftp1.ancestorid,
  group_concat(distinct breadcrumb.ancestorid order by breadcrumb.level desc) as breadcrumbs,
  group_concat(distinct fcrumb.filename order by breadcrumb.level desc separator '/') as breadcrumbsname
from file as f1
	join filetreepath as ftp1 on (ftp1.ancestorid = f1.fileid)
	join file as f2 on (ftp1.descendantid = f2.fileid)
		left outer join filetreepath as ftp2 on (ftp2.descendantid = f2.fileid and ftp2.level = 1)
		join filetreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
        inner join file as fcrumb on breadcrumb.ancestorid = fcrumb.fileid
where ftp2.ancestorid is null
group by ftp1.descendantid
order by f2.isfolder desc, f2.filename asc;
*/

function detail_view
(
	$ancestorid /* int(10) */
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
	if (is_null($ancestorid))
	{
		$recordset = $dbref->query
		(
			'
				select f2.*, ftp2.ancestorid as `_parent`, ftp1.ancestorid,
				  group_concat(distinct breadcrumb.ancestorid order by breadcrumb.level desc) as breadcrumbs,
				  group_concat(distinct fcrumb.filename order by breadcrumb.level desc separator '/') as breadcrumbsname
				from file as f1
					join filetreepath as ftp1 on (ftp1.ancestorid = f1.fileid)
					join file as f2 on (ftp1.descendantid = f2.fileid)
						left outer join filetreepath as ftp2 on (ftp2.descendantid = f2.fileid and ftp2.level = 1)
						join filetreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
				        inner join file as fcrumb on breadcrumb.ancestorid = fcrumb.fileid
				where ftp2.ancestorid is null
				group by ftp1.descendantid
				order by f2.isfolder desc, f2.filename asc
			'
		);
	}
	else
	{
		$recordset = $dbref->query
		(
			'
				select f2.*, ftp2.ancestorid as `_parent`, ftp1.ancestorid,
				  group_concat(distinct breadcrumb.ancestorid order by breadcrumb.level desc) as breadcrumbs,
				  group_concat(distinct fcrumb.filename order by breadcrumb.level desc separator '/') as breadcrumbsname
				from file as f1
					join filetreepath as ftp1 on (ftp1.ancestorid = f1.fileid)
					join file as f2 on (ftp1.descendantid = f2.fileid)
						left outer join filetreepath as ftp2 on (ftp2.descendantid = f2.fileid and ftp2.level = 1)
						join filetreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
				        inner join file as fcrumb on breadcrumb.ancestorid = fcrumb.fileid
				where ftp1.ancestorid = '.$ancestorid.' and f2.fileid <> '.$ancestorid.'
				group by ftp1.descendantid
				order by f2.isfolder desc, f2.filename asc
			'
		);
	}

	while ( $data = $recordset->fetch_assoc() )
	{
		$result[] = $data;
	}

	//$result = $recordset->fetch_result();

	$recordset->close();

	closesql();
	return $result;	
}

/*
	Returns filetypeid by specified ext name.
*/

function filetype_getid_by_extname
(
	$fileextname /* varchar(10) */
)
{
	global $dbref;

	opensql();

	/*$recordset = null;*/

	$result = null;

	/*echo 'select filetype_getid_by_extname(\''.$fileextname.'\')';*/

		$recordset = $dbref->query
			(
			'	
					select filetype_getid_by_extname(\''.$fileextname.'\')
			'
		);

	while ( $data = $recordset->fetch_array() )
	{
		$result[] = $data;
	}

	$recordset->close();

	closesql();

	return $result;	
}	