<?php

namespace Zev\AliIdCardOcr\Exceptions;

/**
 * 常用错误码
 *
 * Class ErrorCode
 * @package Zev\AliIdCardOcr\Exceptions
 */
class ErrorCode
{
    /**
     * ----------------------------------------------------
     * 参考网址
     * https://help.aliyun.com/document_detail/95605.html
     * https://help.aliyun.com/document_detail/43906.html
     * ----------------------------------------------------
     */

    const OCR_ERROR = [

        // 认证请求
        400 => ['code' => 400, 'msg' => 'URL错误'],
        403 => ['code' => 403, 'msg' => '授权过期或URL错误'],
        408 => ['code' => 408, 'msg' => '请求超时'],
        413 => ['code' => 413, 'msg' => '内容过大'],

        // 网络拥挤
        450 => ['code' => 450, 'msg' => '网络拥挤稍后重试'],

        // 数据格式错误
        460 => ['code' => 460, 'msg' => '数据格式非法'],
        461 => ['code' => 461, 'msg' => '数据解析错误'],

        // 图像解析失败
        462 => ['code' => 462, 'msg' => '图像编解码失败'],
        463 => ['code' => 463, 'msg' => '非法的图像类型'],

        // 识别异常
        464 => ['code' => 464, 'msg' => 'OCR识别异常'],
        469 => ['code' => 469, 'msg' => '内部异常'],

        // 超时
        502 => ['code' => 502, 'msg' => '识别超时'],
        503 => ['code' => 503, 'msg' => 'API网关超时']

    ];

}
