<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
/**
 * 数组
 * 1.数组中可以存放不同类型的数据
 * 2.数组可以进行扩充
 *
 * 数组的分类
 * 1.索引数组：数组的索引值是整数，0开始
 * 2.关联数组：数组以字符串作为索引值，相当于别名
 *
 */
    $arr[0]=133;
    $arr[]=233;
    $arr[]=333;
    $arr[2]=433;
    $arr[1]=533;
    $arr[]=633;
    $arr[]=733;
    $arr[9]=733;
    
    
    $arrb[0]=133;
    $arrb[]=233;
    $arrb[]=333;
    $arrb[2]=433;
    $arrb[1]=533;
    $arrb[]=633;
    $arrb[]=733;
    $arrb[9]=733;
    print_r($arr);

    echo"<br>";
    $person["name"]="sid";
    $person["age"]="23";
    $person["sex"]="man";
    print_r($person);
    echo"<br>";

    $arr = array("age"=>1,2,"name"=>"one",3.333);
    print_r($arr);
    echo"<br>";
    $arr["name"]="sid";
    print_r($arr);
    echo"<br>";

    /**
     * 数组的遍历
     * 1.for只适合索引数组（弱类型，如果中间是空的也无法遍历）
     * 2.foreach
     * 3.while()的list和each方法
     *      each方法只能取一次；循环第二时，已经取到最后了
     *      list方法将数组复制给list方法中的参数（适合索引数组）
     */
    for($i=0;$i<count($arr);$i++){}
    foreach($arr as $value){
       echo$value."<br>";
    }
    foreach($arr as $key=>$value){
       echo$value."下标为key<br>";
    }

    $arr = array(array(1,2,3,4,5,55),array("one","two"),array("a",1,"b",2));
    foreach($arr as $key=>$value){
       foreach($value as $key=>$value){
           echo$value."下标为key<br>";
       }
    }

    $arr = array("age"=>1,2,2.2,3.333);
    //传入数组，返回新数组;1和value对应值；0和key对应下标
    while($a=each($arr)){
       echo"下标:".$a[0]."---".$a["key"]."<br>";
       echo"值:".$a[1]."---".$a["value"]."<br>";
    }
    echo "list:";
    list($ae,$be,$ce)=$arr;
    echo$ae."<br>";
    echo$be."<br>";
    echo$ce."<br>";
    $str = "uselib_one";
    list($aa,$one) = explode("_", $str);
    echo$one."<br>";
    list($key,$value) = each($arr);
    echo$key."<br>";
    echo$value."<br>";

    /**
     * 数组的处理函数
     * 1、current($arr)得到目前指针位置的内容
     * 2、key($arr)得到当前位置的下标值
     * 3、next($arr)下移动一位
     * 4、prev($arr)前一个
     * 5、end($arr)结尾
     * 6、reset($arr)重新回到初始位置
     * 7、count($arr)获取数组元素个数
     * 8、sizeof($arr)获取数组长度
     * 9、array_change_key_case($arr,CASE_UPPER/CASE_LOWER)将下标的英文字母传唤成大小写
     * 10、array_chunk($arr,int size,boolean)分解数组每个小数组为size大小；true表示保留原有下标
     * 11、array_count_values($arr)用来计算目标数组中各值出现的次数
     * 12、array_fill(star,size,resourse);填满索引中指定位置的段内容
     * 13、array_filter($arr,function)过滤目标数组中的内容,只返回返回true的数据
     *      array_map(function,$arr)用来处理数组
     *      array_walk(function,$arr)用来处理数组
     * 14、array_flip($arr)将目标数组中的键与值反向；后转换的键会将前面相同的键覆盖掉
     * 15、arra_sum计算目标数组中所以元素的总和
     * 16、array_unique($arr)去除重复值
     */
    $a=current($arr);
    var_dump($a);
    echo"<br>";
    $a=key($arrb);
    var_dump($a);
    echo"<br>";
    $uparr = array_change_key_case($arr,CASE_UPPER);
    var_dump($uparr);

    echo"<br>";
    $uparr = array_chunk($arr, 1,TRUE);
    var_dump($uparr);
    echo"<br>";
    $uparr = array_count_values($arrb);
    var_dump($uparr);
    echo"<br>";
    array_fill(2,12,"asdfa");
    var_dump($uparr);
    echo"<br>";

    $arr = array("age"=>1,-2,"name"=>"one",3.333);
    //字符串默认当成0
    function funcc($value){
       if($value>0)
           return true;
       else
           return false;
    }
    @$cc = funcc;
    $new = array_filter($arr,$cc);
    var_dump($new);
    echo"<br>";

    $arr = array("age"=>1,-2,"name"=>8,3.333,2,2,3.333);
    //字符串默认当成0
    function fun2($value){
       return$value*$value;
    }
    @$cc = fun2;
    $new = array_map($cc,$arr);
    var_dump($new);
    echo"<br>";
    var_dump(array_flip($arrb));
    echo"<br>";
    var_dump(array_unique($arr));
    echo"<br>";

    /**
     * 数组的高级函数
     * 1、array_values()获取数值，并将key重新数字顺序
     * 2、array_keys()返回数组的所有下标
     * 3、in_array()查找某值是否在数组里面，返回boolean
     *      第一个是元素，
     *      第二个是数组，
     *      第三个是是否按数据类型进行检索
     * 4、array_search()查找某值是否在数组里面，返回对应的键名；不存在返回false
     * 5、array_key_exists()判断下标是否存在数组中，返回boolean
     * 6、extract()数组变量的转换(关联数组)
     * 7、compact()变量转换成数组（变量必须事先存在）
     * 8、数组与栈（后进先出）
     *      array_push()压入数组末尾；返回数组的长度
     *      array_pop()弹出数组最后一个元素
     * 9、数组与队列（先进先出）
     *      array_shift()在数组的开始弹出数据
     *      array_unshift()在队列的开始加入元素
     * 10、排序函数
     *      忽略键名的排序
     *         sort()、rsort()、usort()
     *      保留键名的排序
     *         asort()、arsort()、uasort()
     *      根据键名进行排序
     *         ksort()、krsort()、uksort()
     *      自然数排序
     *         natsort()、natcasesort()
     * 11、数组中计算函数
     *      array_sum()元素之和
     *      array_merge()合并数组函数
     *      array_merge_recursive()
     *      array_diff()数组的差值（完全删除相同的元素）；只返回第一个数组的元素
     *      array_diff_assoc()
     *      array_intersect()数组的交集（完全删除不同的元素）；只返回第一个数组的元素
     *      array_intersect_asseoc()
     * 12、
     * 13、
     * 14、
     */
    $arr = array("one"=>1,"two"=>"2",10=>"abc",123=>"100");
    var_dump(array_values($arr));
    echo"<br>";
    var_dump(in_array(100,$arr));
    var_dump(in_array(100,$arr,true));
    echo"<br>";
    extract($arr);
    var_dump($one);
    var_dump($two);
    echo"<br>";
    $two="sdf";
    $one="123";
    $three="sdfw2";
    $arr = compact("one","two","three");
    var_dump($arr);
    echo"<br>";
    array_push($arr,"one","two","three");
    var_dump($arr);
    echo"<br>";
    $val = array_pop($arr);
    var_dump($val);
    echo "<br>";
?>