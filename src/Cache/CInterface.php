<?php
namespace PlaceToPay\SDKPSE\Cache;

/**
 * Interface que describe los metodos que debe llevar cada sistema de cache
 *
 * @author 	Oscar Uriel Rodriguez Tovar <okarook@gmail.com>
 */
interface CInterface
{
	/**
	 * add Adicionar un item a una nueva clave
	 * 
	 * @param string $key 		La clave en la que se guardará el valor
	 * @param mixed $value 		El valor a guardar
	 * @param int $expiration 	Tiempo de expiracion en segundos
	 * @return boolean 			true si se adiciono correctamente o 
	 *                         	false en caso contrario
	 */
	public function add($key, $value, $expiration);

	/**
	 * get Obtener un item
	 * 
	 * @param string $key 	La clave del item a obtener
	 * @return mixed 		Devuelve el valor obtenido o 
	 *                      false si el item no existe
	 */
	public function get($key);

	/**
	 * delete Elimina un item
	 * 
	 * @param string $key 	La clave del item a eliminar
	 * @return boolean 		Devuelve true si se adiciono correctamente o
	 *                      false en caso contrario
	 */
	public function delete($key);
}