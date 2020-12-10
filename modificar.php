<?php
require_once 'functions.php';

echo'
<body onload="alumnos()">
';


if($loggedin)
{
    require_once 'header.php';
echo'<div class="container">';
    if($acceso == 1)
    {
        echo'
        <div class="hero">
            <div class="hero-body">
                <h1 class="title has-text-centered is-size-2">Elimina calificaciones</h1>
                <div class="columns is-centered">
                    <div class="column is-half">
                        <div class="notification is-light">
                            <form>
                                <div class="field">
                                    <label class="label mt-4">Alumno</label>
                                    <div class="select is-medium">
                                        <select id="alumno" required>
                                        </select>
                                    </div>
                                    <label class="label mt-4">Español</label>
                                    <div class="control">
                                        <input class="input" type="number" id="español" placeholder="Español">
                                    </div>
                                    <label class="label mt-4">Matemáticas</label>
                                    <div class="control">
                                        <input class="input" type="number" id="mate" placeholder="Matemáticas">
                                    </div>
                                    <label class="label mt-4">Historia</label>
                                    <div class="control">
                                        <input class="input" type="number" id="historia" placeholder="Historia">
                                    </div>
                                </div>
                                <button type="button" onclick="modificar()" class="button is-link mt-3">Modificar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
    }
    else
    {
        echo"<p class='is-size-5 is-center mt-6'>No tienes permisos para estar aquí <a href='index.php'>click aquí para regresar al inicio</a></p>";
    }
}
else{
    echo"<p class='is-size-5 is-center mt-6'>Necesitas una cuenta para usar este sistema <a href='login.php'>click aquí para regresar al login</a></p>";
}

echo'
    <script>
        function alumnos()
        {
            axios.post(`api/index.php/alumnos`, {
            })
            .then(resp => {
                if(resp.data.validar)
                {
                    const alumnos = resp.data.alumnos;
                    alumnos.forEach(alumnos => {
                        var select = document.getElementById("alumno");

                        var optionAlumno=document.createElement("option");

                        optionAlumno.setAttribute("value",alumnos.id_user);
                        optionAlumno.setAttribute("label",alumnos.name + " " + alumnos.ape);

                        // Añadimos el option al select
                        select.appendChild(optionAlumno);
                    });
                }
            })
            .catch(error => {
                console.log(error);
            });
        }

        function modificar()
        {
            axios.post(`api/index.php/modificar`, {
                id_user: document.forms[0].alumno.value,
                español: document.forms[0].español.value,
                mate: document.forms[0].mate.value,
                historia: document.forms[0].historia.value
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
?>