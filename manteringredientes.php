<!doctype html>
<html lang="en">

<head>
    <title>Manter Ingredientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <nav class="nav justify-content-center h1 ">
            <a class="nav-link active" href="menuProdutos.php" aria-current="page">Produtos Page</a>
        </nav>
    </header>
    <main class="container mt-5">

        <?php
        use Controller\ingredientesController;
        use Model\ingredientesModel;

        require_once 'vendor/autoload.php';

        $ingredientes = new ingredientesController();
            if ($_REQUEST) {
            // Verifica se o parâmetro 'id' foi passado na requisição
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                // Carrega o objeto ingrediente com base no ID
                $objetoIngrediente = $ingredientes->loadById($id);
        
                // Verifica se o código de ação é 'excluir'
                if (isset($_REQUEST['cod']) && $_REQUEST['cod'] == 'excluir') {
                    // Exclui o ingrediente com o ID fornecido
                    $ingredientes->delete($id);
                }
            }
        }
        

            if (@$_REQUEST['cod'] == 'success') {
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Registro inserido com sucesso.</strong>
                </div>';
            } else if (@$_REQUEST['cod'] == 'error') {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Ocorreu um erro.</strong>
                </div>';
            }
        ?>

        <!-- Botão e select para buscar preços -->
        <select id="productSelect" class="form-select mb-3">
            <option value="">Selecione um produto</option>
        </select>
        <button id="getPrice" class="btn btn-primary mb-3">Obter Produtos</button>

        <!-- Formulário -->
        <form method="post" action="<?php $ingredientes->save(); ?>">
            <input type="hidden" name="id" value="<?php echo(empty($objetoIngrediente)? '': $objetoIngrediente->getId());?>">
            <div class="mb-3">
                <label for="productName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="productName" name="nome"
                       value="<?php echo(empty($objetoIngrediente)? '': $objetoIngrediente->getNome());?>"
                       placeholder="Insira o nome do produto" />
            </div>
            <div class="mb-3">
                <label for="productCost" class="form-label">Custo</label>
                <input type="text" class="form-control" id="productCost" name="custo"
                       value="<?php echo(empty($objetoIngrediente)? '': $objetoIngrediente->getCusto());?>"
                       placeholder="Insira o custo" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" name="quantidade_estoque"
                       value="<?php echo(empty($objetoIngrediente)? '': $objetoIngrediente->getQuantidade_estoque());?>"
                       placeholder="Insira a quantidade em estoque" />
            </div>
            <input type="submit" value="Salvar" class="btn btn-success">
        </form>

    </main>

    <script>
        $(document).ready(function() {
            // Obter preços e popular o select
            $('#getPrice').click(function() {
                $.ajax({
                    url: 'src/controller/priceController.php', // Caminho para o seu script PHP
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            // Limpa as opções anteriores
                            $('#productSelect').empty();
                            $('#productSelect').append('<option value="">Selecione um produto</option>');

                            // Adiciona os produtos ao select
                            response.forEach(function(item) {
                                if (!item.error) {
                                    $('#productSelect').append(`
                                        <option value="${item.min_price}" data-name="${item.product_name}">
                                            ${item.product_name} - ${item.min_price}
                                        </option>
                                    `);
                                }
                            });
                        } else {
                            alert('Nenhum dado encontrado.');
                        }
                    },
                    error: function() {
                        alert('Erro ao obter os dados.');
                    }
                });
            });

            // Preencher campos ao selecionar um produto
            $('#productSelect').change(function() {
                const selectedOption = $(this).find('option:selected');
                const productName = selectedOption.data('name');
                const productCost = $(this).val();

                // Preenche os campos "Nome" e "Custo"
                $('#productName').val(productName || '');
                $('#productCost').val(productCost || '');
            });
        });
    </script>
</body>

</html>
