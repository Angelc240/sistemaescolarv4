<?php
require_once 'functions.php';

echo'
<body>
    <div class="container">
';

$error = $usuario = "";

if(!$loggedin){

    echo'
        <div class="hero">
            <div class="hero-body">
                <h1 class="title has-text-centered is-size-2">Inicia sesión</h1>
                <div class="columns is-centered">
                    <div class="column is-half">
                        <div class="notification is-light">
                            <form>
                                <div class="field">
                                    <label class="label">Usuario</label>
                                    <input class="input" type="text" placeholder="Usuario" id="user">
                                </div>
                                <div class="field">
                                    <label class="label">Contraseña</label>
                                    <input class="input" type="password" placeholder="Contraseña" id="pass">
                                </div>
                                <a type="button" onclick="login()" class="button is-info is-rounded is-outlined mt-2">Iniciar sesión</a>
                                <a href="singup.php" class="button is-warning is-rounded is-outlined mt-2">Regístrate</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}
else{

    die('<p class="is-size-4 has-text-centered mt-6">Usted tiene una sesión activa <a href="index.php">click aquí</a> para ir al sistema</p>
        </div></body></html>');

}

echo'
    <script>
        function login()
        {
            axios.post(`api/index.php/login`, {
                user: document.forms[0].user.value,
                pass: document.forms[0].pass.value
            })
            .then(resp => {
                alert(resp.data.respuesta)
                if(resp.data.inicio_sesion)
                {
                    location.href=`api/index.php/login/${resp.data.user}`;
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    </script>

    </body>
</html>
';