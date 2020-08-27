<?php 
    /**
     * @Author: Cesar Montenegro 
     * @Email: montenegroback@gmail.com
     * 
     * @Description: OOP API DataFast 
     * 
     * @IMPORTANTE: Esta implementación no es oficial de DataFast. 
     * 
     */

class DataFastRequest {
    
    /**
     * Url peticiones test mode (https://test.oppwa.com) y producción (https://oppwa.com)
     *
     * 
     * @var string
    */
    protected $url_request = "https://test.oppwa.com";
    
    /**
     * Identificador de entidad
     *
     * 
     * @var string
    */
    protected $entity_id = "";

    /**
     * Parámetro de cabecera para autenticación
     *
     * 
     * @var string
    */
    protected $bearer_token = "";

    /**
     * Indica el identificador del comercio
     *
     * 
     * @var string
    */
    protected $MID = "";

    /**
     * Indica el identificador del terminal
     *
     * 
     * @var strings
    */
    protected $TID = "";

    /**
     * Monto total obtenido de la transacción, respetando los dos dígitos para decimales.
     *
     * 
     * @var double
    */

    public $amount = 1.00;

    /**
     * Tipo de moneda por default es USD
     *
     * 
     * @var string
    */

    public $currency = "USD";

    /**
     * Tipo de pagos, para transaciones de compra va DB
     *
     * 
     * @var string
    */

    public $payment_type = "DB";

    /**
     * CURLOPT_SSL_VERIFYPEER false test and true production
     *
     * 
     * @var boolean
    */

    protected $CURLOPT_SSL_VERIFYPEER = false;

    /**
     * risk_parameters[USER_DATA2] Nombre del comercio
     *
     * 
     * @var string
    */

    public $risk_parameters = "";

    /**
     * CustomersParams IVA
     *
     * 
     * @var double
    */

    public $iva = 0.12;

    /**
     * CustomersParams Tota Tarifa 12
     *
     * 
     * @var double
    */

    public $total_tarifa12 = 0.00;

    /**
     * CustomersParams Tota Base 0
     *
     * 
     * @var double
    */

    public $total_base0 = 0.00;

    /**
     * Primer nombre del cliente
     *
     * 
     * @var string
    */

    public $customer_giver_name;

    /**
     * Segundo nombre del cliente
     *
     * 
     * @var string
    */

    public $customer_middle_name;

    /**
     * Apellido del cliente
     *
     * 
     * @var string
    */

    public $customer_surname;

    /**
     * Dirección IP del cliente
     *
     * 
     * @var string
    */

    public $customer_ip;

    /**
     * ID Cliente en la plataforma
     *
     * 
     * @var string
    */

    public $customer_merchant_customer_id;

    /**
     * Número de Transacción
     *
     * 
     * @var string
    */

    public $merchant_transaction_id;

    /**
     * Email del cliente
     *
     * 
     * @var string
    */

    public $customer_email;

    /**
     * Identificación del cliente por default IDCARD
     *
     * 
     * @var string
    */

    private $CUSTOMER_INDETIFICATION_DOC_TYPE = "IDCARD";

    /**
     * Cedula o RUF del cliente (siempre de 10 dígitos)
     *
     * 
     * @var string
    */

    public $customer_identification_doc_id;

    /**
     * Teléfono del cliente (siempre de 10 dígitos)
     *
     * 
     * @var string
    */

    public $customer_phone;


    /**
     * Dirección del cliente (Maximo 100 caracteres)

        *
        * 
        * @var string
    */

    public $billing_street1;

    /**
     * País del cliente EC, CL, US, etc. Formato ISO 3166-1)

        *
        * 
        * @var string
    */

    public $billing_country = 'EC';

    /**
     * Dirección de entrege del cliente (Maximo 100 caracteres)

        *
        * 
        * @var string
    */

    public $shipping_street1;

    /**
     * País de entrega EC, CL, US, etc. Formato ISO 3166-1)

        *
        * 
        * @var string
    */

    public $shipping_country = 'EC';


    public function __contructor(){
    }

    public function __get($name){
        return $this->$name;
    }

    public function __set($name, $value){
        return $this->$name = $value;
    }

    /**
     * Modifica la url
     *
     * 
     * @function
    */
    public function setRequestUrl($url){
        $this->url_request = $url;
    }

    /**
     * Modifica el token
     *
     * 
     * @function
    */
    public function setRequestToken($_token){
        $this->bearer_token = $_token;
    }

    /**
     * Modifica el entity_id
     *
     * 
     * @function
    */
    public function setRequestEntityId($entity_id){
        $this->entity_id = $entity_id;
    }

    /**
     * Obtener el valor calculado del iva
     *
     * 
     * @function
    */

    public function getMerchantTransactionId() {
        return $this->merchant_transaction_id;
    }

    /**
     * Obtener el valor calculado del iva
     *
     * 
     * @function
    */

    private function getValueIva() {
        $iva = str_replace('.', '', $this->getApplyIva());
        return str_pad($iva, 12, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener el valor calculado del tarifa 12
     *
     * 
     * @function
    */

    private function getTotalTaria12() {
        $total_tarifa12 = str_replace('.', '', $this->total_tarifa12);
        return str_pad($total_tarifa12, 12, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener el valor calculado del tarifa base 0
     *
     * 
     * @function
    */

    private function getTotalBase0() {
        $total_base0 = str_replace('.', '', $this->total_base0);
        return str_pad($total_base0, 12, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener el iva del precio totaltarifa12 que funje como un subtotal
     *
     * 
     * @function
    */

    private function getApplyIva() {
        return $this->total_tarifa12 * $this->iva;
    }

    /**
     * Obtener el monto total a pagar incluyendo su iva
     *
     * 
     * @function
    */

    private function getAmount() {
        return $this->getApplyIva() + $this->total_tarifa12;
    }

    /**
     * Obtener customParametersValue
     *
     * 
     * @function
    */

    public function getCustomParametersValue() {
        return '00810030070103910004012'.$this->getValueIva().'05100817913101052012'.$this->getTotalBase0().'053012'.$this->getTotalTaria12();
    }

    /**
     * Ejecuta la solicitud de pago con la información basica inicial
     *
     * 
     * @function
    */

    public function checkoutInitial() {
        return $this->requestCheckoutInitial();
    }

    /**
     * Ejecuta la solicitud de pago con la información completa
     *
     * 
     * @function
    */

    public function checkoutComplete() {
        return $this->requestCheckoutComplete();
    }
    
    public function payment($resourcePath) {
        return $this->setRequestPayment($resourcePath);
    }

    public function cancelTransaction($data) {
        return $this->setRequestCancelTransaction($data);
    }

    private function requestCheckoutInitial() {

        $data = "entityId=".$this->entity_id.
                "&amount=".$this->getAmount().
                "&currency=".$this->currency.
                "&paymentType=".$this->payment_type;
    
        return $this->execCurlCheckout($data);
            

    }

    private function requestCheckoutComplete() {

            $data = 'authentication.entityId='.$this->entity_id.
            '&amount='.$this->getAmount().
            '&currency='.$this->currency.
            '&paymentType='.$this->payment_type.
            '&customer.givenName='.$this->customer_giver_name.
            '&customer.middleName='.$this->customer_middle_name.
            '&customer.surname='.$this->customer_surname.
            '&customer.ip='.$this->customer_ip.
            '&customer.merchantCustomerId='.$this->customer_merchant_customer_id.
            '&merchantTransactionId='.$this->merchant_transaction_id.
            '&customer.email='.$this->customer_email.
            '&customer.identificationDocType='.$this->CUSTOMER_INDETIFICATION_DOC_TYPE.
            '&customer.identificationDocId='.$this->customer_identification_doc_id.
            '&customer.phone='.$this->customer_phone.
            '&billing.street1='.$this->billing_street1.
            '&billing.country='.$this->billing_country.
            '&shipping.street1='.$this->shipping_street1.
            '&shipping.country='.$this->shipping_country.
            '&risk.parameters[USER_DATA2]='.$this->risk_parameters.
            '&customParameters['.$this->MID.'_'.$this->TID.']='.$this->getCustomParametersValue().
            '&testMode=EXTERNAL';
            return $this->execCurlCheckout($data);
    }
    
    private function setRequestPayment($resourcePath) {
        $url = $this->url_request.$resourcePath;
        $url .= "?entityId=".$this->entity_id;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:Bearer '.$this->bearer_token));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->CURLOPT_SSL_VERIFYPEER);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return json_decode(curl_errno($ch), true);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

    private function setRequestCancelTransaction($data){
        $url = $this->url_request."/".$data['df_transaction_id'];

        $data = 'authentication.entityId='.$this->entity_id.
        "&paymentType=RF".
        '&amount='.$data['amount'].
        '&currency='.$this->currency.
        '&customParameters[AUTHCODE]='.$data['auth_code'].
        '&customParameters[PAN]='.$data['card_number'].
        '&customParameters[STAN]='.$data['df_refence'].
        '&customParameters[expiryMonth]='.$data['card_month'].
        '&customParameters[expiryYear]='.$data['card_year'].
        '&customParameters['.$this->MID.'_'.$this->TID.']='.$this->getCustomParametersValue().
        '&testMode=EXTERNAL';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '.$this->bearer_token));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->CURLOPT_SSL_VERIFYPEER);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if(curl_errno($ch)){
            return json_decode(curl_errno($ch), true);
        }
        curl_close($ch);
        return json_decode($response, true);

    }

    private function execCurlCheckout($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_request. "/v1/checkouts");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer '.$this->bearer_token));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->CURLOPT_SSL_VERIFYPEER);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if(curl_errno($ch)){
            return json_decode(curl_errno($ch), true);
        }
        curl_close($ch);
        return json_decode($response, true);
    }
}
?>
