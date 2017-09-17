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
            $parameters = ['query' => $query->getJsonQuery(),
                            'grouped' => $grouped
                ];
        } else {
            throw new ApirosreestrException('query should be a string or instance of CadasterSearchQuery');
        }
        $response = $this->client->post('/cadaster/search', ['body' => $parameters]);
        return (string) $response->getBody();
    }

    public function CadasterObjectInfoFull($query)
    {
        $this->client->post('/cadaster/objectInfoFull', ['body' => [
            'query' => $query,
        ]]);
    }


}