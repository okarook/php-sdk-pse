<?php

use PlaceToPay\SDKPSE\Helpers\Validate;
use PlaceToPay\SDKPSE\Structures\Person;
/**
 * Tests para la clase PlaceToPay\SDKPSE\Helpers\Validate
 *
 * @author  Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class ValidateTest extends PHPUnit_Framework_TestCase
{
	/**
	 * testPath Validar el path inicial de la aplicacion
	 */
    public function testMake()
    {
    	printf("testMake \n");

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

        $param = array(
            'document' => 'max:12',
            'documentType' => 'max:3|containt:CC,CE,TI,PPN,NIT,SSN',
            'firstName' => 'max:60',
            'lastName' => 'max:60',
            'company' => 'max:60',
            'emailAddress' => 'max:80|email',
            'address' => 'max:100',
            'city' => 'max:50',
            'province' => 'max:50',
            'country' => 'max:2',
            'phone' => 'max:30',
            'mobile' => 'max:30'
        );
        Validate::make($person, $param);
    }
}