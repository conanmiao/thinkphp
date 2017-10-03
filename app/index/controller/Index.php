<?php

namespace app\index\controller;

use app\common\controller\Common;
use app\admin\model\News;
use think\Db;
class Index extends Common
{
    public function index()
    {
//        $res=model("News")->select();
//        $res=News::get();
//        $res=$res->toArray();
//        dump($res);
//        exit;
        $res=Db::table('news')->order(['create_time'=>'desc'])->paginate(10);

        $this->assign('news',$res);
        return $this->fetch();
        //echo "hello word!";
        //return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    public function detail(){
        return $this->fetch('new');
    }

#调用模板文件的方法 view()默认参数为view/index(类名文件夹)/test.html(方法名.html)
#view('其他html文件名'，['变量名'=>'变量值']) 第一个参数为指定模板文件，第二个参数为变量赋值
    public function test()
    {$this->assign('title','主页');//为变量赋值，并传递给模板文件
//        return view('index');
        #使用think\Controller父类中的 $this->>fetch()方法，功能等同于view()，只是多了第三个参数，字符串替换。
        # 视图输出字符串内容替换的配置是后面这个，可在应用配置中加入这个并自定义替换字符   'view_replace_str'   => [],
        return $this->fetch('index',['title'=>'主页'],['__css__'=>'/publuc/static/css']);

        //内置的模板替换字符，对应的是static文件夹目录
        //__STATIC__   //thinkphp/public/static/
        //__CSS__     //thinkphp/public/static/css
        //__JS__     //thinkphp/public/static/js
        //__URL__  //当前文件的相对URL路径/thinkphp/public/index.php/index/index
        //__ROOT__  对应当入口文件所在目录  /thinkphp/public
        #模板系统内置变量用法
        //{$Think.server.HTTP_HOST}// 获取环境变量，HTTP_HOST为系统环境变量值
        //{$Think.session.email}// 获取session值
        //{$Think.cookie.name}
        //{$Think.get.id}   获取get变量
        //{$Think.post.username}   获取post变量
        //{$Think.request.username}   获取request变量
        //{$Think.const.APP_PATH} 获取系统常量中的APP目录
        //{$Think.APP_PATH} 获取系统常量中的APP目录

        #模板注释方法
        //   {/* 这里是view注释内容，这种注释不会显示在前端源代码中 */}

        #模板中的判断语句 等同于if，name值为变量名，value值为比较数据
        //{eq name="a" value="$b"}
        //  <p>相等</p>
        //{else/}
        //  <p>不相等</p>
        //{/eq}

        //eq比较相等
        //neq不相等
        //lt 小于
        //elt 小于等于
        //gt 大于
        //egt 大于等于
        //in 包含value中
        //notin 不包含在vale中
        //between 判断是否包含在value中的两个值之间，如value="1，20"，注意使用between，value只支持两个值
        //notbetween 不包含在两个值之间，判断范围中不包含value中的两个数字

        #条件分支语句
//        {switch name="Think.get.id"} //Think.get.id为系统常量，作用是获取当前页面的get过来的id值
//        {case value="1"}<p>为1的情况</p>{/case}
//        {case value="2"}<p>为2的情况</p>{/case}
//        {case value="3"}<p>为3的情况</p>{/case}
//        {default/}<p>其他情况</p>
//        {/switch}

        #range判断是否在包含范围内，type为类型，in为包含在value中，同时支持notin between notbetween
//        {range name="Think.get.id" value="1,2,3" type="in"}
//            <p>当前ID是1，2，3中的一个</p>
//        {else/}
//            <p>当前ID不是1，2，3中的一个</p>
//        {/range}

        #判断系统常量是否被定义
//        {defined name="APP_PATH"}
//            <p>常量APP_PATH已经被定义</p>
//        {else/}
//            <p>APP_PATH未被定义</p>
//        {/defined}

        #if判断 建议模板中尽量避免使用if判断，把逻辑应该放在控制层
//        {if condition="(1==1)AND(2==2)"}
//        <P>条件成立</P>
//        {else/}
//        <p>条件不成立</p>
//        {/if}

        #模板包含
//        {include name="common/header"/} //file为包含文件路径，不带扩展名
        #模板继承
//        {extend name="common/base"/} //file为继承的父文件文件路径，不带扩展名
        //正文部分
//        {block name="title"}
//        <p>这里是可以被子文件中替换的部分</p>
//        {/block}
    }



#数据模型的操作方法
    public function modelTest()
    {
        //测试model方法中的调取数据 获取一条记录
//        $res=News::get(2);
//        $res=$res->toArray();
//        dump($res);

        #get和where条件获取数据 获取一条记录
//        $res=News::get(function($query){
//            $query->where('id',1);
//        });
//        $res=$res->toArray();
//        dump($res);

        #使用WHERE方法和链式操作 链式操作同Db 方法 获取一条记录
//        $res=News::where('id',2)->find();
//        $res=$res->toArray();
//        dump($res);

//        #使用all 方法 获取多条记录
//        $res=News::all([1,2,3]);
//        foreach($res as $val){
//            dump($val->toArray());
//        }

//        #使用all 方法 获取多条记录
//        $res=News::where('id','>',3)->select();
//        foreach($res as $val){
//            dump($val->toArray());
//        }

//        #使用where方法 获取指定字段的值
//        $res= News::where('id',4)->value('title');
//        dump($res);

        #create插入字段
//        $res=News::create([
//           'title'  =>'测试title的值是啥',
//            'content'   =>"这里是内容区域"
//        ]);
//        dump($res);

//        #使用save方法插入数据...
//        $newsModel=new News;
//        $newsModel->title='这样也行？';
//        $newsModel->content='内容部分这样也行？';
//        $newsModel->save();
//        dump($newsModel->id);

//        #使用save方法插入 返回影响行数，save的第二个参数为判定条件
//        $newsModel=new News;
//        $res= $newsModel->save([
//            'title'=>'标题save方法',
//            'content' => '内容save方法'
//        ],['id'=>5]);
//        dump($res);

        #使用saveAll方法插入多条数据 返回model对象，参数可以是二维数组
//        $newsModel=new News;
//        $res= $newsModel->saveAll([
//            'title'=>'标题save方法',
//            'content' => '内容save方法'
//        ],[
//            'title'=>'标题save方法',
//            'content' => '内容save方法'
//          ]);
//        dump($res);

        #链式操作中的allowField()方法；
        //->allowField(true);//将插入操作中，数据库中不存在的字段过滤掉，并成功插入。
        //->allowField(['title','id']);//将插入操作中，允许插入的字段进行规定，以外的字段将过滤掉

        #update数据更新操作
//        $res=News::update([
//            'id'=>2,
//            'title'=>'修改后的title'
//        ]);
//        dump($res);

        #以save方法来更新数据
//        $newsModel=News::get(2);//将获取到的记录后的model对象实例化
//        $newsModel->title='新标题';
//        $res=$newsModel->save();
//        dump($res);
        #destroy数据删除操作 返回影响行数
//        $res = News::destroy(57);//直接写的参数为主键判定条件
//        dump($res);
        #destroy数据删除操作 并添加判断条件 返回影响函数
//        $res = News::destroy(['id'=>56]);//直接写的参数为主键判定条件
//        dump($res);

        #模型delete方法进行数据删除操作 返回影响函数
//        $newsModel = News::get(55);//直接写的参数为主键判定条件
//        $res=$newsModel->delete();
//        dump($res);

        #使用链式操作的delete方法
//        $res=News::Where('id','>=',54)->delete();
//        dump($res);

    }

#数据库DB类的操作方法
    public function dbTest()
    {
//        dump('123');
//        dump(config('database'));
        #数据库连接
        Db::connect();
        #源生SQL查询方法
//        $res=Db::query("select * FROM `news` where id=?",[2]);
//        dump($res);
        //select（）
//        $res=Db::table('news')->select();
//        dump($res);
        # select  包含where条件的方法
//        $res=Db::table('news')->where(['id'=>2])->select();
//
//        dump($res);
        # find 返回一条记录，返回结果是一个一维数组，默认返回ID最小值
//        $res=Db::table('news')->find();
//        dump($res);
        #value 返回一条记录，并且是某个字段的值
//        $res=Db::table('news')->value('title');
//        dump($res);
        #column 返回一个一维数组，数组中的值为整个字段的内容
//        $res=Db::table('news')->column('title');
//        dump($res);

        #db的insert方法 返回插入数据后影响的行数
//        $db=Db::table('info');
//        $res=$db->insert([
//            'title'=>'testtitle',
//            'content'=>'this is test content'
//        ]);
//        dump($res);

        #db的insertGetId方法 返回插入数据后的自增ID号
//        $db = Db::table('info');
//        $res = $db->insertGetId([
//            'title' => 'testtitle1',
//            'content' => 'this is test content1'
//        ]);
//        dump($res);

        #db的insertAll方法 插入一个二维数组，每个一维数组都是一条记录。键名对应字段名，键值对应记录值。
//        $data[]=array();
//        $res=Db::table('info')->insertAll($data);
//        dump($res);

//        #update数据库更新操作 返回影响行数 必须带where条件
//        $res=Db::table('info')->where(['id'=>2])->update(['title'=>'荣誉资质']);
//        dump($res);

//        #setField数据库更新操作 更新指定字段内容 返回影响的行数 必须带where条件
//        $res=Db::table('info')->where(['id'=>2])->setField('title','荣誉资质');
//        dump($res);

        #setInc数据库更新操作 更新指定数字型字段内容 使其自动增长,第二个参数为增长步长 返回影响的行数 必须带where条件
//        $res=Db::table('info')->where(['id'=>2])->setInc('num',1);
//        dump($res);

        #setDec数据库更新操作 更新指定数字型字段内容 使其自动减少,第二个参数为增长步长 返回影响的行数 必须带where条件
//        $res=Db::table('info')->where(['id'=>2])->setDec('num',1);
//        dump($res);

        #delete 删除数据操作
//        $res=Db::table('info')->where(['id'=>2])->delete();
//        dump($res);

        #delete 删除数据操作 省略where条件，函数中的参数为主键键值，作为判定条件
//        $res=Db::table('info')->delete(1);
//        dump($res);

        #where 条件表达式
        //where(['id'=>'2']); 数组形式
        //where(['id'=>'2'],['order'=>4]); 数组形式 and 条件
        //where(['id'=>'2'])->where(['order'=>2]); 数组形式 and 条件
        //where(['id'=>'2'])->whereOr(['order'=>2]); 数组形式 or 条件
        //where('id',2);  2参数形式
        //where('id',">=",2);  3参数形式
        //where('id','in','2,3,4');  参数形式

        #链式操作
//        $res = Db::table('info')
//            ->where('id', '>', 2)//where条件
//            ->field('title', 'id')// 查询的字段名
//            ->order('id DESC')//排序方法
//            ->limit(3, 5)//取出条数
//            ->page(3, 5)//分页方法取出条数，其相当于limit((3-1)*5,5)，第一个参数为页数
//            ->group('字段名')//对指定字段名进行分组，不同的值分组显示，相同的值值保留一条数据，同时order会失效
//            ->select(); //方法名
//        dump($res);
    }

    #聚合数据模型方法
    public function juheDb()
    {
        #获取数据条数 count()
//        $res=News::count();
//        dump($res);

        #通过条件获取条数
//        $res= News::where('id','>',2)->count();
//        dump($res);

        #获取最大值
//        $res = News::max('create_time');
//        dump($res);

        #获取最小值
//        $res = News::min('create_time');
//        dump($res);

        #求和
//        $res = News::sum('id');
//        dump($res);

        #平均值
//        $res = News::avg('id');
//        dump($res);


    }
    public function viewTest(){
        view('index.html');
    }

}
