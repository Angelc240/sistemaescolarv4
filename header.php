<?php

require_once 'functions.php';

echo'
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="true">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                <a href="index.php" class="navbar-item ml-2 mt-2 mb-2">Inicio</a>
                ';

                if($acceso == 1)
                {
                    echo'
                    <a href="modificar.php" class="navbar-item ml-2 mt-2 mb-2">Modificar</a>

                    <a href="eliminar.php" class="navbar-item ml-2 mt-2 mb-2">Eliminar</a>';
                }
                echo'
                <a href="logout.php" class="navbar-item ml-2 mt-2 mb-2">Cerrar sesión</a>

            </div>
        </div>
    </nav>
';
?>
