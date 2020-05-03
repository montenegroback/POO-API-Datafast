# POO-API-Datafast
Simple Modelo para crear request a Datafast para gestionar los pagos

# Uso
### Generar un Checkout ID
```
$datafast = new DataFastRequest();
$datafast->total_tarifa12 = 1.00;
$datafast->customer_giver_name = "";
$datafast->customer_middle_name = "";
$datafast->customer_surname = "";
$datafast->customer_merchant_customer_id = "";
$datafast->merchant_transaction_id ="transaction_".time();
$datafast->customer_email = '';
$datafast->customer_identification_doc_id = "";
$datafast->customer_phone = "";
$datafast->billing_street1 = "";

$checkout = $datafast->checkoutComplete();
return $checkout;
```
### Mostrar formulario de pago
```
<form action="<URL donde Datafast redireccionará complada la transacción>" class="paymentWidgets" data-brands="VISA MASTER AMEX DINERS DISCOVER"></form>

<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkout['id'] }}"></script>
```

### Validación de pago
Una vez que se introduce los datos en el formulario de pago, se recogue el parametro ``resourcePath`` que viene en la url donde fuimos redireccionados para validar y completar el pago.

```
$resourcePath =  request()->get('resourcePath'); // $_GET['resourcePath']

$datafast = new DataFastRequest();
$responseData = $datafast->payment($resourcePath);
return $responseData;
````
### Importante

Esta implementación no es oficial de DataFast. Simplemente fue creado con fines de mejores practicas en la implementación de una web. 