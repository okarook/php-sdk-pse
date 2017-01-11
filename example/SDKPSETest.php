<?php

require '../vendor/autoload.php';
use PlaceToPay\SDKPSE\SDKPSE;

/**
 * SDKPSETest para la clase PlaceToPay\SDKPSE\SDKPSE
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class SDKPSETest
{
	/**
     * testGetBankList Obtener la lista de los bancos
     */
    public function testGetBankList()
    {
    	print("Obtener la lista de los bancos\n");

        $obj = new SDKPSE($this->getConfig());
        $banks = $obj->getBankList();
        var_dump($banks);
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


$obj = new SDKPSETest;
$obj->testGetBankList();