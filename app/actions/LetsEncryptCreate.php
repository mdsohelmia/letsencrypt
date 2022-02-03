<?php

namespace App\actions;

use LEClient\LEClient;
use LEClient\LEOrder;

class LetsEncryptCreate
{
    public function __construct()
    {

    }

    public function create()
    {
        $email = ["sohel@gotipath.com"];
        $domains = ['cdn.odkbd.com'];
        $certificateKeys = storage_path('/keys');
        $accountKeys = storage_path('__account');
        $acmeURL = LEClient::LE_STAGING;
        if (env('LE_PRODUCTION')) {
            $acmeURL = LEClient::LE_PRODUCTION;
        }
        $sourceIp = env('LE_PRODUCTION_IP');
        $client = new LEClient($email, $acmeURL, LEClient::LOG_OFF, $certificateKeys, $accountKeys, $sourceIp);
        $acct = $client->getAccount();

        $order = $client->getOrCreateOrder('odkbd.com', $domains);

        $pending = $order->getPendingAuthorizations(LEOrder::CHALLENGE_TYPE_DNS);

        return [
            'txt' => $pending[0]['DNSDigest'],
            'acme' => "_acme-challenge." . $pending[0]['identifier']
        ];
    }

    public function verify()
    {
        $email = ["sohel@gotipath.com"];
        $domains = ['cdn.odkbd.com'];
        $certificateKeys = storage_path('/keys');
        $accountKeys = storage_path('__account');
        $acmeURL = LEClient::LE_STAGING;
        if (env('LE_PRODUCTION')) {
            $acmeURL = LEClient::LE_PRODUCTION;
        }
        $sourceIp = env('LE_PRODUCTION_IP');
        $client = new LEClient($email, $acmeURL, LEClient::LOG_OFF, $certificateKeys, $accountKeys, $sourceIp);
        $acct = $client->getAccount();

        $data = [];
        $order = $client->getOrCreateOrder('odkbd.com', $domains);

        $data['verify'] = $order->verifyPendingOrderAuthorization('cdn.odkbd.com', LEOrder::CHALLENGE_TYPE_DNS);
        $data['finalize'] = $order->finalizeOrder();
        $data['finalized'] = $order->isFinalized();;
        $data['cert'] = $order->getCertificate();
        return $data;
    }

}
