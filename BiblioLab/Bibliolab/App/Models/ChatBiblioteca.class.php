<?php
class ChatBiblioteca {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function salvarMensagem($biblioteca_id, $usuario_id, $mensagem) {
        $sql = "INSERT INTO ChatBiblioteca (biblioteca_id, usuario_id, mensagem) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$biblioteca_id, $usuario_id, $mensagem]);
    }

    public function listarMensagens($biblioteca_id) {
        $sql = "SELECT c.mensagem, c.data_envio, u.nome
                FROM ChatBiblioteca c
                JOIN Usuarios u ON c.usuario_id = u.id
                WHERE c.biblioteca_id = ?
                ORDER BY c.data_envio ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$biblioteca_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
