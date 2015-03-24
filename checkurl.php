<?php
//require 'init.php';
// use Sunra\PhpSimple\HtmlDomParser;

// $dom = HtmlDomParser::file_get_html( "http://emag.ro" );
// foreach($dom->find('nav#emg-mega-menu') as $elements)
// {
// 	foreach ($elements->find('a') as $element) 
// 	{
//         $newlink = ($element->href);
//         if($newlink)
//         {
//             $links[$newlink] = true;
//             echo $newlink."\n";
//         }
//     }
// }


$test2 = [
		  "javascript:void(0)"
		, "http://emag.ro/atletism--alergare/nike/promotii/c?ref=menu_link_1308_9"
		, "mers/converse/c?ref=menu_link_1308_9"
		, "/scutece-servetele/promotii/c?ref=menu_link_1308_9"
		, "/jucarii-jocuri-educative/promotii/c?ref=menu_link_1308_9"
		, "/petshop/l?ref=menu_banner_1308_11"
		, "/telefoane-mobile/c?ref=menu_banner_1308_12"
		, "javascript:void(0)"
		, "/laptopuri-accesorii/l?ref=menu_link_1_2"
		, "/genti/c?ref=menu_link_1_5"
		, "http://www.emag.ro/petshop/l"
		];

$lungime = count($test2);
foreach ($test2 as $key => $value) {
	$newline = checkUrl($value);
	if ($newline) {
		$links[$newline] = true;
	echo $newline."\n";
	}
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