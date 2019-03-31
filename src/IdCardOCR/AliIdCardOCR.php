<?php

namespace Zev\AliIdCardOcr\IdCardOCR;


class AliIdCardOCR
{

    /**
     * 身份证识别认证
     *
     * @param $side
     * @param $fileName
     * @return array
     */
    public static function IdVerify($side, $fileName)
    {
        $url = config('aliIdCardOcr.ocr_url');
        $appCode = config('aliIdCardOcr.app_code');
        $file = config('aliIdCardOcr.file_path').$fileName;

        //如果输入带有inputs, 设置为True，否则设为False
        $is_old_format = false;

        //如果没有configure字段，config设为空
        $config = [  "side" => $side ];

        if($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file)); // 文件读取
            fclose($fp);
            $base64 = base64_encode($binary); // 转码
        }

        $headers = self::header($appCode);
        $querys = "";

        $body = self::ocrRequest($base64, $config, $is_old_format);
        $method = "POST";

        // 请求验证
        $res = self::curlRequest ($method, $url, $headers, $body);

        return $res;
    }

    /**
     * 请求头处理
     *
     * @param $appCode
     * @return array
     */
    public static function header($appCode)
    {
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appCode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");

        return $headers;
    }

    /**
     * 请求参数处理
     *
     * @param $base64
     * @param $config
     * @param $is_old_format
     * @return false|string
     */
    private static function ocrRequest($base64, $config, $is_old_format)
    {
        $request = [ "image" => "$base64"];
        if(count($config) > 0){ $request["configure"] = json_encode($config); }
        $body = json_encode($request);

        if($is_old_format == TRUE){
            $request = [ 'image' => ["dataType" => 50,  "dataValue" => "$base64"] ];
            if(count($config) > 0){ $request["configure"] = ["dataType" => 50,"dataValue" => json_encode($config)]; }
            $body = json_encode(array("inputs" => array($request)));
        }

        return $body;
    }

    /**
     * 验证请求
     *
     * @param $method
     * @param $url
     * @param $headers
     * @param $body
     * @param bool $is_old_format
     * @return array
     */
    public static function curlRequest($method, $url, $headers, $body, $is_old_format = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$url, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $rheader = substr($result, 0, $header_size);
        $rbody = substr($result, $header_size);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        if($httpCode == 200){
            $result_str = $rbody;
            if($is_old_format){
                $output = json_decode($rbody, true);
                $result_str = $output["outputs"][0]["outputValue"]["dataValue"];
            }

            $data= json_decode($result_str,true);

            return ['code' => $httpCode, 'data'=> $data, 'result'=>$data['success']];
        }

        return ['code' => $httpCode, 'msg'=> $rbody];
    }

    /**
     * 识别并验证输入与身份证件信息
     *
     * @param $username
     * @param $idNum
     * @param string $face
     * @param string $back
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public static function idCardVerify($username, $idNum, $face='', $back='')
    {
        // 识别验证身份证正面
        $face = self::IdVerify('face', $face);

        // 请求异常
        if ($face['code'] != 200) {
            return $face;
        }

        // 身份证正面识别失败
        if (!$face['data']['success']) {
            return ['code'=>100, 'msg'=>'证件正面识别验证失败'];
        }

        // 验证证件与输入信息是否一致
        $inputVerify = self::verifyIdCardInput($face['data'], $username, $idNum);
        if (!$inputVerify) {
            return ['code'=>101, 'msg'=>'输入信息与证件信息不一致'];
        }

        // 识别验证身份证反面
        $back = self::IdVerify('back', $back);

        // 请求异常
        if ($back['code'] != 200) {
            return $back;
        }

        // 身份证反面识别失败
        if (!$back['data']['success']) {
            return ['code'=>100, 'msg'=>'证件反面识别验证失败'];
        }

        return ['code'=>0, 'msg'=>'验证通过'];
    }


    /**
     * 验证输入信息是否与证件信息一致
     *
     * @param $face
     * @param $username
     * @param $idNum
     * @return bool
     */
    public function verifyIdCardInput($face, $username, $idNum)
    {
        return ($face['name'] == $username && $face['num'] == $idNum) ? true : false;
    }
}
