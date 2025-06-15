<?php

use Controller\UsuarioController;

require_once './vendor/autoload.php';

$user = new UsuarioController();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login</title>D
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>


<style>
body {
    background-image: url('src/img/fundo.jpg'); 
    background-size: cover; 
    background-repeat: no-repeat; 
    background-attachment: fixed; 
    background-position: center; 
    backdrop-filter: blur(8px); /* Aplica o desfoque ao fundo */

}
</style>


</style>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container">
            <section class="vh-100 gradient-custom">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">

                                    <div class="mb-md-5 mt-md-4 pb-5">

                                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                        <p class="text-white-50 mb-5">Coloque seu email e seu login!</p>


                                        <form method="post" action="<?php $user->login(); ?>">
            
                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                            <input type="email" name="email" id="email" class="form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Email</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline form-white mb-4">

                                            <input type="password" name="senha" class="form-control form-control-lg" />
                                            <label class="form-label" for="typePasswordX">Password</label>
                                        </div>


                                        <input data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" value="Login" type="submit"></input>
                                        </form>
                                        <div class=" justify-content  mt-4 pt-1">
                                       

                                        <?php
                                        @$cod = $_REQUEST['cod'];

                                        if ($cod == 'error') {
                                            echo'<p class="alert alert-danger">Usuário inválido</p>';
                                        }

                                        if ($cod == '172') {
                                            echo'<p class="alert alert-warning">Usuário expirado</p>';
                                        }
                                        ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>
</html>
