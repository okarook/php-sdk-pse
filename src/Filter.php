<?php
namespace PlaceToPay\SDKPSE;

/**
 * Clase que provee metodos con los filtros de los objetos
 *
 * Reglas para validar los parametros de los metodos del objeto 
 * PlaceToPay\SDKPSE\SDKPSE
 *
 * Las estructuras de los objetos se encuentran en PlaceToPay\SDKPSE\Structures
 * 
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Filter
{
	/**
	 * Person Contiene los filtros para los atributos del objeto Person
	 * 
	 * @return array 		Devuelve los filtros
	 */
	public static function Person()
	{
		return array(
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
	}

	/**
	 * PSETransactionRequest Contiene los filtros para los atributos del 
	 * objeto PSETransactionRequest
	 * 
	 * @return array 		Devuelve los filtros
	 */
	public static function PSETransactionRequest()
	{
		return array(
            'bankCode' => 'max:4',
            'bankInterface' => 'max:1|containt:0,1',
            'returnURL' => 'max:255',
            'reference' => 'max:32',
            'description' => 'max:255',
            'language' => 'max:2',
            'currency' => 'max:3',
            'ipAddress' => 'ip',
            'userAgent' => 'max:255'
        );
	}

	/**
	 * PSETransactionMultiCreditRequest Contiene los filtros para los atributos
	 * del objeto PSETransactionMultiCreditRequest
	 * 
	 * @return array 		Devuelve los filtros
	 */
	public static function PSETransactionMultiCreditRequest()
	{
		return array(
            'bankCode' => 'max:4',
            'bankInterface' => 'max:1|containt:0,1',
            'returnURL' => 'max:255',
            'reference' => 'max:32',
            'description' => 'max:255',
            'language' => 'max:2',
            'currency' => 'max:3',
            'ipAddress' => 'ip',
            'userAgent' => 'max:255'
        );
	}

	/**
	 * CreditConcept Contiene los filtros para los atributos
	 * del objeto CreditConcept
	 * 
	 * @return array 		Devuelve los filtros
	 */
	public static function CreditConcept()
	{
		return array(
            'entityCode' => 'max:12',
            'serviceCode' => 'max:12',
            'description' => 'max:60'
        );
	}
}