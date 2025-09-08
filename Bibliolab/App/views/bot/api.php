<?php
header('Content-Type: application/json');

// chave da API 
$API_KEY = "chave aqui";

// Recebe o histórico do front-end
$input = json_decode(file_get_contents('php://input'), true);
$historico = $input['historico'] ?? [];

// Se não tiver histórico, inicializa vazio
if (!$historico) {
    $historico = [];
}

// Prompt inicial fixando a identidade do bot
$contexto_inicial = [
    "role" => "user",
    "parts" => [[
        "text" => "Você é um chatbot chamado Pingo. Sempre que alguém disser 'Pingo', entenda que está falando com você. Seja simpático, amigável e prestativo."
    ]]
];

// Junta o contexto inicial com o histórico do usuário
$conteudo = array_merge([$contexto_inicial], $historico);

// Faz a requisição para a API do Gemini
$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$API_KEY");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "contents" => $conteudo
]));

$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo json_encode(["error" => $err]);
} else {
    echo $response;
}
