<?php
require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('a') as $element)
{
	//echo ($element->href."\n");
	$links[] = checkUrl($element->href);
}
	//print_r($links);
	foreach ($links as $key => $link) 
	{
		checkPagination($link);
		//var_dump($link);
	}


function checkUrl($link)
{
	if((substr($link, 0, 18) == "http://www.emag.ro") || (substr($link, 0, 19) == "https://www.emag.ro")) 
	{
	   return $link;
	}
	else if((substr($link, 0, 18) !== "http://www.emag.ro") || (substr($link, 0, 19) !== "https://www.emag.ro"))
	{
		if(
			   (substr($link, 0, 10) === "javascript") 
			|| (substr($link, 0, 7) === "http://")
			|| (strpos($link, 'microsoft') !== false) 
			|| (strpos($link, 'google') !== false) 
			|| (strpos($link, 'mozilla') !== false) 
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

function checkPagination($stringToCheck)
{	
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('div#products-holder') as $elements)
	{
		foreach ($elements->find('a') as $element) {
			echo $element->href."\n";
		}
	}
}