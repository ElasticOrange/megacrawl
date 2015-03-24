<?php
require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$tests = 
[
	'http://www.emag.ro/petshop/l',
	'http://www.emag.ro/laptopuri-accesorii/l',
];

foreach ($tests as $test) {
	# code...
	print_r(checkCategory($test));
}

//print_r(checkCategory('http://www.emag.ro/petshop/l'));

function checkCategory($stringToCheck)
{	
	sleep(5);
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('span.category-sidebar') as $elements)
	{
		foreach ($elements->find('a') as $element) 
		{
            $newlink = checkUrl($element->href);
            if($newlink)
            {
                $links[$newlink] = true;
            }
		}
        //print_r($newlink)."\n";
	}
	return $links;
}


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