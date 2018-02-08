<?php

namespace Iupick;

class Iupick
{
    protected static $publicToken;
    protected static $secretToken;
    protected static $enviroment;

    
    public static function setPublicToken(string $publicToken)
    {
        self::$publicToken = $publicToken;
    }

    public static function setSecretToken(string $secretToken)
    {
        self::$secretToken = $secretToken;
    }

    public static function setEnviroment(string $enviroment)
    {
        self::$enviroment = $enviroment;
    }

    public static function getBaseUrl()
    {
        if (self::$enviroment === 'production') {
            return 'https://iupick.com/api/';
        } elseif (self::$enviroment === 'sandbox') {
            return 'https://sandbox.iupick.com/api/';
        } elseif (self::$enviroment === 'development') {
            return 'http://localhost:8000/api/';
        }
        return false;
    }

    public static function generateAuthHeader(string $auth)
    {
        if ($auth === 'public') {
            $keyword = 'Token ';
            $token = self::$publicToken;
        } elseif ($auth === 'secret') {
            $keyword = 'Secret ';
            $token = self::$secretToken;
        }

        return 'Authorization: ' . $keyword . $token;
    }
    
    public static function createAddress(
        string $city,
        string $line_one,
        string $line_two = '',
        string $postal_code,
        string $neighborhood = '',
        string $state = '',
        string $state_code = ''
    ) {
    
        return [
            'city' => $city,
            'line_one' => $line_one,
            'line_two' => $line_two,
            'neighborhood' => $neighborhood,
            'postal_code' => [
                'code' => $postal_code,
                'state' => [
                    'name' => $state,
                    'code' => $state_code
                ]
            ]
        ];
    }

    public static function emptyAddress()
    {
        return [
            'city' => 'Empty',
            'line_one' => 'Empty',
            'line_two' => 'Empty',
            'neighborhood' => 'Empty',
            'postal_code' => [
                'code' => 'Empty',
                'state' => [
                    'name' => 'Empty',
                    'code' => 'XX'
                ]
            ]
        ];
    }

    public static function createPerson(
        string $person_name,
        string $phone_number,
        string $email_address,
        string $title = '',
        string $company_name = '',
        string $phone_extension = ''
    ) {
    
        return [
            'person_name'=> $person_name,
            'phone_number'=> $phone_number,
            'email_address'=> $email_address,
            'title'=> $title,
            'company_name'=> $company_name,
            'phone_extension'=> $phone_extension
        ];
    }
    
    public static function callApi($url, $authHeader, $method, $data = null)
    {
        $data_string = \json_encode($data ?? '', \JSON_UNESCAPED_UNICODE);
        $headers[] = $authHeader;

        if ($method === 'post'){
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($data_string);
            $contextData['method'] = 'POST';
            $contextData['content'] = $data_string;
        }
        
        $contextData['header']= implode("\r\n", $headers);
        $contextData['ignore_errors'] = true;

        $context = stream_context_create([
            'http' => $contextData
        ]);
        $result = file_get_contents($url, null, $context);
        
        return $result;
    }
}
