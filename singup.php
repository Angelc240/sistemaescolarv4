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
                <h1 class="title has-text-centered is-size-2">Regístrate</h1>
                <div class="columns is-centered">
                    <div class="column is-half">
                        <div class="notification is-light">
                            <form>
                                <div class="field">
                                    <label class="label">Usuario</label>
                                    <input class="input" type="text" placeholder="Usuario" id="user">
                                </div>
                                <div class="field">
                                    <label class="label">Nombre(s)</label>
                                    <input class="input" type="text" placeholder="Nombre(s)" id="nombre">
                                </div>
                                <div class="field">
                                    <label class="label">Apellido(s)</label>
                                    <input class="input" type="text" placeholder="Apellido(s)" id="apellido">
                                </div>
                                <div class="field">
                                    <label class="label">Contraseña</label>
                                    <input class="input" type="password" placeholder="Contraseña" id="pass">
                                </div>
                                <a type="button" onclick="singup()" class="button is-info is-rounded is-outlined mt-2">Regístrate</a>
                                <a href="login.php" class="button is-warning is-rounded is-outlined mt-2">Iniciar sesión</a>
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
        function singup()
        {
            axios.post(`api/index.php/singup`, {
                nombre: document.forms[0].nombre.value,
                apellido: document.forms[0].apellido.value,
                user: document.forms[0].user.value,
                pass: document.forms[0].pass.value
            })
            .then(resp => {
                alert(resp.data.respuesta)
            })
            .catch(error => {
                console.log(error);
            });
        }
    </script>

    </body>
</html>
';