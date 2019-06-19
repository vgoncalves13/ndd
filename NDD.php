<?php

class NDD
{
    function encrypt($data)
    {
        $key = utf8_encode('G!P@4#1$1%M4SC4D');
        $iv = utf8_encode('C#&UjO){QwzFcsPs');
        $data = utf8_encode($data);
        $method = 'AES-128-CBC';
        $blockSize = 16;

        //PKCS#7
        $pad = $blockSize - (strlen($data) % $blockSize);
        $data = $data.str_repeat(chr($pad), $pad);

        $enc_text = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        $enc_text = base64_encode($enc_text);

        return $enc_text;
    }

    public function test()
    {
        $client = new SoapClient('https://api-printjobs.nddprint.com/PrintJobsWS/PrintJobsData.asmx?wsdl');

        $function = 'GetPrintJobs';
        $enterpriseName = 'FURNAS';
        $enterpriseKey = '2F-9C-7B-B6-EE-39-CF-10-E4-F1-A2-02-5B-F1-F9-B6';
        $authDomainName = 'corp.furnas';
        $authLogonName = 'fc153637';
        $authPassword = $this->encrypt('123mudar');
        $filterDate = '2019-05-01';
        $filterDateType = '0';
        $fieldList = 'Summarize';

        $arguments = array('GetPrintJobs' => array(
            'enterpriseName' => $enterpriseName,
            'enterpriseKey' => $enterpriseKey,
            'authDomainName' => $authDomainName,
            'authLogonName' => $authLogonName,
            'authPassword' => $authPassword,
            'filterDate' => '2019-05-01',
            'filterDateType' => '0',
            'fieldList' => 'Summarize'
        ));
        $options = array('location' => 'https://api-printjobs.nddprint.com/PrintJobsWS/PrintJobsData.asmx');


        $result = $client->__soapCall($function, $arguments, $options);

        print_r($result);
    }

}