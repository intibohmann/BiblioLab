<?php
require_once __DIR__ . '/../Models/ChatBiblioteca.class.php';

class ChatBibliotecaController {
    private $chatModel;

    public function __construct($pdo) {
        $this->chatModel = new ChatBiblioteca($pdo);
    }

    public function exibirChat($biblioteca_id) {
        return $this->chatModel->listarMensagens($biblioteca_id);
    }

    public function enviarMensagem($biblioteca_id, $usuario_id, $mensagem) {
        if (!empty(trim($mensagem))) {
            return $this->chatModel->salvarMensagem($biblioteca_id, $usuario_id, $mensagem);
        }
        return false;
    }
}
