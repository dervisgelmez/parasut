<?php

namespace Parasut\Service;

use Parasut\Service;

class Category extends Service
{
    const REQUEST_NAME = 'item_categories';

    public function __construct($client, $request)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }
}


?>