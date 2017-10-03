<?php
/**
 * Created by PhpStorm.
 * User: Miao
 * Date: 17/7/24
 * Time: 下午1:34
 */
#自定义函数库文件，系统会自动加载本文件

/**
 * 消息提示 提示消息并跳转页面 高级版
 * @param int $type 1:成功 2:失败
 * @param null $msg
 * @param null $url
 */
function msg($type,$msg=NULL,$url=NULL){
    $toUrl="Location:msg.php?type={$type}";
    $toUrl.=$msg?"&msg=".$msg:'';
    $toUrl.=$url?"&url=".$url:'';
    header($toUrl);
    exit;
}




/**
 * 弹框跳转
 * @param string $msg 弹框提示内容
 * @param string $url 跳转到的URL地址
 */
function alert($msg,$url){
    echo "<script>alert('{$msg}')</script>";
    echo "<script>window.location='{$url}'</script>";
    //$this->redirect('index/index/index');//通过TP5的跳转方法跳转页面
}


if(!session_id()){
    session_start();
}
/**
 * 图形验证码
 * @param int $type 字符类型 1 为纯数字 2 为纯字母  3为字母和数字组合
 * @param int $length 产生的字符串长度
 * @param string $sess_name SESSION中存储验证码的变量名
 * @param int $pixel 噪点的数量
 * @param int $line  干扰线条数量
 */
function verifyImage($type=1,$length=4,$sess_name="verify",$pixel=20,$line=5){
    //通过GD库做验证码
//创建画布
    $width = 100;
    $height = 48;
    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
//用矩形填充画布
    imagefilledrectangle($image, 1, 1, $width - 1, $height - 1,$white);
//    $type = 3;
//    $length = 4;
    $chars = buildRandomString($type, $length);
    for ($i = 0; $i < $length; $i++) {
        $size = mt_rand(18, 22);
        $angle = mt_rand(-15, 15);
        $x = 15 + $i * $size;
        $y = mt_rand(30, 39);
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        $fontfile = __DIR__."/../fonts/msyh.ttc";
        $text = substr($chars, $i, 1);
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
//    $pixel = 0;
    if ($pixel) {
        for ($i = 0; $i < $pixel; $i++) {
            imagesetpixel($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), $black);
        }
    }
//    $line = 5;
    if ($line) {
        for($i=0;$i<=$line;$i++){
            imageline($image, mt_rand(0, $width - 1), mt_rand(0, $height - 1), mt_rand(0, $width - 1), mt_rand(0, $height - 1),$black);
        }

    }
//    $sess_name = "verify";
    $_SESSION["$sess_name"] = $chars;

    header("content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}


/**
 * 没有图片时，显示默认图片
 * @param $str 图片文件的URL地址
 * @param string $noImage 若图片文件为空，则显示当前图片文件
 * @return string
 */
function noImage($str,$noImage='__STATIC__/assets/img/noimage.jpg'){
    if(isset($str)&&!empty($str)&&strlen($str)>3){
        return "__ROOT__/uploads/image/".$str;
    }else{
        return $noImage;
    }
}

/**
 * 产生随机字符串
 * @param int $type 字符类型 1 为纯数字 2 为纯字母  3为字母和数字组合
 * @param int $length  产生的字符串长度
 * @return bool|string
 */
function buildRandomString($type = 1, $length = 4)
{

    if ($type == 1) {
        $chars = "23456789";
    } elseif ($type == 2) {
        $chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ";
    } elseif ($type == 3) {
        $chars = "23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ";
    }
    if ($length > strlen($chars)) {
        exit("字符串长度不够");
    }
//打乱$chars的字符排列顺序
    $chars = str_shuffle($chars);
//截取字符串
    return substr($chars, 0, $length);
}

//列表显示字符串截取，并判定是否显示...
/**
 * 字符串截取
 * @param string $str 要截取的字符串
 * @param int $length 从第一位开始要显示的位数
 * @return string
 */
function substring_list($str,$length){
    $res=mb_substr($str,0,$length,'utf8');
    if(strlen($str)>$length){
        $res.='...';
        return $res;
    }else{
        return $res;
    }
}

//希望实现对上传图片的自动压缩
//http://www.cnblogs.com/huangcong/archive/2012/07/26/2610164.html
function getImageInfo($src)
{
    return getimagesize($src);
}
/**
 * 创建图片，返回资源类型
 * @param string $src 图片路径
 * @return resource $im 返回资源类型
 * **/
function create($src)
{
    $info=getImageInfo($src);
    switch ($info[2])
    {
        case 1:
            $im=imagecreatefromgif($src);
            break;
        case 2:
            $im=imagecreatefromjpeg($src);
            break;
        case 3:
            $im=imagecreatefrompng($src);
            break;
    }
    return $im;
}
/**
 * 缩略图主函数
 * @param string $src 图片路径
 * @param int $w 缩略图宽度
 * @param int $h 缩略图高度
 * @return mixed 返回缩略图路径
 * **/

function resize($src,$w,$h)
{
    $temp=pathinfo($src);
    $name=$temp["basename"];//文件名
    $dir=$temp["dirname"];//文件所在的文件夹
    $extension=$temp["extension"];//文件扩展名
    $savepath="{$dir}/{$name}";//缩略图保存路径,新的文件名为*.thumb.jpg

    //获取图片的基本信息
    $info=getImageInfo($src);
    $width=$info[0];//获取图片宽度
    $height=$info[1];//获取图片高度
    $per1=round($width/$height,2);//计算原图长宽比
    $per2=round($w/$h,2);//计算缩略图长宽比

    //计算缩放比例
    if($per1>$per2||$per1==$per2)
    {
        //原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
        $per=$w/$width;
    }
    if($per1<$per2)
    {
        //原图长宽比小于缩略图长宽比，则按照高度优先
        $per=$h/$height;
    }
    $temp_w=intval($width*$per);//计算原图缩放后的宽度
    $temp_h=intval($height*$per);//计算原图缩放后的高度
    $temp_img=imagecreatetruecolor($temp_w,$temp_h);//创建画布
    $im=create($src);
    imagecopyresampled($temp_img,$im,0,0,0,0,$temp_w,$temp_h,$width,$height);
    if($per1>$per2)
    {
        imagejpeg($temp_img,$savepath, 100);
        imagedestroy($im);
        return addBg($savepath,$w,$h,"w");
        //宽度优先，在缩放之后高度不足的情况下补上背景
    }
    if($per1==$per2)
    {
        imagejpeg($temp_img,$savepath, 100);
        imagedestroy($im);
        return $savepath;
        //等比缩放
    }
    if($per1<$per2)
    {
        imagejpeg($temp_img,$savepath, 100);
        imagedestroy($im);
        return addBg($savepath,$w,$h,"h");
        //高度优先，在缩放之后宽度不足的情况下补上背景
    }
}

/**
 * 图片压缩为缩略图简单版（需根据实际情况改造）
 * @param $srcIm string 需要压缩的图片路径
 * @param float $percent 需要压缩的尺寸比例
 */
function imageThumbnail($srcIm,$percent=0.5){
    //压缩缩略图
//读取原图片
    $srcIm=imagecreatefromjpeg("webroot/123.jpg");
//获得原图片的宽和高
    $srcW=imagesx($srcIm);
    $srcH=imagesy($srcIm);
//设定压缩比例
//    $percent=0.5;
//计算新图片的宽和高
    $destW=$srcW*$percent;
    $destH=$srcH*$percent;
//创建新图片画布
    $destIm=imagecreatetruecolor($destW,$destH);
//进行压缩操作
    imagecopyresampled($destIm,$srcIm,0,0,0,0,$destW,$destH,$srcW,$srcH);
//将新图片保存到文件
    imagejpeg($destIm,'webroot/123new.jpg',100);

}


/**
 * 添加背景
 * @param string $src 图片路径
 * @param int $w 背景图像宽度
 * @param int $h 背景图像高度
 * @param String $first 决定图像最终位置的，w 宽度优先 h 高度优先 wh:等比
 * @return 返回加上背景的图片
 * **/
function addBg($src,$w,$h,$fisrt="w")
{
    $bg=imagecreatetruecolor($w,$h);
    $white = imagecolorallocate($bg,255,255,255);
    imagefill($bg,0,0,$white);//填充背景

    //获取目标图片信息
    $info=getImageInfo($src);
    $width=$info[0];//目标图片宽度
    $height=$info[1];//目标图片高度
    $img=create($src);
    if($fisrt=="wh")
    {
        //等比缩放
        return $src;
    }
    else
    {
        if($fisrt=="w")
        {
            $x=0;
            $y=($h-$height)/2;//垂直居中
        }
        if($fisrt=="h")
        {
            $x=($w-$width)/2;//水平居中
            $y=0;
        }
        imagecopymerge($bg,$img,$x,$y,0,0,$width,$height,100);
        imagejpeg($bg,$src,100);
        imagedestroy($bg);
        imagedestroy($img);
        return $src;
    }

}

/**
 * @param $free integer 需要计算的磁盘字节数
 * @param int $size  换算单位，1000或1024，默认为1000
 * @param int $digit  保留小数位数，默认为2
 * @return string  返回字符串，如100.23KB
 */
function diskSize($free,$size=1000,$digit=2){
    switch ($free){
        case '':
        case $free<$size:
            $freeRes=$free;
            $unit='B';
            break;
        case $free<$size*$size:
            $freeRes=round($free/$size,$digit);
            $unit='KB';
            break;
        case $free<$size*$size*$size:
            $freeRes=round($free/$size/$size,$digit);
            $unit='MB';
            break;
        default:
            $freeRes=round($free/$size/$size/$size,$digit);
            $unit='GB';
            break;
    }
    $res=$freeRes.$unit;
    return $res;
}