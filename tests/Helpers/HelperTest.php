<?php

use PlaceToPay\SDKPSE\Helpers\Helper;

/**
 * Tests para la clase PlaceToPay\SDKPSE\Helpers\Helper
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
	/**
	 * testPath Validar el path inicial de la aplicacion
	 */
    public function testPath()
    {
    	printf("Validar el path inicial de la aplicacion\n");

    	$path = substr(__DIR__, 0, -13);
    	$pathHelper = Helper::path();
    	$this->assertEquals($path, $pathHelper);
    }

    /**
     * testSeed Validar el seed de acuardo al formato fecha ISO 8601
     *			(AAAA-MM-DDTHH:NN:SSZZZ)
     */
    public function testSeed()
    {
    	printf(
    		"Validar el seed de acuardo al formato fecha ISO 8601" .
    		"(AAAA-MM-DDTHH:NN:SSZZZ)\n"
    	);

    	$seedHelper = Helper::seed();
    }

    /**
     * testTranKey Validar la llave transaccional
     */
    public function testTranKey()
    {
    	printf("Validar la llave transaccional\n");

    	$tranKeyBank = 'Abc123iI';
    	$seed = '2017-01-06T15:38:41-05:00';

    	$tranKey = sha1($seed . $tranKeyBank,false);
    	$tranKeyHelper = Helper::tranKey($seed, $tranKeyBank);

    	$this->assertEquals($tranKey, $tranKeyHelper);
    	$this->assertTrue(40 === strlen($tranKeyHelper));
    }
}