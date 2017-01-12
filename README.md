# Place To Pay php-sdk-pse

Una simple libreria para conectarse al webservice PSE suministrado por Place To Pay

## Requerimientos

Puedes elegir [`Memcached`](http://php.net/manual/es/book.memcached.php) o [`APCu`](http://php.net/manual/es/book.apcu.php) para almacenar los datos en caché.

Si elige [`APCu`](http://php.net/manual/es/book.apcu.php) Tenga en cuenta que hay varios casos en los que la caché APCu no persiste y todos los valores establecidos se pierden después de que existe el proceso PHP. P.ej. CLI de PHP: las sucesivas ejecuciones de CLI de la misma secuencia de comandos encontrarán la caché APCu vacía.

En proximas versiones se adicionan mas sistemas de caché

```
- PHP >= 5.6.0
- Memcached >= 1.4.25
```

## Instalación

Se Instala vía composer

```
composer require place-to-pay/php-sdk-pse
```
## Configuración

Al instanciar el objeto `PlaceToPay\SDKPSE\SDKPSE` debe pasar por parametro
un array con la siguiente configuración:

```php
	$config = array(
		"login" => "",
		"tran_key" => "",
		"cache" => array(
	 		"type" => "",
	 		"memcached" => array(
	 			"host" => "",
	 			"port" => ""
			)
		)
	)

	$obj = new SDKPSE($config);
```


### 1. Datos suministrados por Place To Pay
1. `login:` Login para la autenticación
2. `tran_key:` Llave transaccional

### 1. Datos sistema de caché
1. `type:` Nombre del sistema de caché a utilizar, puede ser `memcached` o `apcu` 

De acuerdo al sistema de caché indicado debe realizar su respectiva configuración

#### 1.1. Configuración sistema `memcached:`
1. `host:` Dirección del servidor
2. `port:` Puerto del servidor 
  
## Versión
v1.0.0

## Licencia
[MIT License](LICENSE)

# Documentación

## Excepciones 

Los metodos pueden generar excepciones de tipo `\Exception`

#### Ejemplos:

> Cuando no se envian los parametros de configuracion

> Cuando no se puede agregar el servidor memcached

> Cuando el tipo o longitud del atributo del [objeto](#tipos-de-datos-o-estructuras) es incorrecto

> Cuando no se puede consumir el webservice PSE

## Métodos disponibles
	
A continuación se describen las operaciones (métodos) que la libreria brinda

Los metodos se encuentran en el namespace `PlaceToPay\SDKPSE\SDKPSE`

#### `getBankList()`

Obtiene la lista de los bancos disponibles

La petición al webservice se realiza una vez al día para almacenar los datos en la cache

> **Valor devuelto:**
	Devuelve un array con objetos [`Bank`](#bank) o `false` cuando no existen resultados

#### `createTransaction()`

Solicita la creacion de una transacción

> **Parametros:**

| Nombre | Tipo | Descripción |
| --- | --- | --- |
| $transaction | [PSETransactionRequest](#psetransactionrequest) | Datos de la solicitud |

> **Valor devuelto:**
	Devuelve la creacion de la transacción [`PSETransactionResponse`](#psetransactionresponse) o `false` cuando no existen resultados

#### `createTransactionMultiCredit()`

Solicita la creacion de una transacción con dispersión de fondos

> **Parametros:**

| Nombre | Tipo | Descripción |
| --- | --- | --- |
| $transaction | [PSETransactionMultiCreditRequest](#psetransactionmulticreditrequest) | Datos de la solicitud |

> **Valor devuelto:**
	Devuelve la creacion de la transacción [`PSETransactionResponse`](#psetransactionresponse) o `false` cuando no existen resultados

#### `getTransactionInformation()`

Obtiene la información de una transacción

> **Parametros:**

| Nombre | Tipo | Descripción |
| --- | --- | --- |
| $transactionID | int | Identificador único de la transacción, equivale al retornado en la 
	 *                            	creacion de la transaccion  |

> **Valor devuelto:**
	Devuelve la informacion de la transacción [`TransactionInformation`](#transactioninformation) o `false` cuando no existen resultados


## Tipos de datos o estructuras
En este apartado se describen cada una de las estructuras de datos usadas por los métodos

Estas clases se encuentran en el namespace `PlaceToPay\SDKPSE\Structures`

#### `Attribute`
Estructura para almacenar información extendida

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| name | string | 30 | Código para referenciar el atributo |
| value | string | 128 | Valor que asume el atributo |

#### `Person`
Estructura para reflejar la información de una persona involucrada en una transacción

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| document | string | 12 | Número de identificación de la persona |
| documentType | string | 3 | Tipo de documento de identificación de la persona: <br/> CC = Cédula de ciudanía colombiana <br/> CE = Cédula de extranjería <br/> TI = Tarjeta de identidad <br/> PPN = Pasaporte <br/> NIT = Número de identificación tributaria <br/> SSN = Social Security Number |
| firstName | string | 60 | Nombres |
| lastName | string | 60 | Apellidos |
| company | string | 60 | Nombre de la compañía en la cual    labora o representa |
| emailAddress | string | 80 | Correo electrónico |
| address | string | 100 | Dirección postal completa |
| city | string | 50 | Nombre de la ciudad coincidente con la dirección |
| province | string | 50 | Nombre de la provincia o departamento coincidente con la dirección |
| country | string | 2 | Código internacional del país que aplica a la dirección física acorde a ISO 3166-1, mayúscula sostenida |
| phone | string | 30 | Número de telefonía fija |
| mobile | string | 30 | Número de telefonía móvil o celular |

#### `Bank`
Estructura para reflejar la información de una entidad bancaria

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| bankCode | string | 4 | Código de la entidad financiera |
| bankName | string | 60 | Nombre de la entidad financiera |

#### `CreditConcept`
Estructura que representa el concepto del crédito a favor de un tercero 

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| entityCode | string | 12 | Código de la entidad del tercero para dispersión |
| serviceCode | string | 12 | Código del servicio del tercero |
| amountValue | float |  | Valor total a recaudar a favor de la entidad |
| taxValue | float |  | Discriminación del impuesto aplicado a favor de la entidad |
| description | string | 60 | Descripción el concepto cobrado |


#### `PSETransactionRequest`
Estructura que representa una solicitud de transacción con débitos a cuenta PSE

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| bankCode | string | 4 | Código de la entidad financiera con la cual realizar la transacción |
| bankInterface | string | 1 | Tipo de interfaz del banco a desplegar [0 = PERSONAS, 1 = EMPRESAS] |
| returnURL | string | 255 | URL de retorno especificada para la entidad financiera |
| reference | string | 32 | Referencia única de pago |
| descriptiop | string | 255 | Descripción del pago |
| language | string | 2 | Idioma esperado para las transacciones acorde a ISO 631-1, mayúscula sostenida |
| currency | string | 3 | Moneda a usar para el recaudo acorde a ISO 4217 |
| totalAmount | float |  | Valor total a recaudar |
| taxAmount | float |  | Discriminación del impuesto aplicado |
| devolutionBase | float |  | Base de devolución para el impuesto |
| tipAmount | float |  | Propina u otros valores exentos de impuesto (tasa aeroportuaria) y que deben agregarse al valor total a pagar |
| payer | [Person](#person) |  | Información del pagador |
| buyer | [Person](#person) |  | Información del comprador |
| shipping | [Person](#person) |  | Información del receptor |
| ipAddress | string | 15 | Dirección IP desde la cual realiza la transacción el pagador |
| userAgent | string | 255 | Agente de navegación utilizado por el pagador |
| additionalData | [Attribute](#attribute) |  | Datos adicionales para ser almacenados con la transacción |

#### `PSETransactionMultiCreditRequest`
Estructura que representa una solicitud de transacción con débitos a cuenta PSE

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| bankCode | string | 4 | Código de la entidad financiera con la cual realizar la transacción |
| bankInterface | string | 1 | Tipo de interfaz del banco a desplegar [0 = PERSONAS, 1 = EMPRESAS] |
| returnURL | string | 255 | URL de retorno especificada para la entidad financiera |
| reference | string | 32 | Referencia única de pago |
| descriptiop | string | 255 | Descripción del pago |
| language | string | 2 | Idioma esperado para las transacciones acorde a ISO 631-1, mayúscula sostenida |
| currency | string | 3 | Moneda a usar para el recaudo acorde a ISO 4217 |
| totalAmount | float |  | Valor total a recaudar |
| taxAmount | float |  | Discriminación del impuesto aplicado |
| devolutionBase | float |  | Base de devolución para el impuesto |
| tipAmount | float |  | Propina u otros valores exentos de impuesto (tasa aeroportuaria) y que deben agregarse al valor total a pagar |
| payer | [Person](#person) |  | Información del pagador |
| buyer | [Person](#person) |  | Información del comprador |
| shipping | [Person](#person) |  | Información del receptor |
| ipAddress | string | 15 | Dirección IP desde la cual realiza la transacción el pagador |
| userAgent | string | 255 | Agente de navegación utilizado por el pagador |
| additionalData | array([Attribute](#attribute)) |  | Datos adicionales para ser almacenados con la transacción |
| credits | array([CreditConcept](#creditconcept)) |  | Detalle de la dispersión a realizar |

#### `PSETransactionResponse`
Estructura con la información de respuesta para la creación de una transacción

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| transactionID | int | | Identificador único de la transacción en PlacetoPay |
| sessionID | string | 32 | Identificador único de la sesión en PlacetoPay |
| returnCode | string | 30 | Código de respuesta de la transacción, uno de los siguientes valores: <br/> SUCCESS<br/>FAIL_ENTITYNOTEXISTSORDISABLED<br/>FAIL_BANKNOTEXISTSORDISABLED<br/>FAIL_SERVICENOTEXISTS<br/>FAIL_INVALIDAMOUNT<br/>FAIL_INVALIDSOLICITDATE<br/>FAIL_BANKUNREACHEABLE<br/>FAIL_NOTCONFIRMEDBYBANK<br/>FAIL_CANNOTGETCURRENTCYCLE<br/>FAIL_ACCESSDENIED<br/>FAIL_TIMEOUT<br/>FAIL_DESCRIPTIONNOTFOUND<br/>FAIL_EXCEEDEDLIMIT<br/>FAIL_TRANSACTIONNOTALLOWED<br/>FAIL_RISK<br/>FAIL_NOHOST<br/>FAIL_NOTALLOWEDBYTIME<br/>FAIL_ERRORINCREDITS<br/>|
| trazabilityCode | string | 40 | Código único de seguimiento para la operación dado por la red ACH |
| transactionCycle | int | | Ciclo de compensación de la red |
| bankCurrency | string | 3 | Moneda aceptada por el banco acorde a ISO 4217 |
| bankFactor | float | | Factor de conversión de la moneda |
| bankURL | string | 255 | URL a la cual remitir la solicitud para iniciar la interfaz del banco, sólo disponible cuando returnCode = SUCCESS |
| responseCode | int | | Estado de la operación en PlacetoPay [ 0 = FAILED, 1 = APPROVED, 2 = DECLINED, 3 = PENDING ] |
| responseReasonCode | string | 3 | Código interno de respuesta de la operación en PlacetoPay |
| responseReasonText | string | 255 | Mensaje asociado con el código de respuesta de la operación en PlacetoPay |

#### `TransactionInformation`
Estructura con la respuesta a una solicitud de información de transacción

| Nombre | Tipo | Long | Descripción |
| --- | --- | --- | --- |
| transactionID | int | | Identificador único de la transacción en PlacetoPay |
| sessionID | string | 32 | Identificador único de la sesión en PlacetoPay |
| reference | string | 32 | Referencia única de pago |
| requestDate | string | | Fecha de solicitud o creación de la transacción acorde a ISO 8601 |
| bankProcessDate | string | | Fecha de procesamiento de la transacción acorde a ISO 8601 |
| onTest | boolean | | Indicador de si la transacción es en modo de pruebas o no |
| returnCode | string | 30 | Código de respuesta de la transacción, uno de los siguientes: <br/> SUCCESS<br/>FAIL_INVALIDTRAZABILITYCODE<br/>FAIL_ACCESSDENIED<br/>FAIL_INVALIDSTATE<br/>FAIL_INVALIDBANKPROCESSINGDATE<br/>FAIL_INVALIDAUTHORIZEDAMOUNT<br/>FAIL_INCONSISTENTDATA<br/>FAIL_TIMEOUT<br/>FAIL_INVALIDVATVALUE<br/>FAIL_INVALIDTICKETID<br/>FAIL_INVALIDSOLICITEDATE<br/>FAIL_INVALIDAUTHORIZATIONID<br/>FAIL_TRANSACTIONNOTALLOWED<br/>FAIL_ERRORINCREDITS<br/>FAIL_EXCEEDEDLIMIT |
| trazabilityCode | string | 40 | Código único de seguimiento para la operación dado por la red ACH |
| transactionCycle | int | | Ciclo de compensación de la red |
| transactionState | string | 20 | Información del estado de la transacción [ OK, NOT_AUTHORIZED, PENDING, FAILED ] |
| responseCode | int | | Estado de la operación en PlacetoPay |
| responseReasonCode | string | 3 | Código interno de respuesta de la operación en PlacetoPay |
| responseReasonText | string | 255 | Mensaje asociado con el código de respuesta de la operación en PlacetoPay |
