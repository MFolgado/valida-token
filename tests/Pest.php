<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}


date_default_timezone_set('America/Campo_Grande');

function generateValidToken()
{
    $current = new DateTime();
    $current = $current->format('Y-m-d h:i:s');

    $payload = [
        "sub" => "1234567890",
        "codigo_conekta" => "55109",
        "senha_conekta" => "d6022b03",
        "nome" => mb_convert_encoding("UP STORE LUZIÂNIA", 'UTF-8', 'ISO-8859-1'),
        "iat" => '1516239022',
        "timeToken" => $current
    ];

    $key = "jUXaw4xblBJpRrSwPQCd7fqK5pBOGPJdV7v60bZUOZtwBBbw1g3wm5V24xDD1J6H";

    $token =  encode($payload, $key);

    return $token;
}

function base64url_encode($data)
{
    return str_replace(['+','/','='], ['-','_',''], base64_encode($data));
}

function base64_decode_url($string)
{
    return base64_decode(str_replace(['-','_'], ['+','/'], $string));
}

// retorna JWT
function encode(array $payload, string $secret): string
{

    $header = json_encode([
        "alg" => "HS256",
        "typ" => "JWT"
    ]);

    $payload = json_encode($payload);

    $header_payload = base64url_encode($header) . '.'. base64url_encode($payload);

    $signature = hash_hmac('sha256', $header_payload, $secret, true);

    return
        base64url_encode($header) . '.' .
        base64url_encode($payload) . '.' .
        base64url_encode($signature);
}

// retorna payload em formato array, ou lança um Exception
function decode(string $token, string $secret): array
{
    $token = explode('.', $token);
    $header = base64_decode_url($token[0]);
    $payload = base64_decode_url($token[1]);

    $signature = base64_decode_url($token[2]);

    $header_payload = $token[0] . '.' . $token[1];

    if (hash_hmac('sha256', $header_payload, $secret, true) !== $signature) {
        throw new \Exception('Invalid signature');
    }
    return json_decode($payload, true);
}

