<?php
namespace PlaceToPay\SDKPSE\Helpers;

/**
 * Clase que provee metodos para validar los atributos de los objetos
 *
 * Genera una excepcion en caso de no cumplir el valor con el filtro
 *  
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
class Validate
{	   
	/**
	 * make Valida los objetos de acuerdo al filtro
	 *
	 * Genera una excepcion en caso de no cumplir el valor con el filtro
	 * 
	 * @param mixed $data 		Objeto a validar, puede ser un array de objetos
	 * @param array $filter 	Filtros para aplicar al valor del atributo,
	 *                       	Debe ser (indice => valor), donde el indice
	 *                       	es el nombre del atributo y valor es el filtro 
	 */
    public static function make($data, $filter)
    {
    	if (is_array($data)) {
    		foreach ($data as $value) {
    			self::applyFilter($value, $filter);
    		}
    	} else {
    		self::applyFilter($data, $filter);
    	}
    }

    /**
	 * applyFilter Valida el objeto de acuerdo al filtro
	 *
	 * Genera una excepcion en caso de no cumplir el valor con el filtro
	 * 
	 * @param object $obj 		Objeto a validar
	 * @param array $filter 	Filtros para aplicar al valor del atributo,
	 *                       	Debe ser (indice => valor), donde el indice
	 *                       	es el nombre del atributo y valor es el filtro 
	 */
    private static function applyFilter($obj, $filter)
    {
    	foreach ($filter as $key => $value) {
    		self::inAttr($obj, $key);
    		$valueAttr = $obj->$key;

    		$validate = array_map('trim',explode('|', $value));

    		foreach ($validate as $row) {
    			$param = explode(':', $row);

    			$result = false;
    			switch ($param[0]) {
    				case 'containt':
    					$result = self::containt($valueAttr, $param[1]);
    					break;
    				case 'email':
    					$result = self::email($valueAttr);
    					break;
    				case 'ip':
    					$result = self::ip($valueAttr);
    					break;
    				case 'max':
    					$result = self::max($valueAttr, $param[1]);
    					break;
    				default:
    					Error::newException(
    						"No existe el filtro ({$param[0]})"
    					);
    					break;
    			}

    			if ($result == false) {
					Error::newException(
						"El atributo ($key) no cumple con el filtro ($row)"
					);
    			}
    		}
    	}
    }

    /**
	 * inAttr Valida si el atributo existe en el objeto
	 *
	 * Genera una excepcion en caso de no existir
	 * 
	 * @param object $obj 		Objeto a validar
	 * @param array $attr 		Nombre del atributo
	 */
    private static function inAttr($obj, $attr)
    {
    	if (! isset($obj->$attr)) {
			Error::newException("No existe el atributo ($attr) en el objeto");
		}
    }

    /**
	 * containt Comprueba que el $value este en $data
	 * 
	 * @param mixed $value 	Valor a buscar
	 * @param string $data 	Los valores permitidos
	 * @return boolena 		Devuelve TRUE si $value se encuentra en $data, 
	 *                      false de lo contrario.
	 */
    private static function containt($value, $data)
    {
    	$data = explode(',', $data);
    	return in_array($value, $data);
    }

    /**
	 * email Comprueba si es un email
	 * 
	 * @param string $value Valor a comprobar
	 * @return boolena 		Devuelve TRUE si es email,
	 *                      false de lo contrario.
	 */
    private static function email($value)
    {
    	return filter_var($value, FILTER_VALIDATE_EMAIL) == false
    		? false
    		: true;
    }

    /**
	 * ip Comprueba si es una ip
	 * 
	 * @param string $value Valor a comprobar
	 * @return boolena 		Devuelve TRUE si es ip,
	 *                      false de lo contrario.
	 */
    private static function ip($value)
    {
    	return filter_var($value, FILTER_VALIDATE_IP) == false
    		? false
    		: true;
    }

    /**
	 * max Valida la longitud maxima de $value
	 * 
	 * @param mixed $value 	Valor a comprobar
	 * @param int $len 		Longitud maxima
	 * @return boolena 		Devuelve TRUE si la longitud es menor o igual
	 *                      a $len, false de lo contrario.
	 */
    private static function max($value, $len)
    {
    	return strlen("$value") <= $len;
    }



}

