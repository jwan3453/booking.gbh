<?php
namespace App\Service\Common;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\UserImage;

use App\Tool\MessageResult;

use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

use App\Models\Config;
/**
 *
 */
class ImageService
{
    private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = '';
    private $auth;


    function __construct()
    {
        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);
        $this->bucket =Config::where('item','bucket')->select('value')->first()->value;
    }


    //上传图片
    public function uploadImage(Request $request)
    {


        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);

        $imageObj=null;
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        $jsonResult = new MessageResult();
        $imageType = $request->input('imageType');
        // $type = 0;//1 用户头像 2为评论图片


        if($imageType ==1)
        {
            $file = $request->file('avatarFile');
            $userId = 1;//todo 获取userid
            $isNew = false;
            $filename ='avatar/'.$userId.'/'.uniqid().'.'.$file->guessExtension();
            list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

            //如果error 为空则上传成功
            if($error == null)
            {
                $avatarImage = UserImage::where(['user_id'=>$userId,'type'=>1])->first();
                if($avatarImage==null)
                {
                    $isNew = true;
                    $avatarImage = new UserImage();
                }
                else{
                    //如果是更新的话, 删除之前上传的头像 七牛
                    $isNew = false;
                    $oldAvatarImage = $avatarImage->image_key;
                    $this->deleteImage($oldAvatarImage);
                }
                $avatarImage->user_id = $userId;
                $avatarImage->type = $imageType;
                $avatarImage->is_cover = 0;
                $avatarImage->image_key =  $result['key'];
                $avatarImage->link = Config::where('item','bucket_domain')->select('value')->first()->value. $result['key'];
                $avatarImage->save();

                if ($avatarImage != null || $avatarImage->id > 0) {
                    $jsonResult->statusCode = 1;
                    $jsonResult->statusMsg = '上传成功';
                    $jsonResult->extra = $avatarImage;


                } else {
                    $jsonResult->statusCode = 2;
                    $jsonResult->statusMsg = '插入数据库失败';
                    $jsonResult->extra = $avatarImage;
                }

            }
            else{
                $jsonResult->statusCode  = 3;
                $jsonResult->statusMsg = '上传云端失败';
                $jsonResult->extra = $result;
            }

        }
        return $jsonResult;
//
//        // 当isAdSlide 为1的时后, 1 为产品首页幻灯片
//        $isAdSlide = 0;
//        $associateId = 0;
//        if($request->input('productId') != '')
//        {
//            $type = 1;
//            $associateId = $request->input('productId');
//        }
//        else if($request->input('articleId') != '')
//        {
//            $type = 2;
//            $associateId = $request->input('articleId');
//        }else if ($request->input('UserId') != '') {
//            $type = 3;
//            $associateId = $request->input('UserId');
//        }
//        else if($request->input('slideType') !='')
//        {
//            $type = $request->input('slideType');
//            $isAdSlide = 1;
//        }




    }

    public function deleteHotelImage(Request $request)
    {
        // $imageKey = $request->input('imageKey');
        $jsonResult = new MessageResult();

        $type = $request->input('type'); //1 为删除酒店照片

        $imageKey = $request->input('imageKey');

        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);


            if($err == null)
            {

                //删除酒店 图片
                if($type == 1) {

                    $deleteImg = HotelImage::where('image_key', $imageKey)->first();
                    $deleteRow = $deleteImg->delete();
                    if ($deleteRow) {

                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }


//                    $deleteImg = Image::where('key', $imageKey)->first();
//                    $product = Product::where('thumb', $deleteImg->id)->first();
//                    $deleteRow = $deleteImg->delete();
//
//                    //图片删除后是否影响产品封面
//                    if ($deleteRow) {
//                        $jsonResult->statusCode = 1;
//                        $jsonResult->statusMsg = '删除成功';
//                        if ($product != null) {
//                            //如果删除的图片为产品封面 要重置产品的封面
//                            $product->thumb = '';
//                            $product->save();
//                        }
//
//                    } else {
//                        $jsonResult->statusCode = 2;
//                        $jsonResult->statusMsg = '删除失败';
//                    }
                }

                //删除adslide 表的图像
                else{
//                    $deleteImg = Adslide::where('key', $imageKey)->where('type',$type)->first();
//                    $deleteRow = $deleteImg->delete();
//                    if ($deleteRow) {
//
//                        $jsonResult->statusCode = 1;
//                        $jsonResult->statusMsg = '删除成功';
//
//                    } else {
//                        $jsonResult->statusCode = 2;
//                        $jsonResult->statusMsg = '删除失败';
//                    }
                }

            }
            else{

                $jsonResult->statusCode=3;
                $jsonResult->statusMsg='无法从云端删除';
            }
        }
        else{
            $jsonResult->statusCode=4;
            $jsonResult->statusMsg='图片不存在';
        }
        return $jsonResult;
    }


    public function deleteImage($link)
    {

        $jsonResult = new MessageResult();
        $imageKey = explode('.com/',$link);
        $key =  '';
        if(count($imageKey) > 1)
        {
            $key = $imageKey[1];
        }
        else{
            $key = $imageKey[0];
        }
        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket,$key);
            if($err == null)
            {
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = '删除成功';
            }
            else{
                $jsonResult->statusCode = 2;
                $jsonResult->statusMsg = '删除失败';
            }
        }
        else{
            $jsonResult->statusCode = 3;
            $jsonResult->statusMsg = '删除失败,image key 错误';
        }
        return $jsonResult;
    }


    //更新头像裁剪坐标
    public function cropAvatar(Request $request)
    {
        $avatarImage = UserImage::where('image_key', $request->input('imageKey'))->first();

        if($avatarImage != null)
        {
            $avatarImage->coords = '?imageMogr2/auto-orient/thumbnail/400x/crop/!'.$request->input('width').'x'.$request->input('height').'a'.$request->input('x').'a'.$request->input('y');
            return $avatarImage->save();
        }
        else{
            return 0;
        }

    }
}


?>