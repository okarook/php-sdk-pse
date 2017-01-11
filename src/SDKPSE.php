<?php
namespace PlaceToPay\SDKPSE;

use \SoapClient;
use PlaceToPay\SDKPSE\Configs\Config;
use PlaceToPay\SDKPSE\Helpers\Helper;
use PlaceToPay\SDKPSE\Cache\Cache;
use PlaceToPay\SDKPSE\Structures\Authentication;

/**
 * Clase que provee metodos para comunicarcen al webservice
 *
 * La autenticacion de webservice se encuentra configurado en los atributos
 * "login", "tran_key" del archivo de configuracion /config.json
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
	 * $login Contiene el login asignado por Place To Pay
	 * @var string
	 */
	private $login;

	/**
	 * $tranKey Contiene la llave de transaccion asignado por Place To Pay
	 * @var string
	 */
	private $tranKey;

	function __construct()
	{
		$this->soapClient = 
			new SoapClient(self::$WSDL, array('encoding' => self::$ENCODING));
		$this->login = Config::get('login');
		$this->tranKey = Config::get('tran_key');
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
		$cache = new Cache();
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
		$tranKey = Helper::tranKey($seed, $this->tranKey);
		
		$authentication = new Authentication;
		$authentication->login = $this->login;
		$authentication->tranKey = $tranKey;
		$authentication->seed = $seed;
		$authentication->additional = array();
		return array('auth' => $authentication);
	}
}