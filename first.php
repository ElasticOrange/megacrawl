<?php
require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$tests = 
[
	'http://www.emag.ro/petshop/l',
	'http://www.emag.ro/laptopuri-accesorii/l',
];

// foreach ($tests as $test) {
// 	# code...
// 	checkCategory($test);
// 	print_r($test);
// }

print_r(checkCategory('http://www.emag.ro/petshop/l'));

function checkCategory($stringToCheck)
{	
	sleep(5);
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('span.category-sidebar') as $elements)
	{
		foreach ($elements->find('a') as $element) 
		{
            $newlink = ($element->href);
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

	$link = substr($link, 0, strpos($link, '?'));
	if((substr($link, 0, 18) == "http://www.emag.ro")) 
	{
	   return $link;
	}
	else if((substr($link, 0, 18) !== "http://www.emag.ro"))
	{
		if
			(
			   (substr($link, 0, 7) === "http://")
			|| (strpos($link, 'javascript') !== false) 
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