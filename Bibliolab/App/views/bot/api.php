<?php
header('Content-Type: application/json');

// Sua chave da API 
$API_KEY = "";

// Recebe o histórico do front-end
$input = json_decode(file_get_contents('php://input'), true);
$historico = $input['historico'] ?? [];

if (!$historico) {
    echo json_encode(["error" => "Nenhum histórico fornecido."]);
    exit;
}

// Faz a requisição para a API do Gemini
$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$API_KEY");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "contents" => $historico
]));

$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo json_encode(["error" => $err]);
} else {
    echo $response;
}
