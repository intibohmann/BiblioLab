<?php
require_once(__DIR__ . '/../../Config/config.inc.php');


class Database {
    private static function abrirConexao() {
        try {
            return new PDO(DSN, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    private static function preparar($sql) {
        $conexao = self::abrirConexao();
        if ($conexao) {
            return $conexao->prepare($sql);
        }
        return null;
    }

    private static function vincularParametros($comando, $parametros) {
        foreach ($parametros as $chave => $valor) {
            $comando->bindValue($chave, $valor);
        }
        return $comando;
    }

    public static function executar($sql, $parametros = []) {
        try {
            $comando = self::preparar($sql);
            if ($comando) {
                $comando = self::vincularParametros($comando, $parametros);
                $comando->execute();
                return $comando;
            }
            return false;
        } catch (Exception $e) {
            // Você pode logar o erro aqui se quiser
            return false;
        }
    }
}
?>