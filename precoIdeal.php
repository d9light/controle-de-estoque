<?php

use Model\usuarioModel;                            
use Controller\UsuarioController;
use Model\ingredientesModel;
use Controller\ingredientesController;

require './vendor/autoload.php';

// Carrega o controlador de usuários e obtém a lista de funcionários
$userController = new UsuarioController();
$listaFuncionarios = $userController->loadAll(); 

// Carrega o controlador de ingredientes e obtém o modelo
$controller = new ingredientesController();
$ingredientesModel = new ingredientesModel(); 

// Chama a função calcularTotal() para obter o custo total dos ingredientes
$valorTotal = $ingredientesModel->calcularTotal();

require_once "src/controller/autenticationController.php";

// Verifica se o formulário foi enviado e faz o cálculo com base na quantidade informada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantidade = (int)$_POST['quantidade']; // Quantidade de brigadeiros

    // Calcula o preço de custo
    if ($quantidade > 0) {
        $precoCusto = $valorTotal / $quantidade;

        // Define a porcentagem de lucro (30% de markup por exemplo)
        $porcentagemLucro = 30;
        $precoLucro = $precoCusto * (1 + $porcentagemLucro / 100);

        // Formata os valores
        $precoCustoFormatado = number_format($precoCusto, 2, ',', '.');
        $precoLucroFormatado = number_format($precoLucro, 2, ',', '.');
    } else {
        // Caso a quantidade não seja válida (menor ou igual a 0)
        $erro = "Por favor, insira uma quantidade válida de brigadeiros.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preço Ideal dos Brigadeiros</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            border-radius: 15px;
            width: 100%;
            max-width: 600px; /* Limita a largura máxima do card */
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .result {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>


<body>
    <div class="container">
    <header>
        <nav class="nav justify-content-center h1 ">
            <a class="nav-link active" href="menuFuncionario.php" aria-current="page">Funcionario Page</a>
        </nav>
    </header>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Calcular Preço Ideal dos Brigadeiros</h2>

                        <!-- Formulário para o usuário inserir a quantidade -->
                        <form action="precoIdeal.php" method="POST">
                            <div class="mb-3">
                                <label for="quantidade" class="form-label">Quantidade de Brigadeiros Produzidos:</label>
                                <input type="number" id="quantidade" name="quantidade" class="form-control" required min="1" placeholder="Digite a quantidade de brigadeiros">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Calcular</button>
                        </form>

                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($precoCusto)): ?>
                            <div class="result">
                                <h4 class="text-center">Resultados:</h4>
                                <p><strong>Preço de Custo por Brigadeiro:</strong> R$ <?= $precoCustoFormatado; ?></p>
                                <p><strong>Preço de Lucro (30% de markup):</strong> R$ <?= $precoLucroFormatado; ?></p>
                            </div>
                        <?php elseif (isset($erro)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?= $erro; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybC0sTT5Hq8J9I2tbv2p4TaV4RrBhFcpukZfM6dX5dIUl4Pflj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0h4f7tO+PXJ1Qb9c0L2o9gR9H5y4l9cz+MZ6s8omjGzScDFG" crossorigin="anonymous"></script>
</body>
</html>
