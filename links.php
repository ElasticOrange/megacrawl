<?php

require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;


function checkPagination($stringToCheck)
{	
	sleep(2);
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('div.listing-pagination') as $elements)
	{
		foreach ($elements->find('a') as $element) {
			//return $element->href."\n";
            $newlink = checkUrl($element->href);
            if($newlink)
            {
                $links[$newlink] = true;
            }
            print_r($newlink);
		}
	}
}


$test = "http://www.emag.ro/televizoare/promotii/filter/smart-tv-f374,smart-tv-3d-v9406/p2/c";
echo checkPagination($test);




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


