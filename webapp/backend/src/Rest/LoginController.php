<?php
namespace DogtorPET\Backend\Rest;

use DogtorPET\Backend\Util\DataSource;
use DogtorPET\Backend\Modelos\Usuario;
use DogtorPET\Backend\Util\Config;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PsrJwt\Factory\Jwt;
use PDOException;
use PDO;

class LoginController {

    public function login(Request $req, Response $res, array $args): Response {
        try  {
            $credenciales = json_decode( $req->getBody(), true );
            $conexion = DataSource::abrirConexion();
            $sentencia = $conexion->prepare( Usuario::SQL_SELECT_LOGIN );
            $sentencia->bindParam(1, $args['username']);
            $sentencia->bindParam(2, $args['password']);
            $sentencia->execute();
            $resultset = $sentencia->fetch( PDO::FETCH_ASSOC );
            if( $resultset ) {
                // Generar el token JWT una vez creada la sesión del usuario
                $factory = new Jwt();
                $config = Config::obtenerInstancia();
                $builder = $factory->builder();
                $token = $builder->setSecret( $config->jwtSecret() )
                    ->setPayloadClaim('username', $credenciales['username'])
                    ->setExpiration( time() + (3600 * 2)  )
                    ->build();
                $res->getBody()->write( json_encode(['token' => $token->getToken()]) );
                return $res->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
            $mensaje = [ 'codigo' => 'error', 'mensaje' => 'Login inválido' ];
            $res->getBody()->write( json_encode( $mensaje ) );
            return $res->withHeader('Content-Type', 'application/json')->withStatus(401);
        } catch(PDOException $e) {
            return $this->enviarExcepcion($req, $res, $e);
        }
    }

    private function enviarExcepcion(Request $req, Response $res, PDOException $e): Response {
        $mensaje = [ 'codigo' => $e->getCode(), 'mensaje' => $e->getMessage() ];
        $res->getBody()->write( json_encode( $mensaje ) );
        return $res->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

}


?>
