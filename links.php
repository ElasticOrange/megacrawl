<?php

require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

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

$test = "http://www.emag.ro/cabluri-adaptoare/c";
checkPagination($test);

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