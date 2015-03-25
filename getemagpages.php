<?php
require 'init.php';
use Sunra\PhpSimple\HtmlDomParser;

/*
// este parsata prima pagina si se extrag linkurile din navbar-ul main page
$dom = HtmlDomParser::file_get_html( "http://emag.ro" );
foreach($dom->find('nav#emg-mega-menu') as $elements)
{
	foreach ($elements->find('a') as $element) 
	{
        $newlink = cutUrl(checkUrl($element->href));
        if($newlink)
        {
            $links[$newlink] = true;
        }
	}
}

foreach ($links as $key => $value) 
{
	addLinksFromHomepageToDb($key, $sqlManager);
}

// linkurile extrase din navbar-ul main page sunt inserate in tabela
function addLinksFromHomepageToDb($url, $sqlManager)
{
	$data = array(
		        'links' => $url,
		        'statecheck'  => '0',
		);

	$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
	    ->setTableName('emag')
	    ->setData($data);

	$result = $sqlManager->insert($sqlBuilder);
}
*/


do {
		// select 1 row from table where statecheck = 0
		$sqlBuilder = new \Simplon\Mysql\Manager\SqlQueryBuilder();
		$sqlBuilder
		->setQuery('SELECT * FROM emag WHERE statecheck = :statecheck')
		->setConditions(array('statecheck' => '0'));
		$select = $sqlManager->fetchRow($sqlBuilder);

		print_r($select);
			
		// change statecheck to 1
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

		// daca este categorie se adauga in tabela
		// daca este lista se extrag categoriile si se adauga in tabela
		if ((isCategory($select['links'])) !== true)
		{
			$hasPagination = checkCategory($select['links']);
			foreach ($hasPagination as $key => $value) 
			{
				print_r($key);
				addPaginationLinksToDb($key, $sqlManager);
			}
		}
		else
		{
			print_r($select['links']);
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
function isCategory($stringToCheck)
{
	sleep(4);
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	if($dom->find('div#products-holder'))
	{
		return true;
	}
}


// functia verifica daca linkul este o categorie si extrage elementele linkuri 
function checkCategory($stringToCheck)
{	
	sleep(5);
	$links = [];
	$dom = HtmlDomParser::file_get_html( $stringToCheck );
	foreach($dom->find('span.category-sidebar') as $elements)
	{
		foreach ($elements->find('a') as $element) 
		{
            $newlink = (checkUrl($element->href));
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
	try {
		$data = array(
				'pagina' => $links,
			);
		$sqlBuilder = (new \Simplon\Mysql\Manager\SqlQueryBuilder())
		->setTableName('paginiproduse')
		->setData($data);

		$update = $sqlManager->insert($sqlBuilder);
	} catch (Simplon\Mysql\MysqlException $e)
	{
		echo "am prins eroarea";
		//throw new MysqlException($e->getMessage(), $e->getCode());
	}
}

function cutUrl($link)
{
	$link = substr($link, 0, strpos($link, '?ref'));
	return $link;
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