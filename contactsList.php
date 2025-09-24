<?php

class contactsList
{
    function getContactsWithDeals(): void {

        $contact_data = [
            'SELECT' => [
                'NAME',
                'SECOND_NAME',
                'LAST_NAME',
                'EMAIL',
                'PHONE',
            ]
        ];


        $contacts_result = CRest::call(
            'crm.contact.list', $contact_data
        );

        if (!isset($contacts_result['result'])) {
            echo 'Не удалось получить список контактов';
        }

        $contacts = [];

        foreach ($contacts_result['result'] as $contact) {

            $deals_result = CRest::call(
                'crm.deal.list', [
                    'filter' => ['CONTACT_ID' => $contact['ID']],
                    'select' => ['ID']
                ]
            );

            $deal_ids = [];
            if (isset($deals_result['result'])) {
                foreach ($deals_result['result'] as $deal) {
                    $deal_ids[] = $deal['ID'];
                }
            }

            $contacts[] = [
                'first_name' => $contact['NAME'] ?? '',
                'last_name' => $contact['LAST_NAME'] ?? '',
                'middle_name' => $contact['SECOND_NAME'] ?? '',
                'phone' => $contact['PHONE'] ?? '',
                'email' => $contact['EMAIL'] ?? '',
                'deals_count' => count($deal_ids),
                'deal_ids' => $deal_ids
            ];
            sleep(1);
        }
        echo json_encode($contacts, JSON_UNESCAPED_UNICODE);
    }
}