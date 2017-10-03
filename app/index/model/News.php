<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 17/7/22
 * Time: 下午2:37
 */
namespace app\index\model;
use think\Model;
class News extends Model{
    #自动完成
//    protected $auto = ['create_time'];//在进行数据库新增和修改时，自动将当前时间戳存入time字段

#开启自动更新时间戳功能，只对当前模型有效，数据库默认字段名为 create_time 和 update_time 字段
#开启后，所有的数据库插入和更新操作均会根据操作类型来更新create_time 和 update_time 字段
//protected $autoWriteTimestamp = true;
//protected $createTime='字段名';//自定义创建时间的字段名，若赋值为false，则关闭该字段的自动赋值操作
//protected $updateTime='字段名';//自定义更新时间的字段名，若赋值为false，则关闭该字段的自动赋值操作

#在进行insert插入数据库操作时，自动将当前时间戳存入insert_time字段
//    protected $insert = ['insert_time'];
//      public function setTimeInsertAttr(){
//          return time();
//      }

#在进行update插入数据库操作时，自动将当前时间戳存入update_time字段
//    protected $update = ['update_time'];
//      public function setTimeUpdateAttr(){
//          return time();
//      }
#模型获取器  getSexAttr 为 get字段名Attr(),将从数据库获取到的字段值进行逻辑处理后再返回给控制器
//    public function getSexAttr($val){
//        switch ($val){
//            case '1':
//                return '男';
//                break;
//            case '2':
//                return '女';
//                break;
//            default:
//                return "未知";
//                break;
//        }
//    }
#模型修改器 setPasswordAttr 为 set字段名Attr(),将写入数据库的字段值进行逻辑处理后再返回并存入数据库
//        public function setPasswordAttr($val){
//            return md5($val);
//        }

}