<?php
require_once 'functions.php';
use Illuminate\Database\Capsule\Manager as DB;

if($acceso == 1)
{
    echo'
    <body onload="alumnos()">
    ';
}
else {
    echo'
    <body onload="calificación()">
    ';
}

if($loggedin){
    require_once 'header.php';
    echo'
    <div class="container">
    ';

    if($acceso == 1)
    {
        echo'
        <div class="hero">
            <div class="hero-body">
                <h1 class="title has-text-centered is-size-2">Añade calificaciones</h1>
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
                                <button type="button" onclick="añadir()" class="button is-link mt-3">Añadir</button>
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
        $calificaciones = DB::table('materias')->where('users_id_user', $id)->first();

        echo'
        <div class="hero">
            <div class="hero-body">
                <h1 class="title has-text-centered is-size-2">Calificaciones</h1>
                <div class="columns is-centered">
                    <div class="column is-half">
                        <div class="notification is-light">
                            <form>
                                <div class="field">
                                    <div class="control">
                                        <input class="input is-hidden" type="text" id="id" placeholder="id" value="'.$id.'" readonly>
                                    </div>
                                    <label class="label mt-4">Español</label>
                                    <div class="control">
                                        <input class="input" type="number" max="10" id="español" placeholder="Español" readonly>
                                    </div>
                                    <label class="label mt-4">Matemáticas</label>
                                    <div class="control">
                                        <input class="input" type="number" max="10" id="matematicas" placeholder="Matemáticas" readonly>
                                    </div>
                                    <label class="label mt-4">Historia</label>
                                    <div class="control">
                                        <input class="input" type="number" max="10" id="historia" placeholder="Historia" readonly>
                                    </div>
                                    <label class="label mt-6">Promedio General</label>
                                    <div class="control">
                                        <input class="input" type="number" max="10" id="promedio" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
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
                else
                {
                }
            })
            .catch(error => {
                console.log(error);
            });
        }

        function añadir()
        {
            axios.post(`api/index.php/añadir`, {
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

        function calificación()
        {
            axios.post(`api/index.php/calificaciones`, {
                id: document.getElementById("id").value
            })
            .then(resp => {
                if(resp.data.user == 1)
                {
                    document.getElementById("español").value = resp.data.español;
                    document.getElementById("matematicas").value = resp.data.matematicas;
                    document.getElementById("historia").value = resp.data.historia;
                    document.getElementById("promedio").value = resp.data.promedio;
                }
                else
                {
                    alert(resp.data.respuesta)
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