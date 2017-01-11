<?php
namespace PlaceToPay\SDKPSE\Configs;

use PlaceToPay\SDKPSE\Helpers\Error;
use PlaceToPay\SDKPSE\Helpers\Helper;

/**
 * Clase que provee metodos para manipular la configuracion
 * 
 * El archivo de configuracion config.json debe estar creado
 * en la carpeta raiz del proyecto
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Config
{
    /**
     * get Obtener la configuracion.
     * 
     * Si la configuracion no existe se genera una excepcion 
     * 
     * @param  string $key La clave de la configuracion a obtener
     * @return string      Devuelve el valor de la configuracion
     */
    public static function get($key)
    {
        # Obtener las configuraciones
        $content = file_get_contents(Helper::path() . 'config.json');
        $data = json_decode($content, true);

        $keys = explode('.', $key);
    	foreach ($keys as $row) {
    		if (isset($data[$row])) {
    			$data = $data[$row];
    		} else {
    			Error::newException(
    				"No se encontro la configuracion [$key]"
    			);
    		}
    	}

        return $data;
    }
}