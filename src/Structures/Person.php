<?php
namespace PlaceToPay\SDKPSE\Structures;

/**
 * Clase para reflejar la informacion de una persona involucrada
 * en una transaccion
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Person
{
	/**
	 * $document Numero de identificacion de la persona
	 * @var string
	 */
    public $document;
    
    /**
	 * $documentType 	Tipo de documento de identificacion de la persona:
	 * 					CC = Cedula de ciudania colombiana 
	 * 					CE = Cedula de extranjeria 
	 * 					TI = Tarjeta de identidad 
	 * 					PPN = Pasaporte 
	 * 					NIT = Numero de identificacion tributaria 
	 * 					SSN = Social Security Number
	 * @var string
	 */
    public $documentType;

    /**
	 * $firstName Nombres
	 * @var string
	 */
    public $firstName;

    /**
	 * $lastName Apellidos
	 * @var string
	 */
    public $lastName;

    /**
	 * $company Nombre de la compañia en la cual labora o representa
	 * @var string
	 */
    public $company;

    /**
	 * $emailAddress Correo electronico 
	 * @var string
	 */
    public $emailAddress;

    /**
	 * $address Direccion postal completa
	 * @var string
	 */
    public $address;

    /**
	 * $city Nombre de la ciudad coincidente con la direccion
	 * @var string
	 */
    public $city;

    /**
	 * $province Nombre de la provincia o departamento coincidente 
	 * 			 con la direccion
	 * @var string
	 */
    public $province;

    /**
	 * $country Codigo internacional del pais que aplica a la direccion fisica
	 * 			acorde a ISO 3166-1, mayuscula sostenida.
	 * @var string
	 */
    public $country;

    /**
	 * $phone Numero de telefonia fija 
	 * @var string
	 */
    public $phone;

    /**
	 * $mobile Numero de telefonia movil o celular 
	 * @var string
	 */
    public $mobile;
}
