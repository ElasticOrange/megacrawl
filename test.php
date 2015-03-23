<?php
require 'init.php';

use Sunra\PhpSimple\HtmlDomParser;

// $dom = HtmlDomParser::file_get_html( "http://emag.ro" );
// foreach($dom->find('nav#emg-mega-menu') as $elements)
// {
// 	foreach ($elements->find('a') as $element) 
// 	{
//         $newlink = checkUrl($element->href);
//         if($newlink)
//         {
//             $links[$newlink] = true;
//             //echo $newlink."\n";
// 			/* 
// 			$data = array(
// 				        'links' => $newlink,
// 				        //'statecheck'  => 0,
// 				);

// 			$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
// 			    ->setTableName('emag')
// 			    ->setData($data);

// 			$result = $sqlManager->insert($sqlBuilder);
// 			*/
//         }
// 	}
// }

//
// READ FROM Mysql urls to check
// iterate for each of them and
// check for span class category-sidebar

$sqlBuilder = new \Simplon\Mysql\Manager\SqlQueryBuilder();

$sqlBuilder
    ->setQuery('SELECT links FROM emag')
    ->setConditions(array('statecheck' => '0'));

$result = $sqlManager->fetchRowMany($sqlBuilder);

foreach ($result as $key => $value) {
	echo checkPagination($value['links']);
}

function checkPagination($stringToCheck)
{	
	sleep(3);

	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('span.category-sidebar') as $elements)
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