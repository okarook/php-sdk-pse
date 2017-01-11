<?php

use PlaceToPay\SDKPSE\Cache\Cache;

/**
 * Tests para la clase PlaceToPay\SDKPSE\Cache\Cache
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class CacheTest extends PHPUnit_Framework_TestCase
{
	/**
	 * testAdd Guardar un valor en la cache
	 */
    public function testAdd()
    {
    	print("Guardar un valor en la cache\n");

        $key = 'test_add';
        $value = 'test valor a testear';

        $obj = new Cache($this->getConfig());
        $result = $obj->add($key, $value, 10);
        $this->assertTrue($result);

        print("$key: $value \n\n");
    }

    /**
     * testGet Obtener el item de la cache
     */
    public function testGet()
    {
        print("Obtener el item de la cache\n");

        $key = 'test_add';

        $obj = new Cache($this->getConfig());
        $value = $obj->get($key);
        $this->assertTrue($value !== false);

        print("$key: $value \n\n");
    }

    /**
     * testDelete Eliminar el item de la cache
     */
    public function testDelete()
    {
        print("Eliminar el item de la cache\n");

        $key = 'test_add';

        $obj = new Cache($this->getConfig());
        $value = $obj->delete($key);
        $this->assertTrue($value);

        print("$key: $value \n\n");
    }

    /**
     * testExpired Testear el tiempo de exipiracion
     */
    public function testExpired()
    {
        print("Testear el tiempo de exipiracion\n");

        $key = 'test_add_expired';
        $value = 'test valor a testear expired';
        $expired = 1; // Dos segundos

        $obj = new Cache($this->getConfig());
        $result = $obj->add($key, $value, $expired);
        sleep($expired+1);

        $valueCache = $obj->get($key);

        $this->assertNotEquals($value,$valueCache);
    }

    /**
     * testGeneral Prueba general la cache
     */
    public function testGeneral()
    {
        print("Prueba general la cache\n");

        $key = 'test_general';
        $value = 'test Prueba general de Memcached';
        $expired = 2; // Dos segundos
        $obj = new Cache($this->getConfig());

        # Adicionar el valor a la cache
        $result = $obj->add($key, $value, $expired);
        $this->assertTrue($result);

        # Obtener y comparar el valor de la cache
        $valueCache = $obj->get($key);
        $this->assertEquals($value, $valueCache);

        # Eliminar y obtener el valor para que arroje false
        $obj->delete($key);
        $valueCache = $obj->get($key);
        $this->assertNotEquals($value, $valueCache);
    }

    private function getConfig() 
    {
        return array(
            "type" => "memcached",
            "memcached" => array(
                "host" => "127.0.0.1",
                "port" => "11211"
            )
        );
    }
}