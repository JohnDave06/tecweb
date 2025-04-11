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

    /*
     // Esta es la version del video de SLim v3 por eso no funciona el siguiente código
    $app->post("/puebapost", function ($request , $response, $args){

         $reqPost = $request->getParsedBody(); // obtener el cuerpo de la petición POST
         $val1 = $reqPost["valor1"]; // obtener el valor del campo valor1
         $val2 = $reqPost["valor2"]; // obtener el valor del campo valor2
        
         $response->write( "valores:" . $val1 . " " . $val2); // escribir en la respuesta
         return $response; // devolver la respuesta
    });
 */
     // Esta es la versión correcta para Slim 4
    $app->post("/puebapost", function (Request $request, Response $response, $args) {
        $reqPost = $request->getParsedBody(); // obtener el cuerpo de la petición POST
        $val1 = $reqPost["valor1"]; // obtener el valor del campo valor1
        $val2 = $reqPost["valor2"]; // obtener el valor del campo valor2
        
        $response->getBody()->write("valores:" . $val1 . " " . $val2); // escribir en la respuesta
        return $response; // devolver la respuesta
    });

     $app->run(); // ejecutar el servidor web Slim 4

?>