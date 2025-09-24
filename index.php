<?
require_once (__DIR__.'/contactsGenerator.php');
require_once (__DIR__.'/dealsGenerator.php');

$result = new contactsGenerator();
$result->generate(countContacts);

$deals = new dealsGenerator();
$deals->generate(countDeals, $result->contact_ids);

echo "Скрипт закончил работу";