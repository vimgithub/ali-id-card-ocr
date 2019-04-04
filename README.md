## Description

- Ali-idcard-ocr is a laravel package for ID card identification verification through Alibaba Cloud's open API

## App  Code
- Please apply for your ```app_code ``` before use.

## key words
- Key words: 印刷文字识别-身份证识别

## Install
```
composer require zev/ali-id-card-ocr
```

## Quick Start
```
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Zev\AliIdCardOcr\IdCardOCR\AliIdCardOCR;

class ExampleController extends  Controller
{
    
    /**
    * Identification verification face/back and compare user input information
    * 识别验证-正/反面-并比对用户输入信息
    * 
    * @param Request $request
    * @param string $side- face|back
    * @param bool $isBase64 | default false
    * @return array|\Illuminate\Http\JsonResponse|string
    */
    public function ocrTest(Request $request)
    {
        // $face and $back is the face and back file name
        $res = AliIdCardOCR::idCardVerify(
            $request->username,
            $request->idNum, 
            $face,
            $back,
            $isBase64 = false);
       
        return $res;
    }
    
    
    /**
    * Only Identification verification face/back
    * 仅识别验证正/反面信息
    * 
    * @param Request $request
    * @param string $side- face|back
    * @param string $file | file or base64
    * @param bool $base64 | default false
    * @return array|\Illuminate\Http\JsonResponse|string
    */
    
    public function sideOcrTest($side, $file, $base64 = false)
    {
        $res = AliIdCardOCR::IdVerify($side, $fileName, $base64)
        
        return $res;
    }
    
}
```

## Custom configuration
```
php artisan vendor:publish --provider="Zev\AliIdCardOcr\AliIdCardOcrServiceProvider"
//or usage
php artisan vendor:publish --tag=aliIdCardOCR-config

//Custom config
return [

    // Request URL
    'ocr_url'  => env('OCR_URL','https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json'),

    // Your AppCode
    'app_code'  => env('OCR_APP_CODE','your-app-code'),

    // the face and back file the storage path of face and back file
    'file_path'  => storage_path('app/public/upload/')
    
     // Whether to return identity information
    'is_identity_return' => env('IS_IDENTITY_RETURN', false),

];


```

## Application address
- https://market.aliyun.com/products/57124001/cmapi010401.html?spm=5176.730005-56956004-57124001.aliyun_market_list_right.5.47ad3524pZtEx3

