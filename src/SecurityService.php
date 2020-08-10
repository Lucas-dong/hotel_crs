<?php

namespace HotelCrs;

class SecurityService extends Common
{
    public function appLogin($username = 'KWS', $password = '8888')
    {
        $xml = new \DOMDocument("1.0", "utf-8");
        $xml_track = $xml->createElement("soap:Envelope");
        $xml_track->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $xml_track->setAttribute("xmlns:xsd", "http://www.w3.org/2001/XMLSchema");
        $xml_track->setAttribute("xmlns:soap", "http://schemas.xmlsoap.org/soap/envelope/");

        $xml_note = $xml->createElement("soap:Body");
        $xml_track->appendChild($xml_note);

        $AppLogin = $xml->createElement("AppLogin");
        $AppLogin->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $xml_note->appendChild($AppLogin);

        $username = $xml->createElement("username", $username);
        $password = $xml->createElement("password", $password);
        $AppLogin->appendChild($username);
        $AppLogin->appendChild($password);

        $xml->appendChild($xml_track);
        $xmldata = $xml->saveXML();
        $result = $this->xml_curl_post($this->apiUrlConfigs['SecurityService'], $xmldata, 'AppLogin');

        $data = $this->xmlHandle($result);
        if (!empty($data['errcode'])) {
            return $data;
        }
        return $this->success($data[0][0]['KwsSoapHeader']['SessionId'], 'SessionId');
    }
}
