<?php
namespace PlaceToPay\SDKPSE;

use \SoapClient;
use PlaceToPay\SDKPSE\Helpers\Helper;
use PlaceToPay\SDKPSE\Helpers\Validate;
use PlaceToPay\SDKPSE\Cache\Cache;
use PlaceToPay\SDKPSE\Structures\Authentication;

/**
 * Clase que provee metodos para comunicarcen al webservice
 *
 * La autenticacion del webservice se debe enviar por parametro al instanciar
 * la clase, array con los indices ["login" => "", "tran_key" => ""] tambien
 * debe contener las siguientes configuraciones: 
 *     [
 * 			"cache" => [
 * 				"type" => "",
 * 			 	"memcached" => [
 * 				 	"host" => "",
 * 				  	"port" => ""
 * 			    ] 		
 *    	   ]
 *     ]
 * 
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class SDKPSE
{
	/**
	 * $WSDL Contiene la url del webservice
	 * @var string
	 */
	private static $WSDL = 'https://test.placetopay.com/soap/pse/?wsdl';

	/**
	 * $ENCODING Contiene la codificacion para el webservice
	 * @var string
	 */
	private static $ENCODING = 'UTF-8';

	/**
	 * $soapClient Contiene la instancia del objeto de \SoapClient
	 * @var \SoapClient
	 */
	private $soapClient;

	/**
	 * $config Contiene las configuraciones para la libreria,
	 * 			"login" => "login asignado por Place To Pay",
	 * 			"tran_key" => "llave de transaccion asignado por Place To Pay",
	 * 			"cache" => "Sistema de cache a utilizar y su configuracion"
	 * @var array
	 */
	private $config;

	/**
	 * __construct 
	 * @param array $config Contiene las configuracion, los indices deben ser:
	 *                      [
	 *                      	"login" => "",
	 *                      	"tran_key" => "",
	 * 		                   	"cache" => [
	 *								"type" => "",
	 * 								"memcached" => [
	 * 				    				"host" => "",
	 * 				        			"port" => ""
	 * 			            		] 		
	 *    	             		]
	 *    	             	]
	 */
	function __construct($config)
	{
		$this->config = $config;
		$this->soapClient = 
			new SoapClient(self::$WSDL, array('encoding' => self::$ENCODING));
	}

	/**
	 * getBankList Obtiene la lista de los bancos disponibles
	 * 
	 * @return array 	Devuelve un array con objetos 
	 *                  PlaceToPay\SDKPSE\Structures\Bank o false cuando 
	 *                  no existen resultados
	 */
	public function getBankList()
	{
		# tiempo de expiracion para cachear los bancos
		$expiration = 86400; // 1 dia
		# key asignado para cachear los bancos
		$keyCache = 'bank_list';
		# Obtener la lista de bancos que estan en la cache
		$cache = new Cache($this->config['cache']);
		$banks = $cache->get($keyCache);

		if ($banks === false) {
			try {
				# Consumir el servicio para obtener las bancos
	            $result = $this->soapClient->getBankList($this->auth());
	            $banks = $result->getBankListResult->item;
	            $cache->add($keyCache, $banks, $expiration);
	        } catch (Exception $e) {
	        	Error::newException(
	        		'Error al obtener los bancos'
	        	);
	        }
		}

        return is_array($banks) ? $banks : false;
	}

	/**
	 * createTransaction Solicita la creacion de una transaccion
	 *
	 * @param PlaceToPay\SDKPSE\Structures\PSETransactionRequest
	 *        $transaction 	Datos de la solicitud
	 * @return PlaceToPay\SDKPSE\Structures\PSETransactionResponse
	 *         Devuelve la creacion de la transaccion o false cuando 
	 *         no existen resultados
	 */
	public function createTransaction($transaction)
	{
        # Validar los parametros
        Validate::make($transaction, Filter::PSETransactionRequest());
        Validate::make($transaction->payer, Filter::Person());
        Validate::make($transaction->buyer, Filter::Person());
        Validate::make($transaction->shipping, Filter::Person());

		$param = $this->auth();
		$param['transaction'] = $transaction;

		try {
	        $result = $this->soapClient->createTransaction($param);
	        $transaction = $result->createTransactionResult;
	    } catch (Exception $e) {
	    	Error::newException(
	    		'Error al crear la transaccion'
	    	);
	    }

	    return is_object($transaction) ? $transaction : false;
	}

	/**
	 * createTransactionMultiCredit Solicita la creacion de una transaccion 
	 * con dispersion de fondos
	 *
	 * @param PlaceToPay\SDKPSE\Structures\PSETransactionMultiCreditRequest
	 *        $transaction 	Datos de la solicitud
	 * @return PlaceToPay\SDKPSE\Structures\PSETransactionResponse
	 *         Devuelve la creacion de la transaccion o false cuando 
	 *         no existen resultados
	 */
	public function createTransactionMultiCredit($transaction)
	{
        # Validar los parametros
        Validate::make($transaction, Filter::PSETransactionRequest());
        Validate::make($transaction->payer, Filter::Person());
        Validate::make($transaction->buyer, Filter::Person());
        Validate::make($transaction->shipping, Filter::Person());
        Validate::make($transaction->credits, Filter::CreditConcept());

		$param = $this->auth();
		$param['transaction'] = $transaction;

		try {
	        $result = $this->soapClient->createTransactionMultiCredit($param);
	        $transaction = $result->createTransactionMultiCreditResult;
	    } catch (Exception $e) {
	    	Error::newException(
	    		'Error al crear transaccion con dispersion de fondos'
	    	);
	    }

	    return is_object($transaction) ? $transaction : false;
	}
	
	/**
	 * getTransactionInformation Obtiene la informacion de una transaccion
	 *
	 * @param int $transactionID 	identificador unico de la transaccion, 
	 *                            	equivale al retornado en la 
	 *                            	creacion de la transaccion 
	 * @return PlaceToPay\SDKPSE\Structures\TransactionInformation
	 *         Devuelve la informacion del estado de la transaccion o false 
	 *         cuando no existen resultados
	 */
	public function getTransactionInformation($transactionID)
	{
		if (intval($transactionID) == 0)
			Error::newException('Invalido el $transactionID ');

		$param = $this->auth();
		$param['transactionID'] = $transactionID;
		$informacion = '';

		try {
	        $result = $this->soapClient->getTransactionInformation($param);
	        $informacion = $result->getTransactionInformationResult;
	    } catch (Exception $e) {
	    	Error::newException(
	    		'Error al obtener la informacion de la transaccion'
	    	);
	    }

        return is_object($informacion) ? $informacion : false;
	}

	/**
	 * auth Obtiene el objeto con los datos de autenticacion
	 *
	 * Se encarga de preparar los datos del objeto 
	 * PlaceToPay\SDKPSE\Structures\Authentication para la autenticacion
	 * del webservice
	 * 
	 * @return array 	Devuelve un array con el indice "auth" y valor
	 *                  PlaceToPay\SDKPSE\Structures\Authentication
	 */
	private function auth()
	{
		$seed = Helper::seed();
		$tranKey = Helper::tranKey($seed, $this->config['tran_key']);
		
		$authentication = new Authentication;
		$authentication->login = $this->config['login'];
		$authentication->tranKey = $tranKey;
		$authentication->seed = $seed;
		$authentication->additional = array();
		return array('auth' => $authentication);
	}
}