<?php

namespace App\Http\Services\Message\SMS;

class MeliPayamakService
{
    public function SendSimpleSMS2($from, $to, $text)
    {
        $url = 'https://console.melipayamak.com/api/send/simple/0ebd3f67b99848539507c69902b7d4db';
        $data = array('from' => $from, 'to' => $to, 'text' => $text);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        // to debug
        // if(curl_errno($ch)){
        //     echo 'Curl error: ' . curl_error($ch);
        // }
    }

    public function SendSimpleSMS($from, array $to, $text, $udh = '')
    {
        $url = 'https://console.melipayamak.com/api/send/advanced/0ebd3f67b99848539507c69902b7d4db';
        $data = array(
            'from' => $from, 'to' => $to,
            'text' => $text, 'udh' => $udh
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        // to debug
        // if(curl_errno($ch)){
        //     echo 'Curl error: ' . curl_error($ch);
        // }
    }

    public function sendWithServiceLine($bodyId, $to, $args)
    {
        $url = 'https://console.melipayamak.com/api/send/shared/0ebd3f67b99848539507c69902b7d4db';
        $data = array('bodyId' => $bodyId, 'to' => $to, 'args' => $args);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function sendWithDomain($from, $to, $text, $domain)
    {
        $url = 'https://console.melipayamak.com/api/send/withdomain/0ebd3f67b99848539507c69902b7d4db';
        $data = array(
                'from' => $from, 'to' => $to, 'text' => $text,
                'domain' => $domain
            );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }
    public function sendManyMessageToMany($from, $to, $text, $udh = '')
    {
        $url = 'https://console.melipayamak.com/api/send/multiple/0ebd3f67b99848539507c69902b7d4db';
        $data = array(
                'from' => $from, 'to' => $to,
                'text' => $text, 'udh' => $udh
            );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function GetDeliveries ($recIds)
    {
        $url = 'https://console.melipayamak.com/api/receive/status/0ebd3f67b99848539507c69902b7d4db';
        $data = array('recIds' => $recIds);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function GetMessages($type , $number, $index, $count)
    {
        $url = 'https://console.melipayamak.com/api/receive/messages/0ebd3f67b99848539507c69902b7d4db';
        $data = array('type' => $type, 'number' => $number, 'index' => $index, 'count' => $count);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function GetInboxCount($isReady)
    {
        $url = 'https://console.melipayamak.com/api/receive/inboxcount/0ebd3f67b99848539507c69902b7d4db';
        $data = array('isRead' => $isReady);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function GetCredit(){
        $url = 'https://console.melipayamak.com/api/receive/credit/0ebd3f67b99848539507c69902b7d4db';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: 0'
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }

    public function GetSMSPrice($mtnCount, $irancellCount, $from, $text)
    {
        $url = 'https://console.melipayamak.com/api/receive/price/0ebd3f67b99848539507c69902b7d4db';
        $data = array(
                'mtnCount' => $mtnCount, 'irancellCount' => $irancellCount,
                'from' => $from, 'text' => $text
            );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
// to debug
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }
    }
}
