<?php

namespace HotelCrs;

/**
 * 会员管理服务
 * 
 * @package HotelCrs
 */
class ProfileService extends Common
{
    public function __construct($sessionId)
    {
        parent::__construct();
        $this->xmlHeader($sessionId);
    }

    /**
     * 通过手机号获取用户信息
     * 
     * @param integer $phone 手机号
     * @return void 
     */
    public function getMemberInfoByTelephone($phone)
    {
        $xmlData = $this->xml->createElement(ucfirst(__FUNCTION__));
        $xmlData->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $this->Body->appendChild($xmlData);

        $telephone = $this->xml->createElement("telephone", $phone);
        $xmlData->appendChild($telephone);

        $result = $this->xmlFoot('ProfileService', ucfirst(__FUNCTION__));
        if (!empty($result['errcode'])) {
            return $result;
        }
        return $this->success($result[1][0]['GetMemberInfoByTelephoneResponse']['GetMemberInfoByTelephoneResult']['SvcMemberInfo']);
    }

    /**
     * 通过卡号获取用户信息
     * 
     * @param integer $cardNo 卡号
     * @return void 
     */
    public function getMemberInfoByCardNo($cardno)
    {
        $xmlData = $this->xml->createElement(ucfirst(__FUNCTION__));
        $xmlData->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $this->Body->appendChild($xmlData);

        $cardNo = $this->xml->createElement("cardNo", $cardno);
        $xmlData->appendChild($cardNo);

        $result = $this->xmlFoot('ProfileService', ucfirst(__FUNCTION__));
        if (!empty($result['errcode'])) {
            return $result;
        }
        return $this->success($result[1][0]['GetMemberInfoByCardNoResponse']['GetMemberInfoByCardNoResult']);
    }

    /**
     * 查询会员积分流水
     * 
     * @param integer $cardNo 卡号
     * @param integer $startTime 起始时间 2010-01-01
     * @param integer $endTime 结束时间 2010-01-01
     * @return void 
     */
    public function getPointAccrueListByTime($cardno, $startTime = '1970-01-01', $endTime = '2199-01-01')
    {
        $xmlData = $this->xml->createElement(ucfirst(__FUNCTION__));
        $xmlData->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $this->Body->appendChild($xmlData);

        $cardNo = $this->xml->createElement("cardNo", $cardno);
        $startTime = $this->xml->createElement("startTime", $startTime);
        $endTime = $this->xml->createElement("endTime", $endTime);
        $xmlData->appendChild($cardNo);
        $xmlData->appendChild($startTime);
        $xmlData->appendChild($endTime);

        $result = $this->xmlFoot('ProfileService', ucfirst(__FUNCTION__));
        if (!empty($result['errcode'])) {
            return $result;
        }
        return $this->success($result[1][0]['GetPointAccrueListByTimeResponse']);
    }

    /**
     * 查询会员某个酒店可用礼券列表
     * 
     * @param integer $cardNo 卡号
     * @param integer $hotelCode 酒店编码
     * @return void 
     */
    public function getAvailableCouponsByCardNoAndHotel($cardno, $hotelCode)
    {
        $xmlData = $this->xml->createElement(ucfirst(__FUNCTION__));
        $xmlData->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $this->Body->appendChild($xmlData);

        $cardNo = $this->xml->createElement("cardNo", $cardno);
        $hotel_code = $this->xml->createElement("hotel_code", $hotelCode);
        $xmlData->appendChild($cardNo);
        $xmlData->appendChild($hotel_code);

        $result = $this->xmlFoot('ProfileService', ucfirst(__FUNCTION__));
        if (!empty($result['errcode'])) {
            return $result;
        }
        return $this->success($result[1][0]['GetAvailableCouponsByCardNoAndHotelResponse']);
    }

    /**
     * 查询会员可用礼券列表
     * 
     * @param integer $cardNo 卡号
     * @return void 
     */
    public function getPointExchangeList($cardno)
    {
        $xmlData = $this->xml->createElement(ucfirst(__FUNCTION__));
        $xmlData->setAttribute("xmlns", "http://www.shijinet.com.cn/kunlun/kws/1.1/");
        $this->Body->appendChild($xmlData);

        $cardNo = $this->xml->createElement("cardNo", $cardno);
        $xmlData->appendChild($cardNo);

        $result = $this->xmlFoot('ProfileService', ucfirst(__FUNCTION__));
        if (!empty($result['errcode'])) {
            return $result;
        }
        return $this->success($result[1][0]['GetPointExchangeListResponse']);
    }
}
