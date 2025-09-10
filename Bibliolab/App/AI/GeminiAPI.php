<?php
class GeminiAPI {
    private $apiKey;
    private $baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function gerarSugestoes($prompt) {
        $url = $this->baseUrl . "?key=" . $this->apiKey;

        $data = [
            "contents" => [[
                "parts" => [["text" => $prompt]]
            ]]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return "Erro cURL: " . curl_error($ch);
        }

        curl_close($ch);

        $result = json_decode($response, true);

        // Se a resposta vier correta
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        }

        // Se a API retornar erro
        if (isset($result['error'])) {
            return "Erro da API Gemini: " . $result['error']['message'];
        }

        // Caso inesperado
        return "⚠️ Resposta inesperada da API Gemini: " . json_encode($result);
    }
}
