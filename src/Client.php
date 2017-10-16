<?php

namespace Jilfond\Apirosreestr;

use Jilfond\Apirosreestr\Exception\ApirosreestrException;

class Client implements ClientInterface
{

    /** @var string The API access token */
    private static $token = null;

    /** @var string The instance token, settable once per new instance */
    private $instanceToken;

    private $client;

    public function __construct($token = null)
    {
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Jilfond\Apirosreestr::setToken, or instantiate the Jilfond\Apirosreestr class with a $token parameter.';
                throw new ApirosreestrException($msg);
            }
        } else {
            $this->instanceToken = $token;
        }
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => self::API_BASE_URL,
            'headers' => [
                'Token' => $token === null ? $this->instanceToken : $token,
                'Content-Type' => 'application/json'
            ]
        ]);
    }
    public static function setToken($token)
    {
        self::$token = $token;
    }

    public function cadasterSearch($query,$grouped = 0)
    {
        if (is_string($query)) {
            $parameters =  ['json' => ['query' => $query,
                'grouped' => $grouped
            ]];
        } else if ($query instanceof CadasterSearchQuery) {
            $parameters = ['json' => [
                'query' => $query->getJsonQuery(),
                'grouped' => $grouped ]
            ];
        } else {
            throw new ApirosreestrException('query should be a string or instance of CadasterSearchQuery');
        }
        $response = $this->client->post('cadaster/search', $parameters);
        return json_decode($response->getBody(), true);
    }

    public function cadasterObjectInfoFull($query)
    {
        $response = $this->client->post('cadaster/objectInfoFull', ['json' => ['query' => $query]]);
        return json_decode($response->getBody(), true);
    }

    public function cadasterSaveOrder($object, array $documents, array $rsn = [], $comment = null)
    {
        $obj = ['encoded_object' => $object,
            'documents' => $documents,
            ];

        if (!empty($rsn)) {
            $obj['rsn_items'] = $rsn;
        }
        if ($comment) {
            $obj['comment'] = $comment;
        }

        $response = $this->client->post('cadaster/save_order', ['json' => $obj]);

        return json_decode($response->getBody(), true);
    }

    public function transactionInfo($id)
    {
        $response = $this->client->post('transaction/info', ['json' => ['id' => $id]]);
        return json_decode($response->getBody(), true);
    }

    public function transactionPay($id, $confirm)
    {
        $response = $this->client->post('transaction/pay', ['json' => ['id' => $id, 'confirm' => $confirm]]);
        return json_decode($response->getBody(), true);
    }

    public function cadasterOrder($id)
    {
        $response = $this->client->post('transaction/orders', ['json' => ['id' => $id]]);
        return json_decode($response->getBody(), true);
    }
    public function cadasterDownload($documentId, $format, $savePath) {
        $this->client->request('POST', 'cadaster/download', ['json' => ['document_id' => $documentId, 'format' => $format], 'sink' => $savePath]);
        return null;
    }

}