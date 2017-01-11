<?php

require '../vendor/autoload.php';
use PlaceToPay\SDKPSE\Cache\CAPCU;

/**
 * Tests para la clase PlaceToPay\SDKPSE\Cache\CAPCU
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class CAPCUTest
{
	/**
	 * testAdd Guardar un valor en la cache
	 */
    public function testAdd()
    {
    	print("Guardar un valor en la cache CAPCU<br/>");

        $key = 'test_add_apcu';
        $value = 'test valor a testear apcu';
    
        $obj = new CAPCU();
        $result = $obj->add($key, $value, 10);
        $message = $result == true ? 'ok' : 'error_testAdd';
        print($message . '<br/>');
        print("$key: $value <br/><br/>");
    }

    /**
     * testGet Obtener el item de la cache
     */
    public function testGet()
    {
        print("Obtener el item de la cache CAPCU<br/>");

        $key = 'test_add_apcu';

        $obj = new CAPCU();
        $value = $obj->get($key);
        $message = $value !== false ? 'ok' : 'error_testGet';
        print($message . '<br/>');
        
        print("$key: $value <br/><br/>");
    }

    /**
     * testDelete Eliminar el item de la cache
     */
    public function testDelete()
    {
        print("Eliminar el item de la cache CAPCU<br/>");

        $key = 'test_add_apcu';

        $obj = new CAPCU();
        $value = $obj->delete($key);

        $message = $value == true ? 'ok' : 'error_testDelete';
        print($message . '<br/>');
        print("$key: $value <br/><br/>");
    }

    /**
     * testGeneral Prueba general la cache
     */
    public function testGeneraltestGeneral()
    {
        print("Prueba general la cache CAPCU<br/>");

        $key = 'test_general';
        $value = 'test Prueba general de CAPCU';
        $expired = 2; // Dos segundos
        $obj = new CAPCU();

        # Adicionar el valor a la cache
        $result = $obj->add($key, $value, $expired);
        var_dump($result == true);

        # Obtener y comparar el valor de la cache
        $valueCache = $obj->get($key);
        var_dump($value == $valueCache);

        # Eliminar y obtener el valor para que arroje false
        $obj->delete($key);
        $valueCache = $obj->get($key);
        var_dump($value != $valueCache);
    }
}


$obj = new CAPCUTest;
$obj->testAdd();
$obj->testGet();
$obj->testDelete();
$obj->testGeneraltestGeneral();