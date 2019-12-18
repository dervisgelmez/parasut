<?php

namespace Parasut\Service;

use Parasut\Service;

class Product extends Service
{
    const REQUEST_NAME = 'products';

    public function __construct($client)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }
}


?>