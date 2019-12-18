<?php

namespace Parasut\Service;

use Parasut\Service;

class Trackable extends Service
{
    const REQUEST_NAME = 'trackable_jobs';

    public function __construct($client)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }

    public function checkStatus($jobsId)
    {
        return $this->client->send(
            $this->request, (string)$jobsId
        );
    }
}

?>