<?php

$handle = fopen("links.txt", "r");
while (($data = fgetcsv($handle, 0, "<")) !== FALSE ) 
	{
		print_r($data);
	}
