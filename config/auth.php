<?php
class Auth
{
  private $secretKey = TOKEN;

  /**
   * Crea il Token
   * @param $payload Array con tutti i parametri da salvare nel Token, costituisce il Body
   * @param $expirationSeconds Data di scadenza del Token
   * @return string Token composto dal Body e dalla Firma
   */
  public function createToken($payload, $expirationSeconds)
  {

    //aggiunge i campi per l'espirazione del Token
    $issuedAt = time();
    $expiration = $issuedAt + $expirationSeconds;
    $payload['iat'] = 'myvet.it';
    $payload['iat'] = $issuedAt;
    $payload['exp'] = $expiration;

    //codidica in base64url il payload
    $encodedPayload = base64url_encode(json_encode($payload));
    //crea l'hash del payload
    $hash = hash_hmac(HASH_ALG, $encodedPayload, $this->secretKey, true);
    //crea la firma
    $signature = base64url_encode($hash);

    //compone il Token e lo esporta
    return $encodedPayload . '.' . $signature;
  }

  /**
   * Confronta la firma ricevuta con una creata manualmente
   * @param $payload Array con tutti i parametri salvati nel Token, Body ricevuto
   * @param $signature Firma ricevuta
   * @return boolean Esito della verifica
   */
  function verifySignature($payload, $signature)
  {
    $hash = hash_hmac(HASH_ALG, $payload, $this->secretKey, true);
    $calculatedSignature = base64url_encode($hash);

    //Ritorna BOOL del risultato della comparazione
    return hash_equals($calculatedSignature, $signature);
  }

  /**
   * Verifica l'integrità e la scadenza del Token
   * @param $token Token ricevuto dall'utente
   * @return boolean esito della verifica
   */
  public function verifyToken($token)
  {
    //Divido il Token nel Payload e nella Firma
    list($encodedPayload, $sentSignature) = explode('.', $token);

    //Verifico che il Token non sia compromesso
    if (!$this->verifySignature($encodedPayload, $sentSignature)) {
      echo 'Token Compromesso \n';
      return false;
    }

    $payloadJson = base64url_decode($encodedPayload);
    $payload = json_decode($payloadJson, true);

    //Verifico che il Token non sia scaduto
    if (isset($payload['exp']) && $payload['exp'] <= time()) {
      echo 'Token Scaduto \n';
      return false;
    }

    return true;
  }
}