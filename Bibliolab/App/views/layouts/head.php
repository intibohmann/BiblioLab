<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar - Biblioteca Dirigida</title>
  <link rel="stylesheet" href="css.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <?php
  // Sempre iniciar a sessão ANTES de qualquer uso de $_SESSION
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  // Inclui o menu somente após a sessão estar ativa
  include_once(__DIR__ . '/Navbar.php');
  ?>
</head>
<body>
