<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;     

    require 'vendor/autoload.php';

    $app = AppFactory::create();
    $app->setBasePath("/tecweb/practicas/p17"); 

/*
     // esta version es del video de SLim v3 por eso no funciona el siguiente código
    $app->get('/', function ( $request, $response , $args ) 
    {
        $response->write("hola mundo Slim v3");
        return $response;
    });
 */
     // Esta es la versión correcta para Slim 4
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("hola mundo Slim v4");
        return $response;
    });

    /*  
    // esta version es del video de SLim v3 por eso no funciona el siguiente código
    $app->get('/hola/{nombre}', function ( $request, $response , $args ) 
    {}
        $response->write("Hola, " . $args["nombre]. "!");
        return $response;
    });
 */

     // Esta es la versión correcta para Slim 4 lectura de url
    $app->get('/hola/{nombre}', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hola, " . $args["nombre"] . "!");
        return $response;
    });

     $app->run(); // ejecutar el servidor web Slim 4

?>