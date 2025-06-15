<?php

namespace Controller;

use Model\ingredientesModel;

 
require 'C:/Users/d9light/Desktop/TrabalhoBrasil/vendor/autoload.php';



class ingredientesController
{

    
    public function __construct() {

    }

    public function loadById($id)
    {
        $ingredientes = new ingredientesModel;
        $ingredientes = $ingredientes->loadById($id); //loadbyId está na model agora e retorna um objeto do tipo usuário
        return $ingredientes;
    }

    public function loadAll()
    {
        $ingredientes = new ingredientesModel;
        $result = $ingredientes->loadAll(); //$result é uma array que retorna do banco de dados.
        return $result;
    }

    public function delete($id)
    {
        $ingredientes = new ingredientesModel;
        
        // Tenta excluir o ingrediente e armazena o resultado
        $result = $ingredientes->delete($id);
    
        // Verifica se a exclusão foi bem-sucedida
        if ($result) {
            // Se o ingrediente foi excluído com sucesso, redireciona para a lista com sucesso
            header('Location: menuProdutos.php?cod=success');
            exit; // Encerra o script após o redirecionamento
        } else {
            // Caso contrário, redireciona para a lista com erro
            header('Location: menuProdutos.php?cod=error');
            exit; // Encerra o script após o redirecionamento
        }
    }
    

    public function save()
    {
        if ($_POST) {
            $ingredientes = new ingredientesModel();
            $ingredientes->setId($_POST['id']);
            $ingredientes->setNome($_POST['nome']);
            $ingredientes->setCusto($_POST['custo']);
            $ingredientes->setQuantidade_estoque($_POST['quantidade_estoque']);
            
            
            if ($ingredientes->save()) {
                // Redireciona com sucesso
                header('Location: /manteringredientes.php?cod=success');
            } else {
                // Redireciona com erro
                header('Location: /manteringredientes.php?cod=error');
            }
            exit; // Termina a execução após redirecionar
        }
    }
    
    public function exibirValorTotal()
    {
        // Cria uma instância da Model
        $ingredientes = new ingredientesModel();
    
        // Chama a função da Model para calcular o valor total
        $valorTotal = $ingredientes->calcularTotal();
    
        // Exibe o resultado formatado
        echo "O valor total dos ingredientes é: R$ " . number_format($valorTotal, 2, ',', '.');
    }
    

}

?>