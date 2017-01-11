<?php

use PlaceToPay\SDKPSE\SDKPSE;
use PlaceToPay\SDKPSE\Structures\PSETransactionRequest;
use PlaceToPay\SDKPSE\Structures\PSETransactionMultiCreditRequest;
use PlaceToPay\SDKPSE\Structures\Person;
use PlaceToPay\SDKPSE\Structures\CreditConcept;

/**
 * SDKPSETest para la clase PlaceToPay\SDKPSE\SDKPSE
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class SDKPSETest extends PHPUnit_Framework_TestCase
{
	/**
	 * testGetBankList Obtener la lista de los bancos
	 */
    public function testGetBankList()
    {
    	print("Obtener la lista de los bancos\n");

    	$obj = new SDKPSE($this->getConfig());
        $banks = $obj->getBankList();
        $this->assertTrue(is_array($banks));
    }

    /**
     * testCreateTransaction Crear una transacton
     */
    public function testCreateTransaction()
    {
        print("Crear una transacton\n");

        $obj = new SDKPSE($this->getConfig());

        # Obtener el codigo del banco [bankCode]
        $bankCode = '';
        $banks = $obj->getBankList();
        $bankCode = $banks[0]->bankCode;

        $payer = $this->getPersonOne();
        $buyer = $this->getPersonOne();
        $shipping = $this->getPersonTwo();
        
        $transaction = new PSETransactionRequest();
        $transaction->bankCode = $bankCode;
        $transaction->bankInterface = 1;
        $transaction->returnURL = 'http://okarook.com';
        $transaction->reference = '2017-011212';
        $transaction->description = 'Se realiza la compra de un pc';
        $transaction->language = 'ES';
        $transaction->currency = 'COP';
        $transaction->totalAmount = 1500000;
        $transaction->taxAmount = 200000;
        $transaction->devolutionBase = 0;
        $transaction->tipAmount = 0;
        $transaction->payer = $payer;
        $transaction->buyer = $buyer;
        $transaction->shipping = $shipping;
        $transaction->ipAddress = '10.10.1.12';
        $transaction->userAgent = 
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0)Gecko/20100101 Firefox/50.0';
        $transaction->additionalData = array();

        $result = $obj->createTransaction($transaction);
        $this->assertTrue(gettype($result) == 'object');
        print('sessionID: ' . $result->sessionID . "\n");
        print('returnCode: ' . $result->returnCode . "\n");
        print('bankURL: ' . $result->bankURL . "\n");
        print('responseReasonText: ' . $result->responseReasonText . "\n\n");
        // var_dump(gettype($result));
        // var_dump($result);
    }

    /**
     * testcreateTransactionMultiCredit Crear una transacton multicredito
     * con dispersion de fondos
     */
    public function testcreateTransactionMultiCredit()
    {
        print("Crear una transacton multicredito\n");

        $obj = new SDKPSE($this->getConfig());

        # Obtener el codigo del banco [bankCode]
        $bankCode = '';
        $banks = $obj->getBankList();
        $bankCode = $banks[0]->bankCode;

        $payer = $this->getPersonOne();
        $buyer = $this->getPersonOne();
        $shipping = $this->getPersonTwo();
        
        $credits = new CreditConcept;
        $credits->entityCode = 'ent_cod_2017_01';
        $credits->serviceCode = 'ser_cod_2017_01';
        $credits->amountValue = 2000000;
        $credits->taxValue = 500000;
        $credits->description = 'Credito para pagar el TV';

        $transaction = new PSETransactionMultiCreditRequest();
        $transaction->bankCode = $bankCode;
        $transaction->bankInterface = 1;
        $transaction->returnURL = 'http://okarook.com';
        $transaction->reference = '2017-011212';
        $transaction->description = 'Se realiza la compra de un TV';
        $transaction->language = 'ES';
        $transaction->currency = 'COP';
        $transaction->totalAmount = 2000000;
        $transaction->taxAmount = 500000;
        $transaction->devolutionBase = 0;
        $transaction->tipAmount = 0;
        $transaction->payer = $payer;
        $transaction->buyer = $buyer;
        $transaction->shipping = $shipping;
        $transaction->ipAddress = '10.10.1.12';
        $transaction->userAgent = 
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0)Gecko/20100101 Firefox/50.0';
        $transaction->additionalData = array();
        $transaction->credits = array($credits);

        $result = $obj->createTransactionMultiCredit($transaction);
        $this->assertTrue(gettype($result) == 'object');
        print('sessionID: ' . $result->sessionID . "\n");
        print('returnCode: ' . $result->returnCode . "\n");
        print('bankURL: ' . $result->bankURL . "\n");
        print('responseReasonText: ' . $result->responseReasonText . "\n\n");
        // var_dump(gettype($result));
        // var_dump($result);
    }

    /**
     * testGetTransactionInformation Obtener la informacion de una transacton
     */
    public function testGetTransactionInformation()
    {
        print("Obtener la informacion de una transacton\n");

        $obj = new SDKPSE($this->getConfig());

        # Crear una transaccion

        # Obtener el codigo del banco [bankCode]
        $bankCode = '';
        $banks = $obj->getBankList();
        $bankCode = $banks[0]->bankCode;
        
        $payer = $this->getPersonOne();
        $buyer = $this->getPersonOne();
        $shipping = $this->getPersonTwo();
        
        $transaction = new PSETransactionRequest();
        $transaction->bankCode = $bankCode;
        $transaction->bankInterface = 1;
        $transaction->returnURL = 'http://okarook.com';
        $transaction->reference = '2017-011212';
        $transaction->description = 'Se realiza la compra de un pc';
        $transaction->language = 'ES';
        $transaction->currency = 'COP';
        $transaction->totalAmount = 1500000;
        $transaction->taxAmount = 200000;
        $transaction->devolutionBase = 0;
        $transaction->tipAmount = 0;
        $transaction->payer = $payer;
        $transaction->buyer = $buyer;
        $transaction->shipping = $shipping;
        $transaction->ipAddress = '10.10.1.12';
        $transaction->userAgent = 
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0)Gecko/20100101 Firefox/50.0';
        $transaction->additionalData = array();

        $result = $obj->createTransaction($transaction);
        $this->assertTrue(gettype($result) == 'object');
        print('transactionID: ' . $result->transactionID . "\n");
        print('sessionID: ' . $result->sessionID . "\n");
        print('returnCode: ' . $result->returnCode . "\n");
        print('bankURL: ' . $result->bankURL . "\n");
        print('responseReasonText: ' . $result->responseReasonText . "\n");

        # Obtener la informacion de la transaccion
        $info = $obj->getTransactionInformation($result->transactionID);
        $this->assertTrue(gettype($info) == 'object');
        $this->assertTrue($info->transactionID == $result->transactionID);
    }

    private function getPersonOne()
    {
        $person = new Person;
        $person->document = '1081157823';
        $person->documentType = 'CC';
        $person->firstName = 'Oscar Uriel';
        $person->lastName = 'Rodriguez Tovar';
        $person->company = 'INEFABLE';
        $person->emailAddress = 'okarook@gmail.com';
        $person->address = '41001';
        $person->city = 'NEIVA';
        $person->province = 'HUILA';
        $person->country = 'CO';
        $person->phone = '87108140';
        $person->mobile = '3142891241';

        return $person;
    }

    private function getPersonTwo()
    {
        $person = new Person;
        $person->document = '93090506003';
        $person->documentType = 'TI';
        $person->firstName = 'Yesica ';
        $person->lastName = 'Gonzalez Tovar';
        $person->company = 'INEFABLE';
        $person->emailAddress = 'yesica@gmail.com';
        $person->address = '41001';
        $person->city = 'NEIVA';
        $person->province = 'HUILA';
        $person->country = 'CO';
        $person->phone = '87108140';
        $person->mobile = '3142901254';

        return $person;
    }

    private function getConfig() 
    {
        return array(
            "login" => '6dd490faf9cb87a9862245da41170ff2',
            "tran_key" => '024h1IlD',
            "cache" => array(
                "type" => "memcached",
                "memcached" => array(
                    "host" => "127.0.0.1",
                    "port" => "11211"
                )
            )
        );
    }
}