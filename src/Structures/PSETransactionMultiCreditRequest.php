<?php
namespace PlaceToPay\SDKPSE\Structures;

/**
 * Clase que representa una solicitud de transaccion con debitos a cuenta PSE
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class PSETransactionMultiCreditRequest
{
	/**
	 * $bankCode 	Codigo de la entidad financiera con la cual 
	 * 				realizar la transaccion 
	 * @var string
	 */
    public $bankCode;
    
    /**
	 * $bankInterface 	Tipo de interfaz del banco a desplegar
	 * 					puede ser [0 = PERSONAS, 1 = EMPRESAS]
	 * @var string
	 */
    public $bankInterface;

	/**
	 * $returnURL	URL de retorno especificada para la entidad financiera
	 * @var string
	 */
    public $returnURL;

    /**
	 * $reference	Referencia unica de pago
	 * @var string
	 */
    public $reference;  

    /**
	 * $description 	Descripcion del pago
	 * @var string
	 */
    public $description;

    /**
	 * $language 	Idioma esperado para las transacciones acorde a ISO 631-1
	 * 				mayuscula sostenida
	 * @var string
	 */
    public $language;

	/**
	 * $currency 	Moneda a usar para el recaudo acorde a ISO 4217
	 * @var string
	 */
    public $currency;

    /**
	 * $totalAmount 	Valor total a recaudar
	 * @var float
	 */
    public $totalAmount;

    /**
	 * $taxAmount 	Discriminacion del impuesto aplicado
	 * @var float
	 */
    public $taxAmount;

    /**
	 * $devolutionBase 	Base de devolución para el impuesto
	 * @var float
	 */
    public $devolutionBase;

    /**
	 * $tipAmount 	Propina u otros valores exentos de impuesto (tasa 
	 * 				aeroportuaria) y que deben agregarse alvalor total a pagar
	 * @var float
	 */
    public $tipAmount;

    /**
	 * $payer 	Informacion del pagador 
	 * @var PlaceToPay\SDKPSE\Structures\Person
	 */
    public $payer;

    /**
	 * $buyer 	Informacion del comprador
	 * @var PlaceToPay\SDKPSE\Structures\Person
	 */
    public $buyer;

    /**
	 * $shipping 	Informacion del receptor
	 * @var PlaceToPay\SDKPSE\Structures\Person
	 */
    public $shipping;

    /**
	 * $ipAddress 	Direccion IP desde la cual realiza la transaccion el 
	 * 				pagador
	 * @var string
	 */
    public $ipAddress;

    /**
	 * $userAgent 	Agente de navegacion utilizado por el pagador
	 * @var string
	 */
    public $userAgent;

    /**
	 * $additionalData 	Datos adicionales para ser almacenados con la 
	 * 					transaccion
	 * @var array(
	 *      PlaceToPay\SDKPSE\Structures\Attribute
	 *      , ...)
	 */
    public $additionalData;

    /**
	 * $credits 	Detalle de la dispersion a realizar 
	 * @var array(
	 *      PlaceToPay\SDKPSE\Structures\CreditConcept
	 *      , ...)
	 */
    public $credits;
}
