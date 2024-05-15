<?php

namespace Marcelogennaro\AutenticacaoRecargaApi\Services;

use Illuminate\Http\Request;

class AutenticacaoService
{

    public function extraiDadosToken(Request $request): array
    {
        $token = $request->bearerToken();

        $payload = base64_decode(explode('.', $token)[1]);
        $payloadData = json_decode($payload, true);

        $diff = $this->calculaDiferencaDatasEmMinutos($payloadData['timeToken']);

        return [
            'timeToken' => $diff,
            'cliente' => [
                'codigo_conekta' => $payloadData['codigo_conekta'],
                'senha_conekta' => $payloadData['senha_conekta']
            ]
        ];
    }

    private function calculaDiferencaDatasEmMinutos(string $timeToken): bool
    {
        $timeToken = new \DateTime($timeToken);
        $current = new \DateTime();

        $diff = $current->diff($timeToken);

        $calcMinutes = 0;

        if ($diff->days > 0) {
            return true;
        }

        if ($diff->h > 0) {
            $calcMinutes += $diff->h * 60;
        }

        if ($diff->i > 0) {
            $calcMinutes += $diff->i;
        }

        return $calcMinutes > config('autenticacao.time_token_expiration_minutes');
    }
}
