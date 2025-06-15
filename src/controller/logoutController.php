<?php
// Inicia a sessão
session_start();

// Destrói todas as variáveis da sessão
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login ou outra página desejada

header('Location: /login.php?cod=172');  // Caminho absoluto
exit();
?>
