<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Factory;
use JetBrains\PhpStorm\NoReturn;
use Exception;

class WhoisController extends Controller
{

    public function search(Request $request)
    {
        $domain = $request->domain;

        $whois = Factory::get()->createWhois();

        $domainsInfo = [];

        try {
            $domainsInfo['domain'] = $domain;
            if ($whois->isDomainAvailable($domain)) {
                $domainsInfo['info'] = 'Свободен';
            } else {
                $info = $whois->loadDomainInfo($domain);
                $domainsInfo['info'] = date("Y-m-d", $info->expirationDate);
            }
            return $domainsInfo;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }


    }

}
