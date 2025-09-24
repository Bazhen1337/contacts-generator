<?
require_once (__DIR__.'/contactsGenerator.php');
require_once (__DIR__.'/dealsGenerator.php');
require_once (__DIR__.'/contactsList.php');

$contacts = new contactsGenerator();
$contacts->generate(countContacts);

$deals = new dealsGenerator();
$deals->generate(countDeals, $contacts->contact_ids);

$result = new contactsList();
$result->getContactsWithDeals();

echo "<br>" . "Скрипт закончил работу";