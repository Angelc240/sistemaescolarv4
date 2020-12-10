<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/sistmeaescolarv4/api/index.php");

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->post('/login', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $consultar = DB::table('users')->where('user', $data->user)->first();

    $msg = new stdClass();

    if($consultar)
    {
        if($consultar->pass == $data->pass)
        {
            $msg->respuesta = "Inicio de sesión exitoso";
            $msg->inicio_sesion = true;
            $msg->user = $data->user;
        }
        else
        {
            $msg->respuesta = "Contraseña incorrecta";
        }
    }
    else
    {
        $msg->respuesta = "Ese usuario no existe";
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->get('/login/{user}', function (Request $request, Response $response, array $args) {

    $msg = "Iniciando sesión...";

    require_once '../functions.php';

    $_SESSION['user'] = $args['user'];
    echo'<meta http-equiv="Refresh" content="0;url=../../../index.php">';

    $response->getBody()->write($msg);
    return $response;
});

$app->post('/singup', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $consultar = DB::table('users')->where('user', $data->user)->first();

    $msg = new stdClass();

    if($consultar)
    {
        $msg->respuesta = "Esa usuario ya existe, escoja otro";
    }
    else
    {
        $insertar = DB::table('users')->insertGetId(
            ['user' => $data->user, 'pass' => $data->pass, 'acceso' => 2, 'name' => $data->nombre, 'ape'=> $data->apellido]
        );

        if($insertar)
        {
            $msg->respuesta = "Te has registrado con éxito";
        }
        else
        {
            $msg->respuesta = "Algo ha ido mal :(";
        }
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/alumnos', function (Request $request, Response $response, array $args) {

    $users = DB::table('users')->select(['id_user', 'name', 'ape'])->where('acceso',"<>",1)->orderBy('ape')->get();

    $msg = new stdClass();

    if($users)
    {
        $msg->validar = true;
        $msg->alumnos = $users;
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/calificaciones', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $users = DB::table('materias')->where('users_id_user', $data->id)->first();

    $msg = new stdClass();

    if($users)
    {
        $msg->user = 1;
        $msg->español = $users->español;
        $msg->matematicas = $users->matematicas;
        $msg->historia = $users->historia;
        $msg->promedio = ($users->español + $users->historia + $users->matematicas)/3;
    }
    else
    {
        $msg->user = 2;
        $msg->respuesta = "No tienes calificaciones";
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/añadir', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $msg = new stdClass();

    if($data->mate == "" || $data->español == "" || $data->historia == "")
    {
        $msg->respuesta = "Faltan datos";
    }
    else {

        $user = $data->id_user;

        $validar = DB::table('materias')->where('users_id_user', $user)->first();

        if(!$validar)
        {
            $insertar = DB::table('materias')->insert(
                ['users_id_user' => $user, 'matematicas' => $data->mate, 'español' => $data->español, 'historia' => $data->historia]
            );

            if($insertar)
            {
                $msg->respuesta = 'Calificaciones del alumno añadidas';
            }
        }
        else {
            $msg->respuesta = 'Ese alumno ya tiene calificaciones';
        }
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/modificar', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $msg = new stdClass();

    if($data->mate == "" || $data->español == "" || $data->historia == "")
    {
        $msg->respuesta = "Faltan datos";
    }
    else {
        $user = $data->id_user;

        $modificar = DB::table('materias')
        ->where('users_id_user', $user)
        ->update(
            ['matematicas' => $data->mate, 'español' => $data->español, 'historia' => $data->historia]
        );

        if($modificar)
        {
            $msg->respuesta = 'Calificaciones del alumno modificadas';
        }
        else {
            $msg->respuesta = 'El alumno ya tenía esas calificaciones, ponga calificaciones diferentes';
        }
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});

$app->post('/eliminar', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody()->getContents(), false);

    $msg = new stdClass();

    $existe = DB::table('materias')->where('users_id_user', $data->id)->first();

    if($existe)
    {
        DB::table('materias')->where('users_id_user', $data->id)->delete();
        $msg->respuesta = "Calificaciones eliminadas";
    }
    else {
        $msg->respuesta = "Ese alumno no tiene calificaciones";
    }

    $response->getBody()->write(json_encode($msg));
    return $response;
});


// Run application
$app->run();