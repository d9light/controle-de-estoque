<?php

use Model\usuarioModel;                             
use Controller\ingredientesController;

require './vendor/autoload.php';

// Função para excluir o ingrediente com base no ID via URL
if (isset($_GET['cmd']) && $_GET['cmd'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $userController = new ingredientesController();
    $userController->delete($id); // Chama a função delete
}

$userController = new ingredientesController();
$listaFuncionarios = $userController->loadAll(); // Obtém a lista de funcionários

require_once "src/controller/autenticationController.php";

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Gerenciamento</title>
    <link rel="stylesheet" href=".\src/css/admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><span></span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(src/img/user-login.png)"></div>
                <h4><span> <?php @session_start(); echo $_SESSION['nome']; ?></span></h4>
                <small><?php @session_start(); echo $_SESSION['cargo']; ?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="menuFuncionario.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="" class="active">
                            <span class="las la-user-alt"></span>
                            <small>Estoque</small>
                        </a>
                    </li>
                     <li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class="las la-search"></span>
                    </label>
                    
                    <div class="notify-icon">
                        <span class="las la-envelope"></span>
                        <span class="notify">4</span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <span class="las la-power-off"></span>
                        <a href="src/controller/logoutController.php"><span>Logout</span></a>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Produtos</h1>
            </div>
            
            <div class="page-content">
                <div class="records table-responsive">
                    <div class="record-header">
                    <div class="add">
    <span>Entries</span>
    <select name="" id="">
        <option value="">ID</option>
    </select>
    <form action="manteringredientes.php" method="get">
        <button type="submit">Adicionar Ingrediente</button>
    </form>
</div>

                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
                            <select name="" id="">
                                <option value="">Status</option>
                            </select>
                        </div>
                    </div>

                    <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><span class="las la-sort"></span> Nome</th>
                                <th><span class="las la-sort"></span> Valor Unidade</th>
                                <th><span class="las la-sort"></span> Quantidade</th>
                                <th><span class="las la-sort"></span> Valor Total</th>
                                <th><span class="las la-sort"></span> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($listaFuncionarios) && !empty($listaFuncionarios)) {
                                foreach ($listaFuncionarios as $funcionario) {
                                    echo '<tr>';
                                        echo '<td>' . $funcionario['id'] . '</td>';
                                        echo '<td>';
                                            echo '<div class="client">';
                                                echo '<div class="client-info">';
                                                    echo '<h4>' . $funcionario['nome'] . '</h4>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</td>';
                                        echo '<td>'; 
                                            echo '<small>' . $funcionario['custo'] . '</small>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<small>' . $funcionario['quantidade_estoque'] . '</small>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<small>R$' . $funcionario['valor_total'] . '</small>';
                                    echo '</td>';
                                        echo '<td>';
                                            echo '<div class="actions">';
                                                echo '<a class="btn btn-success" href="manteringredientes.php?id=' . htmlspecialchars($funcionario['id']) . '&cmd=edit">
                                                        <span class="la la-edit" title="Editar"></span>
                                                      </a> | ';
                                                echo '<a class="btn btn-danger" href="?id=' . htmlspecialchars($funcionario['id']) . '&cmd=delete" class="btn btn-danger">
                                                        <span class="la la-trash" title="Excluir"></span>
                                                      </a>';
                                            echo '</div>';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">Nenhum funcionário encontrado</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            
        </main>
        
    </div>
</body>
