<?php
namespace PlaceToPay\SDKPSE\Structures;

/**
 * Clase para almacenar una solicitud de informacion de transaccion 
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class TransactionInformation
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
	 * $reference Referencia unica de pago
	 * @var string
	 */
    public $reference;

    /**
	 * $requestDate Fecha de solicitud o creacion de la transaccion acorde 
	 * a ISO 8601
	 * @var string
	 */
    public $requestDate;

    /**
	 * $bankProcessDate Fecha de procesamiento de la transaccion acorde 
	 * a ISO 8601
	 * @var string
	 */
    public $bankProcessDate;

    /**
	 * $onTest Indicador de si la transaccion es en modo de pruebas o no
	 * @var boolean
	 */
    public $onTest;

    /**
	 * $returnCode Codigo de respuesta de la transaccion, uno de los siguientes: 
	 * 		SUCCESS
	 * 		FAIL_INVALIDTRAZABILITYCODE
	 * 		FAIL_ACCESSDENIED
	 * 		FAIL_INVALIDSTATE
	 * 		FAIL_INVALIDBANKPROCESSINGDATE
	 * 		FAIL_INVALIDAUTHORIZEDAMOUNT
	 * 		FAIL_INCONSISTENTDATA
	 * 		FAIL_TIMEOUT
	 * 		FAIL_INVALIDVATVALUE
	 * 		FAIL_INVALIDTICKETID
	 * 		FAIL_INVALIDSOLICITEDATE
	 * 		FAIL_INVALIDAUTHORIZATIONID
	 * 		FAIL_TRANSACTIONNOTALLOWED
	 * 		FAIL_ERRORINCREDITS
	 * 		FAIL_EXCEEDEDLIMIT
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
	 * $transactionState Informacion del estado de la transaccion
	 * [ OK, NOT_AUTHORIZED, PENDING, FAILED ]
	 * @var string
	 */
    public $transactionState;

    /**
	 * $responseCode Estado de la operación en PlacetoPay
	 * @var int
	 */
    public $responseCode;

    /**
	 * $responseReasonCode Codigo interno de respuesta de la operacion en 
	 * PlacetoPay
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
