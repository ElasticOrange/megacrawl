<?php
//require 'vendor/sunra/autoload.php';

//require 'first.php';
use Sunra\PhpSimple\HtmlDomParser;

$str = "http://emag.ro";
$dom = HtmlDomParser::str_get_html($str);

foreach($dom->find('a') as $element)
{
	echo $element->href.'<br>';
}