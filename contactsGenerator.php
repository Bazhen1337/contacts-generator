<?php

require_once (__DIR__.'/pool.php');
require_once (__DIR__.'/crest.php');

class contactsGenerator
{
    public array $contact_ids = [];
    public function generate($count): void
    {
        $contact_ids = [];

        for ($i = 1; $i <= $count; $i++) {
            $name = $this->generateRandomName();
            $phone = $this->generateRandomPhone();
            $email = $this->generateRandomEmail($name['last_name']);

            $contact_data = [
                'FIELDS' => [
                    'NAME' => $name['first_name'],
                    'SECOND_NAME' => $name['middle_name'],
                    'LAST_NAME' => $name['last_name'],
                    'PHONE' => [
                        [
                            'VALUE' => $phone,
                            'VALUE_TYPE' => 'WORK',
                        ]
                    ],
                    'EMAIL' => [
                        [
                            'VALUE' => $email,
                            'VALUE_TYPE' => 'WORK',
                        ]
                    ]
                ]
            ];

            $result = CRest::call(
                'crm.contact.add', $contact_data
            );

            if (isset($result['result'])) {
                $this->contact_ids[] = $result['result'];
                echo "Создан контакт: {$name['last_name']} {$name['first_name']} (ID: {$result['result']})<br>";
            } else {
                echo "Ошибка создания контакта: " . json_encode($result) . "<br>";
            }

            sleep(1);
        }
    }

    private function generateRandomName() : array {
        return [
            'last_name' => last_names[array_rand(last_names)],
            'first_name' => first_names[array_rand(first_names)],
            'middle_name' => middle_names[array_rand(middle_names)]
        ];
    }

    private function generateRandomPhone() : string {
        return '+7' . rand(900, 999) . rand(1000000, 9999999);
    }

    private function generateRandomEmail(string $name) : string {
        $name_latin = strtr(mb_strtolower($name), translit);
        $domain = domains[array_rand(domains)];

        return $name_latin . rand(100, 999) . '@' . $domain;
    }
}