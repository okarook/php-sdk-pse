<?php

use PlaceToPay\SDKPSE\Configs\Config;

/**
 * Tests para la clase PlaceToPay\SDKPSE\Configs\Config
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{
	/**
	 * testGet Testear la configuracion de acuerdo al parametro
	 */
    public function testGet()
    {
    	print("Testear la configuracion de acuerdo al parametro\n");

    	$config = Config::get('cache');
        $this->assertTrue(strlen($config) > 0);
    }

    /**
     * testConfigMemcached Testear la configuracion del servidor Memcached
     */
    public function testConfigMemcached()
    {
        print("Testear la configuracion del servidor Memcached\n");

        # Validar que este la configuracion
        $config = Config::get('memcached');
        $this->assertTrue(count($config) > 0);

        # Validar el host y port
        $host = Config::get('memcached.host');
        $port = Config::get('memcached.port');
        print("Host: $host - "); 
        print("Port: $host \n \n"); 
    }    
}