<?php
namespace app\admin\controller;
use app\common\controller\Common;
use think\Db;

class News extends Common
{


//    public function _construct()
//    {
//        //目前初始化方法支持return，所以暂时无法通过本方法来判断登录和跳转
////       if($this->noLogin()){
////           return $this->fetch("index/login");
////       };
//    }

    /*新闻列表页*/
    public function newsList()
    {
//        spl_autoload_register(function($className){
//           require_once str_replace('\\','/',$className.'.php');//将路径中的反斜杠替换为命名空间中的斜杠
//        });//自动加载函数
        //通过表单选择框GET过来的分类值，来决定从数据库取哪些分类新闻
        $cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
        if ($cid > 0) {
            $res = Db::table('news')
                ->alias('a')
                ->join('newscate b', 'a.cid = b.id')
                ->where(['cid' => $cid])
                ->field('a.*,b.catename')
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(10);
        } else {
            $res = Db::table('news')
                ->alias('a')
                ->join('newscate b', 'a.cid = b.id')
                ->field('a.*,b.catename')
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(10);
        }
        //处理用户通过搜索框搜索，获取关键词并检索新闻标题
        if (isset($_GET['keywords']) || !empty($_GET['keywords'])) {
            $keywords =input('get.keywords');
            $res = Db::table('news')
                ->alias('a')
                ->join('newscate b', 'a.cid = b.id')
                ->field('a.*,b.catename')
                ->where('title', 'like', "%$keywords%")
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(10);
        }
        //取出新闻列表数据和新闻分类数据，并且传入模板文件
        $cate = Db::table('newscate')->field(['id', 'catename'])->select();
        $this->assign('data', $res);
        $this->assign('cate', $cate);
        return $this->checkLogin('newsList');
//        return $this->fetch("newsList");
    }

    /*新闻编辑页*/
    public function newsEdit()
    {
        $cate = Db::table('newscate')->field(['id', 'catename'])->select();
        $this->assign('cate', $cate);
        #初始化变量的值
        $data = array('id' => 0, 'title' => '','author'=>'', 'pic' => '', 'desc' => '', 'content' => '', 'cid' => 1, 'order' => 0);
        //判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
        if (isset($_GET['id']) && $_GET['id'] > 0) {
//            $id=input('get.id',1,'intval');//input助手函数，参数2为默认值，参数3为对值所为使用的函数
            $id = intval($_GET['id']);
            $res = Db::table('news')->find($id);
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        }
        $data['pic'] = noImage($data['pic']);
        $this->assign('data', $data);
        return $this->checkLogin('newsEdit');
    }

    /*新闻分类列表页*/
    public function newsCate()
    {
        if(isset($_GET['pid']) && $_GET['pid'] > 0){
            $pid=input('get.pid/d');
            $cate = Db::table('newscate')
                ->field(['id','pid', 'catename'])
                ->where(['pid'=>$pid])
                ->paginate(10);
            //取出父类名称
            $pidRes=model("Newscate")->field(['catename','pid'])->find($pid);
            $parentName=$pidRes['catename'];//取出的是对象，取出Pid对应的分类名称
            $parentPid=$pidRes['pid'];
        }else{
            $cate = Db::table('newscate')
                ->field(['id','pid', 'catename'])
                ->where(['pid'=>0])
                ->paginate(10);
            $parentName="无";
            $parentPid=0;
        }
        //取出新闻列表数据和新闻分类数据，并且传入模板文件
        $this->assign([
            'parentName'=>$parentName,
            'parentPid'=>$parentPid,
            'cate'=>$cate
            ]);
        return $this->checkLogin('newsCate');
    }

    /*新闻分类编辑页*/
    public function newsCateEdit()
    {
//判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $res = Db::table('newscate')->where(['id' => $id])->find();
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        } else {
            $data = array('id' => 0, 'catename' => '');
        }
        //取其上级分类信息，如果有，则给父分类取相应名称，若没有，则给默认值"无"
        if(isset($_GET['pid']) && $_GET['pid'] > 0){
            $pid=$_GET['pid'];
            $res = Db::table('newscate')
                ->where(['id' => $pid])
                ->field('catename')
                ->find();
            $data['parent']=$res['catename'];
        }
        else{
            $data['parent']="无";
        }
        $this->assign('data', $data);
        return $this->checkLogin('newsCateEdit');
    }

//    /*新闻分类编辑页备份*/
//    public function newsCateEdit()
//    {
////判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
//        if (isset($_GET['id']) && $_GET['id'] > 0) {
//            $id = intval($_GET['id']);
//            $res = Db::table('newscate')->where(['id' => $id])->find();
//            if ($res && !empty($res)) {
//                foreach ($res as $key => $val) {
//                    $data["$key"] = $val;
//                }
//            }
//        } else {
//            $data = array('id' => 0, 'catename' => '');
//        }
//        $this->assign('data', $data);
//        return $this->checkLogin('newsCateEdit');
//    }


    /*新闻分类 数据存储*/
    public function doNewsCateAdd()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            if (!isset($_POST['catename']) || empty($_POST['catename'])) {
                alert('分类名称不允许为空', 'newsCateEdit');
            } else {
                $catename =input('post.catename');
                $pid=input('post.pid');
                $data = array('catename' => $catename,'pid'=>$pid);
                //id 不存在 或者id等于零 则进行新增分类
                if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                    $res = model("Newscate")->create($data);
                    if ($res) {
                        alert('发布成功', "newsCate?pid=$pid");
                    } else {
                        alert('发布失败', 'newsCateEdit');
                    }
                }//编辑分类
                elseif (isset($_GET['id']) && intval($_GET['id']) > 0) {
                    $id = intval($_GET['id']);

                    $res = model("Newscate")->where(['id' => $id])->update($data);
                    if ($res) {
                        alert('更新成功', "newsCate?pid=$pid");
                    } else {
                        alert('更新失败', 'newsCateEdit');
                    }
                }
            }
        }
    }

    /*新闻详情数据存储*/
    public function doNewsAdd()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            if (!isset($_POST['title']) || empty($_POST['title'])) {
                alert('标题不允许为空', 'newsEdit');
            } else {
                $data['title'] = input('post.title');
                $data['desc'] = input('post.desc');
                $data['cid'] = input('post.cateId');
                $data['author'] = input('post.author');
                $data['update_time'] = time();
                $data['order']=input('post.order/d');
                if(!isset($_POST['content'])){
                    $content='';
                }else{
                    $content=input('post.content');
                }
                $data['content'] = $content;
                //id 不存在 或者id等于零 则进行新增文章
                if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                    $data['create_time'] = time();//取得新增创建时间
                    //判断用户是否上传了图片文件
                    switch ($_FILES['image']['error']){
                        case 0:
                            $data['pic'] = $this->upload('image');
                            break;
                        case 1:
                        case 2:
                            alert('图片大小超出服务器限制','newsEdit');
                            break;
                        case 3:
                            alert('图片文件仅有部分被上传','newsEdit');
                            break;
//                        case 4:
                            //用户没有选择上传图片，则错误号为4
//                            alert('没有找到要上传的图片文件','newsEdit');
//                            break;
                        case 5:
                            alert('服务器临时文件夹丢失','newsEdit');
                            break;
                        case 6:
                            alert('图片文件写入临时文件夹出错','newsEdit');
                            break;
                    }
                    $res = model("News")->create($data);
                    if ($res) {
                        alert('发布成功', 'NewsList');
                    } else {
                        alert('发布失败', 'newsEdit');
                    }
                }//编辑新闻
                else {
                    $data['id']=input('get.id/d');
                    switch ($_FILES['image']['error']){
                        case 0:
                            $data['pic'] = $this->upload('image');
                            break;
                        case 1:
                        case 2:
                            alert('图片大小超出服务器限制','newsEdit');
                            break;
                        case 3:
                            alert('图片文件仅有部分被上传','newsEdit');
                            break;
//                        case 4:
//                            alert('没有找到要上传的图片文件','newsEdit');
//                            break;
                        case 5:
                            alert('服务器临时文件夹丢失','newsEdit');
                            break;
                        case 6:
                            alert('图片文件写入临时文件夹出错','newsEdit');
                            break;
                    }
                    $res = model("News")->update($data);
                    if ($res) {
                        alert('更新成功', 'newsList');
                    } else {
                        alert('更新失败', 'newsEdit');
                    }
                }
            }
        }
    }

    /*新闻分类删除*/
    public
    function newsCateDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = input('get.id/d');
                //通过获取到的ID 来判断 当前ID下 是否还存在子分类
                $pidRes=model('newscate')->where(['pid'=>$id])->find();
                //获取来源页的PID 用户删除后的返回
                $pid=input('get.pid/d');
                if($pidRes){
                    alert('当前分类下存在子分类，请删除后再试', "newsCate?pid={$pid}");
                }else{
                    $res = model('Newscate')->destroy($id);
                    if ($res) {
                        alert('删除成功', "newsCate?pid={$pid}");
                    } else {
                        alert('删除失败', "newsCate?pid={$pid}");
                    }
                }
            } else {
                alert('ID错误', 'newsCate');
            }
        }
    }

    /*新闻删除*/
    public
    function newsDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = input('get.id/d');
                  $res=model("News")->destroy($id);

                if ($res) {
                    alert('删除成功', 'newsList');
                } else {
                    alert('删除失败', 'newsList');
                }
            } else {
                alert('ID错误', 'newsList');
            }
        }
    }

}