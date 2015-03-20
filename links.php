<?php

require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

/*
function checkPagination($stringToCheck)
{	
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('div#products-holder') as $elements)
	{
		foreach ($elements->find('a') as $element) 
			{
				echo $element->href."\n";
			}
	}
}
*/

// $test = "http://www.emag.ro/televizoare-accesorii/l";
// if (checkPagination($test) == 0) 
// {
// 	echo "nu are paginatie";
// 	# code...
// }

$test = [
	  "1" => "soundbar-curbat-samsung-hw-h7500-320w-subwoofer-wireless-bluetooth-negru-hw-h7500-en/pd/D5KS6BBBM/?ref=prod-widget_3_7_9&recid=HSTR"
	, "3" => "/oglinda-cosmetica-iluminata-laica-md6051/pd/DFS3GBBBM/?ref=prod-widget_3_7_10&recid=HSTR"
	, "5" => "https://www.emag.ro/telefon-mobil-allview-dual-sim-black-p7-xtreme/pd/DZBXCBBBM/?ref=prod-widget_3_7_11&recid=HSTR"
	, "7" => "http://gica.ro/trusa-de-bigudiuri-electrice-remington-20-bigudiuri-catifea-kf-20i/pd/E99L7BBBM/?ref=prod-widget_3_7_12&recid=HSTR"
	, "8" => "http://www.emag.ro/laptopuri/c"
	, "9" => "javascript"
	, "10" => "www.microsoft.com"
	, "11" => "www.google.ro"
	, "12" => "https://www.microsoft.ro"
	, "13" => "https://microsoft.com"
	, "14" => "mozilla"

];
foreach ($test as $key => $value) {
	# code...
	echo checkUrl($value)."\n";
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

// foreach ($test as $key => $link) 
// {
// 	checkPagination($link);
// }

/*
// Create DOM from URL
$html = file_get_html('http://www.emag.ro');

// Find all article blocks
foreach($html->find('div.article') as $article) {
    $item['title']     = $article->find('div.title', 0)->plaintext;
    $item['intro']    = $article->find('div.intro', 0)->plaintext;
    $item['details'] = $article->find('div.details', 0)->plaintext;
    $articles[] = $item;
}

print_r($articles);

$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('a') as $element)
{
	//echo ($element->href."\n");
	$links = [ $element->href];
	//var_dump($links);
	foreach ($links as $link) 
	{
	}
	
}	
		$link = "http://www.emag.ro/laptopuri-accesorii/l?ref=menu_link_1_2";
		$html = HtmlDomParser::file_get_html($link);
		foreach($html->find('a') as $element)
		{
			echo ($element->href."\n");
			$links = [ $element->href];
			var_dump($links);
		}
		foreach ($html->find('id') as $pagina) 
		{
			//$item['details'] = $article->find('id.products-holder', 0)->plaintext;
			// $pagina[] = $item;
			$pagina_produse['details'] = $pagina->find('id.products-holder', 0)->plaintext;
			$pagini[] = $pagina_produse;
			var_dump($pagini);
		}
*/