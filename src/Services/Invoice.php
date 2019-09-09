<?php

namespace Parasut\Service;

use Parasut\Service;

class Invoice extends Service
{
    const REQUEST_NAME = 'sales_invoices';

    public function __construct($client, $request)
    {
        parent::__construct($client, self::REQUEST_NAME);
    }

    public function pay($id, array $data)
    {
        $url = (string)$this->request.'/'.$id.'/payments';

        return $this->client->send(
            $url, $data, 'POST'
        );
    }

    public function cancel($id)
    {
        $url = (string)$this->request.'/'.$id.'/cancel';

        return $this->client->send(
            $url, null, 'DELETE'
        );
    }

    public function recover($id)
    {
        $url = (string)$this->request.'/'.$id.'/recover';

        return $this->client->send(
            $url, null, 'PATCH'
        );
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

    public function eArchives($data)
    {
        return $this->client->send(
          'e_archives', $data,'POST'
        );
    }

    public function eInvoices($data)
    {
        return $this->client->send(
          'e_invoices', $data,'POST'
        );
    }

}


?>