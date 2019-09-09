<?php

namespace Parasut\Service;

use Parasut\Service;

class Employee extends Service
{
    const REQUEST_NAME = 'employees';

    public function __construct($client, $request)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }

    public function archive($id)
    {
        $url = (string)$this->request.'/'.$id.'/archive';

        return $this->client->send(
            $url, null, 'PATCH'
        );
    }

    public function unArchive($id)
    {
        $url = (string)$this->request.'/'.$id.'/unarchive';

        return $this->client->send(
            $url, null, 'PATCH'
        );
    }
}


?>