<?php

namespace HotelCrs;

class Common
{
    protected $xml;
    protected $Envelope;
    protected $Body;
    protected $apiUrlConfigs;

    public function __construct()
    {
        $this->apiUrlConfigs = include __DIR__ . '/../config/apiUrl.php';
    }

    public function xmlHeader($sessionId)
    {
        $this->xml = new \DOMDocument("1.0", "utf-8");
        $this->Envelope = $this->xml->createElement("soap:Envelope");
        $this->Envelope->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $this->Envelope->setAttribute("xmlns:xsd", "http://www.w3.org/2001/XMLSchema");
        $this->Envelope->setAttribute("xmlns:soap", "http://schemas.xmlsoap.org/soap/envelope/");

        # header sessionid
        $Header = $this->xml->createElement("soap:Header");
        $this->Envelope->appendChild($Header);
        $KwsSoapHeader = $this->xml->createElement("KwsSoapHeader");
        $KwsSoapHeader->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $Header->appendChild($KwsSoapHeader);
        $SessionId = $this->xml->createElement("SessionId", $sessionId);
        $KwsSoapHeader->appendChild($SessionId);
        # header sessionid

        $this->Body = $this->xml->createElement("soap:Body");
        $this->Envelope->appendChild($this->Body);
    }

    /**
     * xml 处理
     * @param mixed $result 
     * @return array 
     */
    public function xmlHandle($result)
    {
        $xmlObj = simplexml_load_string($result);
        $xmlObj->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $header = $xmlObj->xpath('soap:Header');

        $body = $xmlObj->xpath("soap:Body");
        $body = $this->object_to_array($body);
        $header = $this->object_to_array($header);
        if (!empty($header[0]['KwsSoapHeader']['ErrReason'])) {
            return $this->error($header[0]['KwsSoapHeader']['RetCode'], $header[0]['KwsSoapHeader']['ErrReason']);
        }
        return [$header, $body];
    }

    /**
     * 执行结尾
     * @param mixed $service 
     * @param mixed $api 
     * @return array 
     */
    public function xmlFoot($service, $api)
    {
        $this->xml->appendChild($this->Envelope);
        $xmldata = $this->xml->saveXML();

        $result = $this->xml_curl_post($this->apiUrlConfigs[$service], $xmldata, $api);
        return $this->xmlHandle($result);
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    protected function object_to_array($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
        return $obj;
    }

    /**
     * curl xml request
     *
     * @param string $url
     * @param string $param
     * @param array $header
     * @return void
     */
    protected function xml_curl_post($url, $param, $header)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $headers = ['Content-Type: text/xml', 'SOAPAction: http://www.shijinet.com.cn/kunlun/kws/1.1/' . $header];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function success($data, $key = 'data')
    {
        return ['errcode' => '0', 'errmsg' => 'ok', $key => $data];
    }

    public function error($code, $msg)
    {
        return ['errcode' => $code, 'errmsg' => $msg];
    }
}
