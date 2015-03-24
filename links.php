<?php

require 'vendor/autoload.php';
require 'init.php';
use Sunra\PhpSimple\HtmlDomParser;
use GuzzleHttp\Client;

//$linkToCheck = 'http://www.emag.ro/carti/promotii/filter/gen-f1195,beletristica-v-314847/c';


function checkPagination($stringToCheck)
{	
	sleep($t);

	// $client = new Client();
	// $response = $client->get($stringToCheck);
	// $body = $response->getBody();
	//echo strlen($body);
	$dom = HtmlDomParser::file_get_html($stringToCheck);
	//var_dump($dom);
	foreach($dom->find('div.listing-pagination') as $elements)
	{
		foreach ($elements->find('a') as $element) {
			//return $element->href."\n";
            $newlink = checkUrl($element->href);
            if($newlink)
            {
                $links[$newlink] = true;
            }
            return $newlink;

		}
	}
}

// $test = 'http://www.emag.ro/carti/promotii/filter/gen-f1195,beletristica-v-314847/c';
$test = [
			// 'http://www.emag.ro/atletism--alergare/nike/promotii/c' => '1',
			// 'http://www.emag.ro/mers/converse/c?ref=menu_link_1308_9' => '1',
			// 'http://www.emag.ro/televizoare/promotii/filter/smart-tv-f374,smart-tv-3d-v9406/c' => '1',
			// 'http://www.emag.ro/aparate_foto_d-slr/promotii/c?ref=menu_link_1308_9' => '1',
			// 'http://www.emag.ro/hrana/promotii/c' => '1',
			// 'http://www.emag.ro/parfumuri/promotii/c' => '1',
			// 'http://www.emag.ro/scutece-servetele/promotii/c' => '1',
			// 'http://www.emag.ro/jucarii-jocuri-educative/promotii/c' => '1',
			// 'http://www.emag.ro/petshop/l?ref=menu_banner_1308_11' => '1',
			'http://www.emag.ro/telefoane-mobile/c' => '1',
			'http://www.emag.ro/laptopuri-accesorii/l' => '1',
			'http://www.emag.ro/laptopuri/c' => '1',
			'http://www.emag.ro/carti/promotii/filter/gen-f1195,beletristica-v-314847/c' => '1',

		];

foreach ($test as $key => $value) 
{
	echo checkPagination($key);
	//var_dump(checkPagination($key));
	$data = array(
	        'links' => $key,
	        //'statecheck'  => 0,
	);

	$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
	    ->setTableName('emag')
	    ->setData($data);

	$result = $sqlManager->insert($sqlBuilder);

	//var_dump($result); // [50, 51, ...] || false
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


