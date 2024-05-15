<?php

namespace Marcelogennaro\AutenticacaoRecargaApi\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Marcelogennaro\AutenticacaoRecargaApi\Services\AutenticacaoService;
use Symfony\Component\HttpFoundation\Response;


class ValidationToken
{
    private mixed $model;
    private AutenticacaoService $autenticacaoService;

    public function __construct()
    {
        $this->model = config('autenticacao.model');
        $this->autenticacaoService = new AutenticacaoService();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payloadData = $this->autenticacaoService->extraiDadosToken($request);

        if($payloadData['timeToken']){
            return response()->json([
                'error' => utf8_encode('token expirado')
            ], Response::HTTP_UNAUTHORIZED);
        }

        $cliente = $this->model::where('codigo_conekta', $payloadData['cliente']['codigo_conekta'])->first();

        if (!$cliente) {
            return response()->json([
                'error' => utf8_encode('usu�rio n�o localizado')
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

}
