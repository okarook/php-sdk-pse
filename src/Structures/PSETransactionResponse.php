<?php
namespace PlaceToPay\SDKPSE\Structures;

/**
 * Clase para almacenar la informacion de respuesta de la creacion de una 
 * transaccion
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class PSETransactionResponse
{
	/**
	 * $transactionID Identificador unico de la transaccion
	 * @var int
	 */
    public $transactionID;
    
    /**
	 * $sessionID Identificador unico de la sesion en PlacetoPay
	 * @var string
	 */
    public $sessionID;

    /**
	 * $returnCode Codigo de respuesta de la transaccion, 
	 * uno de los siguientes valores: 
	 * 		SUCCESS
	 * 		FAIL_ENTITYNOTEXISTSORDISABLED
	 * 		FAIL_BANKNOTEXISTSORDISABLED
	 * 		FAIL_SERVICENOTEXISTS
	 * 		FAIL_INVALIDAMOUNT
	 * 		FAIL_INVALIDSOLICITDATE
	 * 		FAIL_BANKUNREACHEABLE
	 * 		FAIL_NOTCONFIRMEDBYBANK
	 * 		FAIL_CANNOTGETCURRENTCYCLE
	 * 		FAIL_ACCESSDENIED
	 * 		FAIL_TIMEOUT
	 * 		FAIL_DESCRIPTIONNOTFOUND
	 * 		FAIL_EXCEEDEDLIMIT
	 * 		FAIL_TRANSACTIONNOTALLOWED
	 * 		FAIL_RISK
	 * 		FAIL_NOHOST
	 * 		FAIL_NOTALLOWEDBYTIME
	 * 		FAIL_ERRORINCREDITS
	 * @var string
	 */
    public $returnCode;

    /**
	 * $trazabilityCode Codigo unico de seguimiento para 
	 * la operacion dado por la red ACH
	 * @var string
	 */
    public $trazabilityCode;


    /**
	 * $transactionCycle Ciclo de compensacion de la red
	 * @var int
	 */
    public $transactionCycle;

    /**
	 * $bankCurrency Moneda aceptada por el banco acorde a ISO 4217
	 * @var string
	 */
    public $bankCurrency;

    /**
	 * $bankFactor Factor de conversion de la moneda
	 * @var float
	 */
    public $bankFactor;

    /**
	 * $bankURL URL a la cual remitir la solicitud para iniciar la interfaz del
	 * banco, solo disponible cuando returnCode = SUCCESS
	 * @var string
	 */
    public $bankURL;

    /**
	 * $responseCode Estado de la operacion en PlacetoPay
	 * @var int
	 */
    public $responseCode;

    /**
	 * $responseReasonCode Codigo interno de respuesta de la operacion 
	 * en PlacetoPay
	 * @var string
	 */
    public $responseReasonCode;

    /**
	 * $responseReasonText Mensaje asociado con el codigo de respuesta de la 
	 * operacion en PlacetoPay
	 * @var string
	 */
    public $responseReasonText;
}
