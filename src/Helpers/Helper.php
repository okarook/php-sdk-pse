<?php
namespace PlaceToPay\SDKPSE\Helpers;

/**
 * Clase que provee metodos de ayudas genericas
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Helper
{
    /**
     * path Ruta base del proyecto excluyendo el directorio src/
     * 
     * @return String Ruta base del proyecto
     */
    public static function path()
    {
    	return substr(__DIR__, 0, -11);
    }

    /**
     * seed Semilla para el consumo del webservice
     * 
     * @return String Semilla
     */
    public static function seed()
    {
    	return date('c');
    }

    /**
     * tranKey Llave transaccional para el consumo del webservice
     * 
     * @param  String $seed    Semilla para la autenticacion del webservice
     * @param  String $tranKey Llave originalmente enviado por PlacetoPay
     * @return String          Llave transaccional
     */
    public static function tranKey($seed, $tranKey)
    {
    	return sha1($seed . $tranKey,false);
    }
}
