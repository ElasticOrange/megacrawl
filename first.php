<?php
require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('a') as $element)
{
	$newlink = checkUrl($element->href);
	if($newlink)
	{
		$links[$newlink] = true;
	}
}


foreach ($links as $key => $link) 
{
	echo checkPagination($key);
	//var_dump(checkPagination($key));
	//exit;
}


function checkPagination($stringToCheck)
{	
	sleep(3);

	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('div.listing-pagination') as $elements)
	{
		foreach ($elements->find('a') as $element) {
            $newlink = checkUrl($element->href);
            if($newlink)
            {
                $links[$newlink] = true;
                echo $newlink."\n";
            }
		}
	}
}


function checkUrl($link)
{
	if((substr($link, 0, 18) == "http://www.emag.ro")) 
	{
	   return $link;
	}
	else if((substr($link, 0, 18) !== "http://www.emag.ro"))
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