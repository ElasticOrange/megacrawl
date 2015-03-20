<?php
require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('a') as $element)
{
	//echo ($element->href."\n");
	$links = checkUrl($element->href);
	print_r($links);
}


function checkUrl($link)
{
	if(substr($link, 0, 18) == "http://www.emag.ro") 
	{
	   return $link;
	}
	else if(substr($link, 0, 18) !== "http://www.emag.ro")
	{
		if(substr($link, 0, 1) == "/")
		{
			return ("http://www.emag.ro".$link);
		}
		else
		{
			return ("http://www.emag.ro/".$link);
		}
	}
}
