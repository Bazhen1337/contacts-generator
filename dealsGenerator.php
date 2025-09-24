<?php

require_once (__DIR__.'/pool.php');
require_once (__DIR__.'/crest.php');

class dealsGenerator
{
    function generate($count, $contact_ids): void {

        for ($i = 1; $i <= $count; $i++) {
            $random_contact_id = $contact_ids[array_rand($contact_ids)];
            $random_title = deal_titles[array_rand(deal_titles)];

            $deal_data = [
                'FIELDS' => [
                    'TITLE' => $random_title . ' #' . $i,
                    'CURRENCY_ID' => 'RUB',
                    'OPPORTUNITY' => rand(1000, 100000),
                    'CONTACT_IDS' => [$random_contact_id],
                ]
            ];

            $result = CRest::call(
                'crm.deal.add', $deal_data
            );

            if (isset($result['result'])) {
                echo "Создана сделка: {$deal_data['FIELDS']['TITLE']} (ID: {$result['result']}) для контакта ID: $random_contact_id<br>";
            } else {
                echo "Ошибка создания сделки: " . json_encode($result) . "<br>";
            }

            sleep(1);
        }
    }
}