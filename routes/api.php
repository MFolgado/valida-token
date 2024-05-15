<?php

use \Illuminate\Support\Facades\Route;
use \Marcelogennaro\AutenticacaoRecargaApi\Http\Middleware\ValidationToken;
use \Symfony\Component\HttpFoundation\Response;

Route::middleware(ValidationToken::class)->get('/valida-token', function () {

    return [
        'status' => Response::HTTP_OK,
        'token' => request()->bearerToken(),
        'body' => true
    ];
});

Route::get('/retornaToken', function () {
    return [
        'status' => Response::HTTP_OK,
        'token' => request()->bearerToken()
    ];
});
