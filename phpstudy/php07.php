<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
/**
 * 1.内存分为
 *      (1).初始化静态段
 *         只占一份的static
 *      (2).栈内存
 *         空间小，访问速度快，长度不变的数据类型放在栈内存中
 *      (3).堆内存
 *         空间大，访问速度慢，大的数据类型或者是空间不定长的类型
 *      (4).代码段
 *         语言的结构
 *     php也是自动回收
 *
 * 2.php对象的访问
 *      $对象名称->成员属性：$p->name="sid";
 *      $对象名称->成员方法：$->say();
 *      $this->name;
 *
 * 3.以__开头的方法为php内部定义的方法
 *      php也有构造方法
 *      只允许有一个__construct
 *      析构函数：消失前自动调用__destruct(栈内存，后进先出)
 *      java没有析构函数；析构函数是用来释放对象的引用的
 *
 * 4.封装性（魔术方法）
 *      private$name;
 *      privatefunction fun(){}
 *      相对于读取和赋值频繁可使用set和get
 *      __set()__get($proName)
 *      判断属性是否存在默认的无法判断私有的属性；所以需要定义__isset
 *     __isset()
 *      清除成员属性或者变量
 *     __unset()
 *
 * 5.继承(单继承)
 *      extends
 *      私有的方法无法继承
 *      私有的属性一样不可以继承；
 *      但是如果方法或者构造函数中有属性的声明
 *         相当于在构造方法中新声明了属性；主要原因是php是弱类型语言
 *
 * 6.php不可以进行函数重载
 *      但是可以覆盖父类的方法；只有跟父类方法一样名字即可
 *      parent::say();相当于java的super关键字(也可以应用在构造方法当中)
 *
 * 7.访问类型(子类的方法类型不能低于父类的权限)
 *      (1).private
 *      (2).protected受保护的成员，子类可以使用
 *      (3).public
 *
 * 8.常用关键字
 *      (1).final：
 *         只能用来定义类和方法
 *         使用final定义的类不能被继承
 *         使用final定义的方法不能被覆盖
 *         (php常量是用define)
 *      (2).static：第一次使用创建
 *         静态的属性和方法定义；共享；
 *         访问方法：Person::$country（方法和属性也可以用对象来访问）
 *         赋值方式：Person::$country="USA";
 *        this代表本对象；self代表本类
 *         self::$country
 *         static声明的方法里面不能使用非静态的成员。比如$this不能用
 *      (3).const:常量无法赋值
 *         define声明常量，但是不能声明成员属性
 *         const是一个在类里面定义成员属性为常量的关键字。（#define是c语言的）
 *         访问方式：Person::COUNTRY；（不加$符号）
 *         可以使用self进行访问
 *
 * 9.四个魔术方法
 *      (1)__toString
 *         将对象进行默认的字符串输出
 *      (2)__clone
 *         复制对象，让内存中存在两份地址(克隆时调用的方法)
 *         p3=clone$p1;
 *         __clone(){$this->name="副本"}
 *         这里的this表示的是副本的对象引用
 *         二$that表示原来的副本
 *      (3)__call
 *         调用不存在的方法时提示的消息；使程序不崩溃
 *         __call($funName,$argus){"调用的".$funName."不存在,参数￥argus"}
 *      (4)__autoload
 *         不是写在对象内部的，而是在对象外部使用的方法
 *         1.指定加载类
 *             include"Person_class.php";
 *             $p1= new Person();
 *         2.页面自动加载
 *             function__autoload($className){
 *                include$className."_class.php";
 *             }
 *
 * 10.对象的串行化
 *      全部序列化
 *         两个过程：1.串行化（对象转成二进制字符串）和2.反串行化
 *         1.serialize
 *             (1).对象在网络中传输的时候
 *             (2).将对象写入文件或者写入数据库时
 *                $str= serialize($p1);
 *                $file= fopen("tmp.txt","w");
 *                fwrite($file,$str);
 *                fclose($file);
 *         2.unserialize
 *                include"person.php";
 *                $file= fopen("tmp.txt","r");
 *                $str= fwrite($file,filesize("tmp.txt"));
 *                fclose($file);
 *                $p= unserialize($str);
 *                $p->say();
 *      部分序列化
 *         1.__sleep()：
 *             在对象序列化之前自动调用。
 *             $arr= array("name","sex");
 *             return$arr;
 *             这样只序列化，数组中的对象属性
 *         2.__wakeup():
 *             在对象反序列化的时候自动调用。
 *             类似clone的副本操作
 *             可以对属性进行初始化；比如年龄在过几年之后反序列化之后需要加上几年。
 *             $this->age=45+3;
 * 
 * 11.抽象类与接口（抽象类不能实例化对象；子类可以）
 *  抽象方法：abstract修饰的没有方法体的方法；直接在方法名后面加上;
 *  抽象类：至少有一个方法是抽象的；并且类必须使用abstract修饰
 *  接口：所有方法都是抽象的；并且只允许有常量const
 *        
 * 12.多态（php本身就是弱类型，所以在调用时只是一个引用，所以多态并不明显）
 *      引用父类的方法，执行子类的实现方法。
 *     
 */

    /**
     * 类的定义
     * Enter description here...
     * @author admin
     */
    class Phone{
       var$manufacruers;
       var$color;
       function sendMessage($person,$message){
           $person->phone->reviceMessage($message);
       }
       function reviceMessage($message){
           echo"接收的信息$message <br>";
       }
       function call(){
           echo"call sb <br>";
       }
       function answerCall(){
           echo"answer <br>";
       }
    }
    class Person{
       var $name;
       var $phone;
       private $age = 12;
//     private Phone $phone;
       /**
        * 构造方法php5
        * 设置默认初始值为空
        * 这样就可以屏蔽掉因为构造函数无参数时候的警告信息了
        * @param $name
        * @param $phone
        */
       function __construct($name="",$phone=""){
           $this->name=$name;
           $this->phone=$phone;
           echo"php5<br>";
       }
       function __destruct(){
           echo$this->name."php5end<br>";
       }
       //构造方法php4
       function Person($name,$phone){
           $this->name=$name;
           $this->phone=$phone;
           echo"php4<br>";
       }
       function say(){
           echo"say sth! <br>";
       }
       function run(){
           echo"running! <br>";
       }
       function work(){
           echo"work <br>";
       }
       function toString(){
           return$this->name ."<br>";
       }

       /**
        * 获取私有对象
        * Enter descriptionhere ...
        * @param unknown_type$proName
        */
       function __get($proName){
           if($proName=="age"){
              return$this->$proName-10;
           }else{
              echo $proName;
              return $this->$proName;
           }
       }
       /**
        * 设置私有对象
        * Enter descriptionhere ...
        * @param unknown_type$proName
        * @param unknown_type$value
        */
       function __set($proName,$value){
           if($proName=="age"){
              if($value>0&&$value<150) {
                  $this->$proName-10;
                  return;
              }
           }
           $this->$proName=$value;
       }
       /**
         * 判断私有属性是否存在
        * Enter descriptionhere ...
        * @param unknown_type$proName
        */
       function __isset($proName){
           echo"__isset<br>";
           return isset($this->age);
       }
       /**
        * 删除私有属性
        * Enter descriptionhere ...
        * @param unknown_type$proName
        */
       function __unset($proName){
           unset($this->$proName);
       }
    }

    class Student extends Person{
       private $num;
       function work(){
           parent::work();
           echo"this is student work";
       }
    }

    /**
     * 抽象类的存在和实现
     * @author admin
     *
     */
    abstract class Demo{
       function test(){
           echo"this is a abstract demo test<br>";
       }
       abstract function demofun();
    }

    /**
     * 接口中只有抽象方法和常量
     * @author admin
     *
     */
    interface One{
       const ONE="ONE! my boy<br>";
       function oneFun();
    }

    interface Two extends One{
       const TWO="TWO! my boy<br>";
    }

    interface Three{
       const THREE="TWO! my boy<br>";
       function threeFun();
    }

    class DemoTest extends Demo implements One,Two{
       function __construct(){}
       function demofun(){
           parent::test();
       }

       function oneFun(){
           echo"DemoTest impl oneFun<br>";
       }

       function useThree($thr){
           $thr->threeFun();
       }
    }

    class DemoImplF implements Three{
       function threeFun(){
           echo"DemoImplF impl threeFun<br>";
       }
    }

    class DemoImplS implements Three{
       function threeFun(){
           echo"DemoImplS impl threeFun<br>";
       }
    }

    /**
     * 生成对象
     * 并访问对象的属性和方法
     * @var unknown_type
     */
    $p1 = new Person();
    $p2 = new Person();
    $phone1 = new Phone();
    $phone2 = new Phone();
    //属性设置值
    $p1->name="sid1";
    $p2->name="sid2";
    $phone1->color="red";
    $phone2->color="blue";
    $phone1->manufacruers="诺基亚";
    $phone2->manufacruers="iphone";
    $p1->phone=$phone1;
    $p2->phone=$phone2;
    //调用方法
    $p1->phone->sendMessage($p2,"这是我的测试哦");
    $str = $p1->toString();
    echo$str;
    $p1->age=15;
    echo$p1->age."<br>";
    //判断属性默认的无法判断私有的属性
    if(isset($p1->age)){
       echo"属性存在<br>";
    }else{
       echo"属性不存在<br>";
    }
    //删除对象的属性
    //删除后调用便找不到属性值
    unset($p1->name);
    unset($p1->age);
    //学生的操作
    $s1 = new Student("Java",new Phone());
    $s1->num=12;
    echo"学生类：".$s1->toString();
    echo"学生类只有name：".$s1->name."<br>";
    //抽象类和接口
    $d = new DemoTest();
    $d->demofun();
    echo DemoTest::ONE;

    //多态
    $d = new DemoTest();
    $df = new DemoImplF();
    $ds = new DemoImplS();
    $d->useThree($df);
    $d->useThree($ds);
?>