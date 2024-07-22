<?php

namespace App\Custom\SocialLogin;

use App\Models\User;
use GuzzleHttp\Client;
use Lcobucci\JWT\Parser;
use App\Custom\SocialLogin\Abstracts\SocialLogin;

class AppleLogin extends SocialLogin
{

    /**
     * @throws \Exception
     */
    public function verify()
    {
        $user = User::where('email', $this->getEmail())->Where('login_type', 'apple')->first();

        if ($user) {
            $keyFileId = "DJ2662K62S";
            $teamId = "JV9G3ZW4QX";
            $clientId = "com.sunbi.bob";
            $keyFilePath = asset('key.txt'); //AuthKey_DJ2662K62S.pem

            $clientSecret = $this->generateJWT($keyFileId, $teamId, $clientId, $keyFilePath);

            $data = [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $this->getToken(),
                'grant_type' => 'authorization_code'
            ];

            // try {
            $client = new Client();
            $response = $client->post(
                'https://appleid.apple.com/auth/token',
                array('form_params' => $data)
            );
        
            $result = $response->getBody()->getContents();
            $result = json_decode($result);
    
            $mToken =(new Parser())->parse((string)  $result->id_token); // Parses from a string
            
            if ($mToken->getClaim('email') == $this->getEmail()) {
                $this->valid = true;
            } else {
                $this->valid = false;
            }
            // } catch (\Throwable $th) {
            //     $this->valid = false;
            // }
        } else {
            $token = (new Parser())->parse((string) $this->getToken()); // Parses from a string
        
            if ($token->getClaim('email') == $this->getEmail()) {
                $this->valid = true;
            } else {
                $this->valid = false;
            }
        }

        return $this;
    }

    /**
     * @param string $der
     * @param int    $partLength
     *
     * @return string
     */
    public static function fromDER(string $der, int $partLength)
    {
        $hex = unpack('H*', $der)[1];
        if ('30' !== mb_substr($hex, 0, 2, '8bit')) { // SEQUENCE
            throw new \RuntimeException();
        }
        if ('81' === mb_substr($hex, 2, 2, '8bit')) { // LENGTH > 128
            $hex = mb_substr($hex, 6, null, '8bit');
        } else {
            $hex = mb_substr($hex, 4, null, '8bit');
        }
        if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
            throw new \RuntimeException();
        }
        $Rl = hexdec(mb_substr($hex, 2, 2, '8bit'));
        $R = self::retrievePositiveInteger(mb_substr($hex, 4, $Rl * 2, '8bit'));
        $R = str_pad($R, $partLength, '0', STR_PAD_LEFT);
        $hex = mb_substr($hex, 4 + $Rl * 2, null, '8bit');
        if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
            throw new \RuntimeException();
        }
        $Sl = hexdec(mb_substr($hex, 2, 2, '8bit'));
        $S = self::retrievePositiveInteger(mb_substr($hex, 4, $Sl * 2, '8bit'));
        $S = str_pad($S, $partLength, '0', STR_PAD_LEFT);
        return pack('H*', $R.$S);
    }
    /**
     * @param string $data
     *
     * @return string
     */
    private static function preparePositiveInteger(string $data)
    {
        if (mb_substr($data, 0, 2, '8bit') > '7f') {
            return '00'.$data;
        }
        while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') <= '7f') {
            $data = mb_substr($data, 2, null, '8bit');
        }
        return $data;
    }
    /**
     * @param string $data
     *
     * @return string
     */
    private static function retrievePositiveInteger(string $data)
    {
        while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') > '7f') {
            $data = mb_substr($data, 2, null, '8bit');
        }
        return $data;
    }

    public function encode($data)
    {
        $encoded = strtr(base64_encode($data), '+/', '-_');
        return rtrim($encoded, '=');
    }

    public function generateJWT($kid, $iss, $sub, $keyFilePath)
    {
        $header = [
            'alg' => 'ES256',
            'kid' => $kid
        ];
        $body = [
            'iss' => $iss,
            'iat' => time(),
            'exp' => time() + 3600,
            'aud' => 'https://appleid.apple.com',
            'sub' => $sub
        ];

        $privKey = openssl_pkey_get_private(file_get_contents($keyFilePath));
        if (!$privKey) {
            return false;
        }

        $payload = $this->encode(json_encode($header)).'.'.$this->encode(json_encode($body));

        $signature = '';
        $success = openssl_sign($payload, $signature, $privKey, OPENSSL_ALGO_SHA256);
        if (!$success) {
            return false;
        }

        $raw_signature = $this->fromDER($signature, 64);

        return $payload.'.'.$this->encode($raw_signature);
    }
}
