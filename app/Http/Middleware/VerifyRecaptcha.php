<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Adicionando o uso do Log
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptcha
{
    /**
     * Manipula a requisição e verifica o reCAPTCHA.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('recaptcha_token');
        $secretKey = config('services.recaptcha.secret_key');
        $minScore = config('services.recaptcha.min_score', 0.5);

        if (empty($secretKey)) {
            throw new \RuntimeException('A chave secreta do reCAPTCHA não está configurada.');
        }

        if (!$token) {
            throw ValidationException::withMessages([
                'recaptcha' => 'reCAPTCHA não foi preenchido.'
            ]);
        }

        $response = Http::throw()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (
            !array_key_exists('success', $result) || !$result['success'] ||
            !array_key_exists('score', $result) || $result['score'] < $minScore
        ) {
            throw ValidationException::withMessages([
                'recaptcha' => 'Verificação reCAPTCHA falhou.'
            ]);
        }

        // Log de sucesso de verificação do reCAPTCHA
        Log::info('Login bem-sucedido - reCAPTCHA validado com sucesso para o IP: ' . $request->ip());

        return $next($request);
    }
}
