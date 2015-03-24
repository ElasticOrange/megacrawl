<?php
require 'vendor/autoload.php';
require 'db.php';

use Simplon\Mysql\Mysql;
use Sunra\PhpSimple\HtmlDomParser;

//time for sleep
$t = 5;

$dbConn = new Mysql(
	$config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

$sqlManager = new \Simplon\Mysql\Manager\SqlManager($dbConn);

function checkUrl($link)
{
	if((substr($link, 0, 18) == "http://www.emag.ro")) 
	{
	   return $link;
	}
	else if(substr($link, 0, 14) == "http://emag.ro")
	{
		return $link;
	}
	else if((substr($link, 0, 18) !== "http://www.emag.ro") || (substr($link, 0, 18) !== "http://emag.ro"))
	{
		if(
			   (substr($link, 0, 10) === "javascript") 
			|| (substr($link, 0, 7) === "http://")
			|| (strpos($link, 'microsoft') !== false) 
			|| (strpos($link, 'google') !== false) 
			|| (strpos($link, 'mozilla') !== false)
			|| (strpos($link, 'https') !== false) 
				)
		{
			return false;
		}
		else if(substr($link, 0, 1) == "/")
		{
			return ("http://www.emag.ro".$link);
		}
		else
		{
			return ("http://www.emag.ro/".$link);
		}
	}
}