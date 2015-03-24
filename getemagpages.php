<?php
require 'init.php';

use Sunra\PhpSimple\HtmlDomParser;

// este parsata prima pagina si se extrag linkurile din navbar-ul main page
$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('nav#emg-mega-menu') as $elements)
{
	foreach ($elements->find('a') as $element) 
	{
        $newlink = checkUrl($element->href);
        if($newlink)
        {
            $links[$newlink] = true;
        }
	}
	return $links;
}

foreach ($links as $key => $value) 
{
	addLinksFromHomepageToDb($value, $sqlManager);
}

// linkurile extrase din navbar-ul main page sunt inserate in tabela
function addLinksFromHomepageToDb($stringToCheck, $sqlManager)
{
	$data = array(
		        'links' => $newlink,
		        'statecheck'  => '0',
		);

	$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
	    ->setTableName('emag')
	    ->setData($data);

	$result = $sqlManager->insert($sqlBuilder);
}


do {
		// functia de select 1 row
		$sqlBuilder = new \Simplon\Mysql\Manager\SqlQueryBuilder();
		$sqlBuilder
		->setQuery('SELECT * FROM emag WHERE statecheck = :statecheck')
		->setConditions(array('statecheck' => '0'));
		$select = $sqlManager->fetchRow($sqlBuilder);

		print_r($select);
			
		// functia de update
		$data = array(
		'statecheck' => '1',
		);

		$sqlBuilder = new \Simplon\Mysql\Manager\SqlQueryBuilder();

		$sqlBuilder
		->setTableName('emag')
		->setConditions(array('id' => $select['id']))
		->setConditionsQuery("id = :id")
		->setData($data);

		$update = $sqlManager->update($sqlBuilder);

		if ((isCategory($select['links'], $sqlManager)) !== true)
		{
			$hasPagination = checkCategory($select['links'], $sqlManager);
			
			foreach ($hasPagination as $key => $value) 
			{
				addLinksToDb($key, $sqlManager);
			}
		}
		else
		{
			addPaginationLinksToDb($select['links'], $sqlManager);
		}
		
		$data = array(
		'statecheck' => '2',
		);

		$sqlBuilder = new \Simplon\Mysql\Manager\SqlQueryBuilder();

		$sqlBuilder
		->setTableName('emag')
		->setConditions(array('id' => $select['id']))
		->setConditionsQuery("id = :id")
		->setData($data);

		$update = $sqlManager->update($sqlBuilder);
	} while ($select);


// functia verifica daca linkul are paginatie (si il adauga in baza de date)
function isCategory($stringToCheck, $sqlManager)
{
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	if($dom->find('div#products-holder'))
	{
		return true;
	}
}


// functia verifica daca linkul este o categorie si extrage elementele linkuri 
function checkCategory($stringToCheck, $sqlManager)
{	
	sleep(5);

	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('span.category-sidebar') as $elements)
	{
		foreach ($elements->find('a') as $element) {
            $newlink = checkUrl($element->href);
            if($newlink)
            {
                $links[$newlink] = true;
            }
		}
	}
	return $links;
}

// functia face adaugarea linkurilor cu paginatie in baza de date 'paginiproduse'
function addPaginationLinksToDb($links, $sqlManager)
{
	$data = array(
			'pagina' => $links,
		);
	$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
	->setTableName('paginiproduse')
	->setData($data);

	$update = $sqlManager->insert($sqlBuilder);
}