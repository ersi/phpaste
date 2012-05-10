<?php
/*
* $ID PROJECT: Paste - index.php, v1 EcKstasy - 17/03/2010/06:29 GMT+1 (dd/mm/yy/time) 
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

// Includes
require_once('classes/config.inc.php');
require_once('classes/geshi/geshi.php');
require_once('classes/diff.php');
require_once('classes/paste.php');

// Magic quotes are anything but magic - lose them!
if (get_magic_quotes_gpc())
{
	function callback_stripslashes(&$val, $name) 
	{
		if (get_magic_quotes_gpc()) 
			$val=stripslashes($val);
	}


	if (count($_GET))
		array_walk ($_GET, 'callback_stripslashes');
	if (count($_POST))
		array_walk ($_POST, 'callback_stripslashes');
	if (count($_COOKIE))
		array_walk ($_COOKIE, 'callback_stripslashes');
}

// Create our pastebin object
$pastebin=new Pastebin($CONF);

/// Clean up older posts 
$pastebin->doGarbageCollection();

// Process new posting
$errors=array();
if (isset($_POST['paste']))
{	/* Process posting and redirect */
	$id=$pastebin->doPost($_POST);
	if ($id)
	{
		$pastebin->redirectToPost($id);
		exit;
	}
}

// Process downloads.
if (isset($_GET['dl'])) 
{
  global $errors;
   if (isset($_GET['pass']))
      $getPass = $_GET['pass'];
	$pid=intval($_GET['dl']);
   // If password protected, don't allow to download it.
   mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']) or die(mysql_error());
	$newPID = mysql_real_escape_string($pid);
	mysql_select_db($CONF['dbname']) or die(mysql_error());
	$result = mysql_query("SELECT * from paste where pid = " . $newPID);
   
   if ($result == FALSE) {
      echo "Paste $pid is not available.";
      exit;
   }
   
   $row = mysql_fetch_array($result);
	$pass = $row['password'];

   if ($pass == 'EMPTY') {
      $pastebin->doDownload($pid);
	  exit;
   }
   
   else if ($pass != $getPass) {}
   
   else {
      $pastebin->doDownload($pid);
	  exit;
   }
}

// If we get this far, we're going to be displaying some HTML, so let's kick off here.
$page=array();

// Figure out some nice defaults.
$page['current_format']=$CONF['default_highlighter'];
$page['expiry']=$CONF['default_expiry'];
$page['remember']='';

// Add list of recent posts.
$list=isset($_REQUEST["list"]) ? intval($_REQUEST["list"]) : 10;
$page['recent']=$pastebin->getRecentPosts($list);

// Show a post.
if (isset($_REQUEST["show"]))
{
	$pid=intval($_REQUEST['show']);
	// Get the post.
	$page['post']=$pastebin->getPaste($pid);
	// Ensure corrent format is selected.
	$page['current_format']=$page['post']['format'];
}
else
{
	$page['posttitle']='New posting';
}

if ($page['current_format']!='text')
{
	// Give the page a title which features the syntax used.
	$page['title']=$CONF['geshiformats'][$page['current_format']] . " - ".$CONF['title'];
}
else
{
	$page['title']=$CONF['title'];
}

// HTML page output.
include('templates/'.$CONF['template'].'/theme.php');