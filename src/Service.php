<?php

namespace Parasut;

class Service
{
    /**@var Client $client*/
    protected $client;
    protected $request;

    public function __construct($client, $request)
    {
        $this->client = $client;
        $this->request = $request;
    }

    public function show($filter = array(), $page = 1, $size = 15)
    {
        return $this->client->send(
            $this->request,[
                'filter' => $filter,
                'page' => [
                    'number' => $page,
                    'size' => $size
                ]
            ]
        );
    }

    public function find($id = null)
    {
        if (!$id) {
            $this->show();
        }
        return $this->client->send(
            $this->request, (string)$id
        );
    }

    public function create(array $data)
    {
        return $this->client->send(
            $this->request, $data, 'POST'
        );
    }

    public function update($id, array $data)
    {
        $url = (string)$this->request.'/'.$id;

        return $this->client->send(
            $url, $data, 'PUT'
        );
    }

    public function delete($id)
    {
        $url = (string)$this->request.'/'.$id;

        return $this->client->send(
            $url, null, 'DELETE'
        );
    }
}

?>