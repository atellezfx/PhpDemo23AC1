<?php
namespace DogtorPET\Backend\Rest;

use DogtorPET\Backend\Util\DataSource;
use DogtorPET\Backend\Modelos\Mascota;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;
use PDO;

class MascotaController {

    public function obtener(Request $req, Response $res, array $args): Response {
        try  {
            $conexion = DataSource::abrirConexion();
            $sentencia = $conexion->prepare( Mascota::SQL_SELECT_MASCOTA_POR_ID );
            $sentencia->bindParam(1, $args['id']);
            $sentencia->execute();
            $sentencia->setFetchMode( PDO::FETCH_CLASS, Mascota::class );
            $mascota = $sentencia->fetch();
            $res->getBody()->write( json_encode( $mascota ) );
            return $res->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch(PDOException $e) {
            return $this->enviarExcepcion($req, $res, $e);
        }
    }

    public function lista(Request $req, Response $res, array $args): Response {
        try  {
            $conexion = DataSource::abrirConexion();
            $sentencia = $conexion->prepare( Mascota::SQL_SELECT_MASCOTA_POR_PROPIETARIO );
            $sentencia->bindParam(1, $args['propietario']);
            $sentencia->execute();
            $sentencia->setFetchMode( PDO::FETCH_CLASS, Mascota::class );
            $mascotas = $sentencia->fetchAll();
            $res->getBody()->write( json_encode( $mascotas ) );
            return $res->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch(PDOException $e) {
            return $this->enviarExcepcion($req, $res, $e);
        }
    }

    public function insertar(Request $req, Response $res, array $args): Response {
        try  {
            $conexion = DataSource::abrirConexion();
            $sentencia = $conexion->prepare( Mascota::SQL_INSERT_MASCOTA );
            $sentencia->bindParam(1, $args['nombre']);
            $sentencia->bindParam(2, $args['propietario']);
            $sentencia->bindParam(3, $args['fechaNac']);
            $sentencia->bindParam(4, $args['raza']);
            $sentencia->bindParam(5, $args['color']);
            $sentencia->bindParam(6, $args['genero']);
            $sentencia->bindParam(7, $args['tipo']);
            $sentencia->bindParam(8, $args['fotoUrl']);
            $sentencia->execute();
            $id = $conexion->lastInsertId();
            return $this->obtener($req, $res, ['id'=>$id]);
        } catch(PDOException $e) {
            return $this->enviarExcepcion($req, $res, $e);
        }
    }

    public function actualizar(Request $req, Response $res, array $args): Response {
        try  {
            $conexion = DataSource::abrirConexion();
            $sentencia = $conexion->prepare( Mascota::SQL_UPDATE_MASCOTA );
            $sentencia->bindParam(1, $args['nombre']);
            $sentencia->bindParam(2, $args['propietario']);
            $sentencia->bindParam(3, $args['fechaNac']);
            $sentencia->bindParam(4, $args['raza']);
            $sentencia->bindParam(5, $args['color']);
            $sentencia->bindParam(6, $args['genero']);
            $sentencia->bindParam(7, $args['tipo']);
            $sentencia->bindParam(8, $args['fotoUrl']);
            $sentencia->bindParam(9, $args['id']);
            $sentencia->execute();
            return $this->obtener($req, $res, $args);
        } catch(PDOException $e) {
            return $this->enviarExcepcion($req, $res, $e);
        }
    }

    public function eliminar(Request $req, Response $res, array $args): Response {
        try  {
            $conexion = DataSource::abrirConexion();
            // Obtener el registro antes de eliminarlo
            $sentencia = $conexion->prepare( Mascota::SQL_SELECT_MASCOTA_POR_ID );
            $sentencia->bindParam(1, $args['id']);
            $sentencia->execute();
            $sentencia->setFetchMode( PDO::FETCH_CLASS, Mascota::class );
            $mascota = $sentencia->fetch();

            $sentencia = $conexion->prepare( Mascota::SQL_DELETE_MASCOTA );
            $sentencia->bindParam(1, $args['id']);
            $sentencia->execute();

            $res->getBody()->write( json_encode( $mascota ) );
            return $res->withHeader('Content-Type', 'application/json')->withStatus(200);
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
