<?php
namespace PlaceToPay\SDKPSE\Cache;

use PlaceToPay\SDKPSE\Helpers\Error;

/**
 * Clase que provee metodos para manipular los datos de la cache
 *
 * El servidor de cache que se utiliza se encuentra configurado
 * en el atributo "type" del array solicitado en el constructur de la calse
 * 
 * Genera una excepcion cuando no se envia por parametro al intancias
 * la clase el tipo de cache a utilizar
 * 
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Cache implements CInterface
{
	/**
	 * $objServer Contiene la instancia del objeto de cache
	 * @var CMemcached
	 */
	private $objServer;
    
    /**
     * __construct 
     * @param array $cache 	configuracion de la cache, los indices deben ser:
     *                      [
     *                     		"type" => 
     *                     			"Sistema de cache a utilizar, puede ser:
     *                     			memcached o apcu",
     *                     	 	"memcached" => [
     *                     	 		"host" => "Host del servidor",
     *                     	 		"port" => "puerto del servidor"
     *                     	 	]
     *                      ]
     */
    public function __construct($cache)
    {	
    	$type = strtoupper($cache['type']);
        switch ($type) {
        	case 'MEMCACHED':
        		$this->objServer = new CMemcached($cache['memcached']);
        		break;
        	case 'APCU':
        		$this->objServer = new CAPCU;
        		break;
        	default:
        		Error::newException('Error debe configurar el tipo cache');
        		break;
        }
    }

     /**
	 * add Adicionar un item a una nueva clave
	 * 
	 * @param string $key 		La clave en la que se guardará el valor
	 * @param mixed $value 		El valor a guardar
	 * @param int $expiration 	Tiempo de expiracion en segundos
	 * @return boolean 			true si se adiciono correctamente o 
	 *                         	false en caso contrario
	 */
    public function add($key, $value, $expiration)
	{
		return $this->objServer->add(
			$key,
			json_encode($value),
			$expiration
		);
	}

	/**
	 * get Obtener un item
	 * 
	 * @param string $key 	La clave del item a obtener
	 * @return mixed 		Devuelve el valor obtenido o 
	 *                      false si el item no existe
	 */
	public function get($key)
	{
		$data = $this->objServer->get($key); 
		return $data === false ? false : json_decode($data);
	}

	/**
	 * delete Elimina un item
	 * 
	 * @param string $key 	La clave del item a eliminar
	 * @return boolean 		Devuelve true si se adiciono correctamente o
	 *                      false en caso contrario
	 */
	public function delete($key)
	{
		return $this->objServer->delete($key);
	}
}