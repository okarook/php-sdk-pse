<?php
namespace PlaceToPay\SDKPSE\Helpers;

use \Exception;

/**
 * Clase que provee metodos para manipular los errores de la libreria
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Error
{
    /**
     * newException Lanza una \Exception con el mensaje pasado
     *
     * @param string $message   Mensaje que se muestra en el error
     */
    public static function newException($message)
    {
    	throw new Exception($message);
    }
}
