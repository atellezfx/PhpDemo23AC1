<?php
namespace DogtorPET\Backend\Util;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class Config {

    ##  PATRÓN DE DISEÑO SINGLETON #################################
    private static Config $instancia;

    private function __construct() { }

    public static function obtenerInstancia(): Config {
        // Lazy loading
        if( !isset( self::$instancia ) ) self::$instancia = new Config();
        return self::$instancia;
    }
    ################################################################

    public function directorioBase(): string {
        return dirname(__DIR__, 2);
    }

    public function cargarParametros(): array {
        $archivo = $this->directorioBase() . '/src/params.ini';
        return parse_ini_file($archivo, true);
    }

    public function jwtSecret(): string {
        $params = $this->cargarParametros();
        return $params['jwt']['secret'];
    }

    public function crearLog(): Logger {
        $log = new Logger('DogtorPET');
        $archivo = $this->directorioBase() . '/logs/mensajes.log';
        $handler = new StreamHandler( $archivo, Level::Debug );
        $log->pushHandler( $handler );
        return $log;
    }

}

?>