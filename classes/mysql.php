<?php
/*
* $ID PROJECT: Paste - mysql.php, v1 EcKstasy - 17/03/2010/06:29 GMT+1 (dd/mm/yy/time) 
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 3
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*/
 
// Database handler
class DB
{
	var $dblink;
	var $dbresult;
	// Constructor - establishes DB connection
	function DB()
	{
		global $CONF;
		$this->dblink=mysql_pconnect(
			$CONF["dbhost"],
			$CONF["dbuser"],
			$CONF["dbpass"])
			or die("Unable to connect to database");
	
		mysql_select_db($CONF["dbname"], $this->dblink)
			or die("Unable to select database {$GLOBALS[dbname]}");
	}
	
    // How many pastes are in the database?
    function getPasteCount()
    {
    	$this->_query('select count(*) as cnt from paste');
    	return $this->_next_record() ? $this->_f('cnt') : 0;
    }
    
    // Delete oldest $deletecount pastes from the database.
    function trimDomainPastes($deletecount)
    {
    	// Build a one-shot statement to delete old pastes
		$sql='delete from paste where pid in (';
		$sep='';
		$this->_query("select * from paste order by posted asc limit $deletecount", $subdomain);
		while ($this->_next_record())
		{
			$sql.=$sep.$this->_f('pid');
			$sep=',';
		}
		$sql.=')';
		
		// Delete extra pastes.
		$this->_query($sql);	
    }
    
    // Delete all expired pastes.
    function deleteExpiredPastes()
    {
    	$this->_query("delete from paste where expires is not null and now() > expires");	
    }
    
    // Add paste and return ID.
    function addPost($poster,$format,$code,$parent_pid,$expiry_flag,$password)
    {
    	//figure out expiry time
    	switch ($expiry_flag)
    	{
    		case 'd':
    			$expires="DATE_ADD(NOW(), INTERVAL 1 DAY)";
    			break;
			case 'f':
				$expires="NULL";
				break;
			default:
    			$expires="DATE_ADD(NOW(), INTERVAL 1 MONTH)";
    			break;	
    	}
    	$this->_query('insert into paste (poster, posted, format, code, parent_pid, expires, expiry_flag, password) '.
				"values (?, now(), ?, ?, ?, $expires, ?, ?)",
				$poster,$format,$code,$parent_pid,$expiry_flag,$password);	
		$id=$this->_get_insert_id();	
		return $id;
    }
    
    // Return entire paste row for given ID.
    function getPaste($id)
    {
      $this->_query('select *,date_format(posted, \'%M %a %D %l:%i %p\') as postdate '.'from paste where pid=?', $id);
    	if ($this->_next_record())
    		return $this->row;
    	else
    		return false;
		
    }
    
    // Return summaries for $count posts ($count=0 means all)
    function getRecentPostSummary($count)
    {
    	$limit=$count?"limit $count":"";
    	
    	$posts=array();
    	$this->_query("select pid,poster,unix_timestamp()-unix_timestamp(posted) as age, ".
			"date_format(posted, '%a %D %b %H:%i') as postdate ".
			"from paste ".
			"order by posted desc, pid desc $limit");
		while ($this->_next_record())
		{
			$posts[]=$this->row;	
		}
		
		return $posts;
    }
    
    // Get follow up posts for a particular post
    function getFollowupPosts($pid, $limit=5)
    {
    	//any amendments?
		$childposts=array();
		$this->_query("select pid,poster,".
			"date_format(posted, '%a %D %b %H:%i') as postfmt ".
			"from paste where parent_pid=? ".
			"order by posted limit $limit", $pid);
		while ($this->_next_record())
		{
			$childposts[]=$this->row;
		}
		return $childposts;	
    }

    // Save formatted code for displaying.
    function saveFormatting($pid, $codefmt, $codecss)
    {
    	$this->_query("update paste set codefmt=?,codecss=? where pid=?",
    		$codefmt, $codecss, $pid);
	}
     
	// Execute query - should be regarded as private to insulate the rest ofthe application from sql differences.
	function _query($sql)
	{
		// Been passed more parameters? do some smart replacement.
		if (func_num_args() > 1)
		{
			// Query contains ? placeholders, but it's possible the
			// replacement string have ? in too, so we replace them in
			// our sql with something more unique
			$q=md5(uniqid(rand(), true));
			$sql=str_replace('?', $q, $sql);
			
			$args=func_get_args();
			for ($i=1; $i<=count($args); $i++)
			{
				$sql=preg_replace("/$q/", "'".preg_quote(mysql_real_escape_string($args[$i]))."'", $sql,1);
				
			}
			// We shouldn't have any $q left, but it will help debugging if we change them back!
			$sql=str_replace($q, '?', $sql);
		}
		
		$this->dbresult=mysql_query($sql, $this->dblink);
		if (!$this->dbresult)
		{
			die("Query failure: ".mysql_error()."<br />$sql");
		}
		return $this->dbresult;
	}
	
	// get next record after executing _query.
	function _next_record()
	{
		$this->row=mysql_fetch_array($this->dbresult);
		return $this->row!=FALSE;
	}
	
	// Get result column $field.
	function _f($field)
    {
    	return $this->row[$field];
    }
 
	// Get the last insertion ID.
	function _get_insert_id()
	{
		return mysql_insert_id($this->dblink);
	}
	
	// Get last error.
	function get_db_error()
	{
		return mysql_last_error();
    }
}
?>