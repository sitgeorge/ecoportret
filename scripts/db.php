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

	if (!is_null($fileid))
	{
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
		
		if (!is_null($recordset))
		{
			while ( $data = $recordset->fetch_array() )
			{
				$result[] = $data;
			}

			//$result = $recordset->();

			$recordset->close();
		}
	}

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
	$createdby /*varchar(50)*/ 		/* client host name */,
	$docalc,
	$detailpriceid
) 
{
	global $dbref;

	opensql();

	$statement = $dbref->prepare ( 'CALL detail_insert (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)' );
	
	$statement->bind_param( 'iisssiidssii', $parentid, $fileid, $detailname, $detaildescription, 
					$detailgost, $amount, $measurementunitid, $amountmaterial, $comment, $createdby, $docalc, $detailpriceid );

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

	$statement->bind_param( 'isssiidss', $detailid, $detailname, $detaildescription, $detailgost, $amount, $measurementunitid, $amountmaterial, $comment, $updatedby );

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
	$fileid,
	$ancestorid /* int(10) */
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
/*
	echo "fileid ".$fileid;
	echo "ancestorid".$ancestorid;
*/
	if (is_null($ancestorid))
	{
/*

	!!!!!!!!!!!!!!!!!!!! Have to use this actual query !!!!!!!!!!!!!!!!!!!!!!!

select d.*, dt.detailtypename, dt.comment as detailtypecomment, mu.measurementunitid, mu.measurementunitname 
from detail d join detailtype dt on d.detailtypeid = dt.detailtypeid join measurementunit mu on dt.measurementunitid = mu.measurementunitid

*/

		$recordset = $dbref->query
		(
			'
				select 
				f2.detailid, 
				f2.fileid,
				case when f2.detailtypeid is null then f2.detailname else detailtype.detailtypename end as detailname,
				f2.detailtypeid,
				f2.detaildescription,
				f2.detailgost,
				f2.amount,
				f2.amountmaterial,
				f2.docalc,
				f2.comment,
				f2.sortorder,
				f2.created,
				f2.createdby,
				f2.updated,
				f2.updatedby,
				detailprice.detailpriceid,
				detailprice.pricevalue,
				detailtype.costtypeid,
				costtype.costtypeshortname,
				ftp2.ancestorid as `_parent`, ftp1.ancestorid,
				group_concat(distinct breadcrumb.ancestorid order by breadcrumb.level desc) as breadcrumbs,
				group_concat(distinct fcrumb.detailname order by breadcrumb.level desc separator "/") as breadcrumbsname                
				from detail as f1
					join detailtreepath as ftp1 on (ftp1.ancestorid = f1.detailid)
					join detail as f2 on (ftp1.descendantid = f2.detailid)
						left outer join detailtreepath AS ftp2 on (ftp2.descendantid = f2.detailid and ftp2.level = 1)
						join detailtreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
						inner join detail as fcrumb on breadcrumb.ancestorid = fcrumb.detailid
					left join detailtype on detailtype.detailtypeid = f2.detailtypeid
				    inner join costtype on costtype.costtypeid = detailtype.costtypeid
				    left join detailprice on f1.detailpriceid = detailprice.detailpriceid
				where f2.fileid = '.$fileid.'
				group by ftp1.descendantid
				order by breadcrumbsname
			'
		);
	}
	else
	{
		$recordset = $dbref->query
		(
			'
				select f2.*, ftp2.ancestorid as `_parent`, ftp1.ancestorid
				from detail as f1
					join detailtreepath as ftp1 on (ftp1.ancestorid = f1.detailid)
					join detail as f2 on (ftp1.descendantid = f2.detailid)
						left outer join detailtreepath AS ftp2 on (ftp2.descendantid = f2.detailid and ftp2.level = 1)
						join detailtreepath as breadcrumb on (ftp1.descendantid = breadcrumb.descendantid)
				        inner join detail as fcrumb on breadcrumb.ancestorid = fcrumb.detailid
				where dtp1.ancestorid = '.$ancestorid.' and d2.detailid <> '.$ancestorid.' and d2.fileid = '.$fileid.'
				group by dtp1.descendantid
				order by d2.sortorder asc, d2.detailname asc				
			'
		);
	}

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
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

/****************/
/* dictionaries */
/****************/

function measurementunit_view
(
	$measurementunitid,
	$avoidinactive
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
/*
	echo "fileid ".$fileid;
	echo "ancestorid".$ancestorid;
*/

	$where_clause = "";
	if ( !is_null( $avoidinactive ) )
	{
		$where_clause = " where inactive = 0 ";
	}


	if (is_null($measurementunitid))
	{
		$recordset = $dbref->query
		(
			'
				select * from measurementunit '.$where_clause.' order by measurementunitid
			'
		);
	}
	else
	{
		$recordset = $dbref->query
		(
			'
				select * from measurementunit where measurementunitid = '.$measurementunitid.' order by measurementunitid
			'
		);
	}

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
	closesql();
	return $result;		
}


function measurementunit_insert
(
	$measurementunitname /* varchar(50) */
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query('insert into measurementunit(measurementunitname) values(\''.$measurementunitname.'\')')) {
	    echo "There was an error during measurementunit_insert''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function measurementunit_delete
(
	$measurementunitid /* int(10) */,
	$inactive /* bit */
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query('update measurementunit set inactive = '.$inactive.' where measurementunitid='.$measurementunitid)) {
	    echo "There was an error during measurementunit_delete''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function measurementunit_update
(
	$measurementunitid /* int(10) */,
	$measurementunitname /* varchar(50) */
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query('update measurementunit set measurementunitname=\''.$measurementunitname.'\' where measurementunitid='.$measurementunitid)) {
	    echo "There was an error during measurementunit_update''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function measurementunit_allow_delete
(
	$measurementunitid /* int(10) */
)
{
	$res = 0;

	global $dbref;

	opensql();

	if (!$dbref->multi_query('select count(*) as cnt from detailtype where measurementunitid='.$measurementunitid)) {
	    echo "There was an error during measurementunit_allow_delete''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	do {
	    if ($res = $dbref->store_result()) {
	        $result = $res->fetch_assoc();
	        $res->free();
	    } else {
	        if ($dbref->errno) {
	            echo 'Cant gather results from measurementunit_allow_delete: (' . $dbref->errno . ') ' . $dbref->error;
	        }
	    }
	} while ($dbref->more_results() && $dbref->next_result());

	if ( $result['cnt'] > 0 ) {
		$res = 1;
	}

	closesql();
	return $res;	
}

function detailtype_view
(
	$searchstring,
	$usepagination,
	$pageno,
	$perpagecount
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;
/*
	echo "fileid ".$fileid;
	echo "ancestorid".$ancestorid;
*/
	if (is_null($searchstring))
	{
		if (is_null($usepagination))
		{
			$recordset = $dbref->query
			(
				'
					select 
						dt.detailtypeid, dt.detailtypename, dt.inactive, dt.comment as detailtypecomment, mu.measurementunitid, mu.measurementunitname,
					    dt.costtypeid, ct.costtypeshortname
					from 
						detailtype dt 
					    join measurementunit mu on dt.measurementunitid = mu.measurementunitid
					    join costtype ct on ct.costtypeid = dt.costtypeid
					order by 
						detailtypeid;
				'
			);
		}
/*		
		else
		{
			// Pagination

		}
*/		
	}
	else
	{
		$recordset = $dbref->query
		(
			'
				select 
					dt.detailtypeid, dt.detailtypename, dt.inactive, dt.comment as detailtypecomment, mu.measurementunitid, mu.measurementunitname,
				    dt.costtypeid, ct.costtypeshortname
				from 
					detailtype dt 
				    join measurementunit mu on dt.measurementunitid = mu.measurementunitid
				    join costtype ct on ct.costtypeid = dt.costtypeid
				where detailtypename like \'%'.$searchstring.'%\'
				order by 
					detailtypeid;
			'
		);
	}

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
	closesql();
	return $result;		
}

function detailtype_delete
(
	$detailtypeid /* int(10) */,
	$inactive /* bit */
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query('update detailtype set inactive = '.$inactive.' where detailtypeid='.$detailtypeid)) {
	    echo "There was an error during detailtype_delete''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function detailtype_update
(
	$detailtypeid /* int(10) */,
	$detailtypename /* varchar(50) */,
	$comment,
	$measurementunitid,
	$costtypeid
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query(
		'
			update detailtype 
				set detailtypename=\''.$detailtypename.'\',
					comment=\''.$comment.'\',
					measurementunitid='.$measurementunitid.',
					costtypeid = '.$costtypeid.'
			where detailtypeid='.$detailtypeid

		)) {
	    echo "There was an error during detailtypeid_update''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function detailtype_insert
(
	$detailtypename /* varchar(50) */,
	$comment,
	$measurementunitid,
	$costtypeid
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query(
			'
				insert into detailtype(detailtypename, comment, measurementunitid, costtypeid) 
				values(\''.$detailtypename.'\', \''.$comment.'\', '.$measurementunitid.', '.$costtypeid.')
			'
		)) {
	    echo "There was an error during detailtype_insert''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

/*

Выпадающий список "Тип" для формы редактирования detail

*/
function costtype_view
(
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;


	$recordset = $dbref->query
	(
		'
			select * from costtype order by costtypename
		'
	);

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
	closesql();
	return $result;		
}

/*

	Выпадающий список "Цена" для формы редактирования detail

*/
function detailprice_view
(
	$detailtypeid /* идентификатор из справочника */
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;

	if (is_null($detailtypeid))
	{
		$recordset = $dbref->query
		(
			'
				select detailprice.*, detailtype.detailtypename from detailprice left join detailtype on detailprice.detailtypeid = detailtype.detailtypeid order by valuedate desc
			'
		);
	}
	else
	{
		$recordset = $dbref->query
		(
			'
				select * from detailprice where detailtypeid = '.$detailtypeid.' order by valuedate desc
			'
		);		
	}

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
	closesql();
	return $result;		
}

/*
	Список строковых констант для поиска по наименованию при добавлении новой записи в detail
	Данные собираются из справочника detailtype и таблицы detail (уникальные)
	Выходной формат: 
	value - строка
	id - идентификатор записи в соответствующей таблице (detail или detailtype)
	isfromdetail - если 1 - то строка и id относятся к таблице detail, если 0 - то к detailtype
*/
function detail_detailtype_uniquenames_view
(
	$detailtypeid
)
{
	global $dbref;

	opensql();

	$recordset = null;
	$result = null;


	$recordset = $dbref->query
	(
		'
			select
				distinct detailname as value,
				detailid as id,
			    1 as isfromdetail
			from
				detail
			where 
				detailname is not null
			union
			select
				distinct detailtypename as value,
			    detailtypeid as id,
			    0 as isfromdetail
			from
				detailtype			

		'
	);

	if (!is_null($recordset))
	{
		/*echo $recordset->num_rows;*/
		while ( $data = $recordset->fetch_assoc() )
		{
			$result[] = $data;
		}

		//$result = $recordset->fetch_result();

		$recordset->close();
	}
	closesql();
	return $result;		
}


/*************************/
/* DETAIL PRICE functions*/
/*************************/

function detailprice_delete
(
	$detailpriceid /* int(10) */
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query('delete detailprice where detailpriceid='.$detailpriceid)) {
	    echo "There was an error during detailprice_delete''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function detailprice_update
(
	$detailpriceid,
	$shippernamename,
	$detailpricecause,
	$pricevalue,
	$valuedate
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query(
		'
			update detailprice 
				set shippernamename=\''.$shippernamename.'\',
					detailpricecause=\''.$detailpricecause.'\',
					pricevalue='.$pricevalue.',
					valuedate = '.$valuedate.'
			where detailpriceid='.$detailpriceid

		)) {
	    echo "There was an error during detailprice_update''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}

function detailprice_insert
(
	$detailtypeid /* int(10) */,
	$shippernamename,
	$detailpricecause,
	$pricevalue,
	$valuedate
)
{
	global $dbref;

	opensql();

	if (!$dbref->multi_query(
			'
				insert into detailprice ( shippernamename, detailpricecause, pricevalue, valuedate, detailtypeid ) 
				values(\''.$shippernamename.'\', \''.$detailpricecause.'\', '.$pricevalue.', '.$valuedate.', '.$detailtypeid.')
			'
		)) {
	    echo "There was an error during detailprice_insert''s call: (" . $dbref->errno . ") " . $dbref->error;
	}

	$result = 1;
	closesql();
	return $result;	
}
