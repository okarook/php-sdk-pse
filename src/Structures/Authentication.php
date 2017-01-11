<?php
namespace PlaceToPay\SDKPSE\Structures;

/**
 * Estructura para autenticarse con el webservice.
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Authentication
{
	/**
	 * $login Identificador habilitado para el consumo del API, entregado 
	 * por Place to Pay
	 * @var string
	 */
    public $login;
    
    /**
	 * $tranKey Llave transaccional para el consumo del API
	 * @var string
	 */
    public $tranKey;

    /**
	 * $seed Semilla usada para el consumo del API en el proceso del hash
	 * por SHA1 del tranKey, ISO 8601
	 * @var string
	 */
    public $seed;

    /**
	 * $additional Datos adicionales a la estructura de autenticacion 
	 * @var array(
	 *      PlaceToPay\SDKPSE\Structures\Attribute
	 *      , ...)
	 */
    public $additional;
}
