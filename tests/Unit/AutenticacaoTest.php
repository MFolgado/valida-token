<?php

it('valida token da requisição', function (){
    $client = new \GuzzleHttp\Client();

    $token = generateValidToken();

    $response = $client->request(
        'GET',
        'http://localhost:8000/api/valida-token',
        ['headers' =>
            [
                'Authorization' => 'Bearer ' . $token
            ]
        ]
    )->getBody()->getContents();

    return expect(boolval($response))->toBeTrue();
});


it('retorna token da requisição', function (){
    $client = new \GuzzleHttp\Client();

    $response = $client->request(
        'GET',
        'http://localhost:8000/api/retornaToken',
        [
            'headers' =>
                [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwiY29kaWdvX2NvbmVrdGEiOiI1NTEwOSIsInNlbmhhX2NvbmVrdGEiOiJkNjAyMmIwMyIsIm5hbWUiOiJVUCBTVE9SRSBMVVpJw4JOSUEiLCJpYXQiOjE1MTYyMzkwMjIsInRpbWVUb2tlbiI6IjIwMjQtMDUtMTMgMTg6MDA6MzQifQ.YxB9V6JZKTYh9WThF2NOEiCIYSoA6ccJonbgdYFCBpw'
                ]
        ]
    )->getBody()->getContents();

    $return = json_decode($response);

    return expect($return->token)->toEqual('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwiY29kaWdvX2NvbmVrdGEiOiI1NTEwOSIsInNlbmhhX2NvbmVrdGEiOiJkNjAyMmIwMyIsIm5hbWUiOiJVUCBTVE9SRSBMVVpJw4JOSUEiLCJpYXQiOjE1MTYyMzkwMjIsInRpbWVUb2tlbiI6IjIwMjQtMDUtMTMgMTg6MDA6MzQifQ.YxB9V6JZKTYh9WThF2NOEiCIYSoA6ccJonbgdYFCBpw');
});


it('valida token expirado', function (){
    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->request(
            'GET',
            'http://localhost:8000/api/valida-token',
            [
                'headers' =>
                    [
                        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwiY29kaWdvX2NvbmVrdGEiOiI1NTEwOSIsInNlbmhhX2NvbmVrdGEiOiJkNjAyMmIwMyIsIm5hbWUiOiJVUCBTVE9SRSBMVVpJw4JOSUEiLCJpYXQiOjE1MTYyMzkwMjIsInRpbWVUb2tlbiI6IjIwMjQtMDUtMTMgMTg6MDA6MzQifQ.YxB9V6JZKTYh9WThF2NOEiCIYSoA6ccJonbgdYFCBpw'
                    ]
            ]
        )->getStatusCode();
    }catch (Exception $e){
        return expect($e->getCode())->toBe(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
    }
});
