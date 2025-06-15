<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Obter Preços</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<button id="getPrice">Obter Preços</button>
<div id="priceDisplay"></div>

<script>
$(document).ready(function() {
    $('#getPrice').click(function() {
        $.ajax({
            url: 'src/controller/priceController.php', // Caminho para o seu script PHP
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    // Limpa a exibição anterior
                    $('#priceDisplay').empty();

                    // Itera sobre os resultados e exibe cada nome e preço
                    response.forEach(function(item) {
                        if (item.error) {
                            $('#priceDisplay').append(`<p>Erro na URL: ${item.url} - ${item.error}</p>`);
                        } else {
                            $('#priceDisplay').append(`
                                <p>
                                    Produto: ${item.product_name}<br>
                                    Menor Preço: ${item.min_price}
                                </p>
                            `);
                        }
                    });
                } else {
                    $('#priceDisplay').text('Nenhum dado encontrado.');
                }
            },
            error: function() {
                $('#priceDisplay').text('Erro ao obter os dados.');
            }
        });
    });
});
</script>

</body>
</html>
