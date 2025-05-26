<?php
if (!function_exists('toPersianNumber')) {
    function toPersianNumber($number)
    {
        $number = (float) $number;
        $farsiDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        // Remove decimals if number is an integer
        $formatted = fmod($number, 1) == 0
            ? number_format($number, 0, '.', ',')
            : number_format($number, 2, '.', ',');

        return strtr($formatted, [
            '0' => $farsiDigits[0],
            '1' => $farsiDigits[1],
            '2' => $farsiDigits[2],
            '3' => $farsiDigits[3],
            '4' => $farsiDigits[4],
            '5' => $farsiDigits[5],
            '6' => $farsiDigits[6],
            '7' => $farsiDigits[7],
            '8' => $farsiDigits[8],
            '9' => $farsiDigits[9],
        ]);
    }
}
if (!function_exists('sendWhatsappMsg')) {
    function sendWhatsappMsg($number,$string)
    {
        $params = array(
            'token' => 'gwdmryxr9etg69t1444ggg',
            'to' => $number,
            'body' =>$string
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance118877/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
           return false;
        } else {
            return true;
        }
    }
}
