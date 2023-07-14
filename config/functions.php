<?php
/**
 * Genere un UUID della versione 4
 * @return string
 */
function generate_uuidV4()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // impostare il byte 6 come 0100 (versione 4)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // impostare il byte 8 come 10 (variante)

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

/**
 * Codifica una stringa in base64url
 * @param $payload corpo del Token
 * @return string stringa codificata
 */
function base64url_encode($payload)
{
    $base64 = base64_encode($payload);
    $base64Url = strtr($base64, '+/', '-_');
    return rtrim($base64Url, '=');
}


/**
 * Decodifica una stringa da base64url
 * @param $base64Url stringa codificata in base64Url
 * @return string stringa decodificata
 */
function base64url_decode($base64Url)
{
    $base64 = strtr($base64Url, '-_', '+/');
    return base64_decode($base64);
}