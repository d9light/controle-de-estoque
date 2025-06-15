<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doces</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            height: 100%;
        }

        .background {
            display: flex;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            width: 100%;
            background: linear-gradient(to right, #F3BA9E 50%, #BC8ADF 50%);
            box-sizing: border-box;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .logo img {
            margin-right: 10px;
        }

        .nav {
        display: flex;
         justify-content: center;
         align-items: center;
         color: #333333;
         gap: 5vw; 
        font-weight: bold;
        background-color: transparent;
}


        .nav a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }

        .nav a:hover {
            color: #F3BA9E;
        }

        .left-side {
            flex: 1;
            background-color: #F3BA9E;
            display: flex;
            flex-direction: column;
            padding: 20px;
            color: #333;
        }

        .right-side {
            flex: 1;
            background: linear-gradient(to top, #664B79, #BC8ADF);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }

        .content h2 {
            font-size: 28px;
            margin: 0;
        }

        .content img {
            margin-left: 20%;
            pointer-events: none; /* Para que a borda não interfira com cliques na imagem */
             }

        .content p {
            font-size: 18px;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho que ocupa a largura completa -->
    <header class="header">
        <div class="logo">
            <img width="100px" src="/src/img/LogoPreta.png" alt="Logo">
            <span>Doces</span>
        </div>
        <nav class="nav">
            <a href="#">Home</a>
            <a href="#">Sobre</a>
            <a href="#">Contatos</a>
        </nav>
    </header>

    <div class="background">
        <!-- Esquerda - Fixa a cor sólida #F3BA9E -->
        <div class="left-side"></div>

        <!-- Direita - Aplica o gradiente vertical -->
        <div class="right-side">
            <main class="content">

            <img src="/src/img/brigadeiro.png" width="600px" alt="Imagem 1">

            </main>
        </div>
    </div>

</body>
</html>
