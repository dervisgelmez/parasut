<?php

namespace Parasut\Service;

use Parasut\Service;

class Account extends Service
{
    const REQUEST_NAME = 'accounts';

    public function __construct($client, $request)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }

    public function transactions($id)
    {
        $data = '/'.$id.'/transactions';

        return $this->client->send(
            $this->request, $data, 'GET'
        );
    }
}


?>