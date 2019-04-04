<?php
/**
 * Created by PhpStorm.
 * User: zev
 * Date: 2019/03/30
 * Time: 10:20
 */

return [

    /*
   |--------------------------------------------------------------------------
   | 阿里ID-OCR识别配置
   |--------------------------------------------------------------------------
   |
   | 该文件用以身份证识别认证参数配置
   |
   */


    // 认证请求url
    'ocr_url'  => env('OCR_URL','https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json'),

    // 应用的AppCode
    'app_code'  => env('OCR_APP_CODE','61a494bcca0d4275b2e6363a7b190d57'),

    // 识别文件存储路径
    'file_path'  => storage_path('app/public/upload/'),

    // 是否返回证件信息
    'is_identity_return' => env('IS_IDENTITY_RETURN', false),

];