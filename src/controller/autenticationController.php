<?php
session_start();

// Se não existir a session 'login', redireciona para a página de login com um código de erro
if (!isset($_SESSION['nome'])) {
    header('Location: ./login.php?cod=172');
    exit; // Garante que o script será encerrado após o redirecionamento
}
