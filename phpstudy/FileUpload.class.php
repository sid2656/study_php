<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");
    class FileUpload{
        //上传文件路径
        private $filepath;
        //上传文件类型
        private $allowtype = array("gif","jpg","png","jpeg");
        //上传文件的最大长度
        private $maxsize=102400;
        //是否设置重命名文件
        private $isnewname = true;
        private $originame;
        private $tmpfilename;
        private $filetype;
        private $filesize;
        private $newfilename;
        private $errorNum=0;
        private $errormess;
        
        /**
         * 用于对上传文件的初始化
         * 1.指定上传的路径
         * 2.指定允许的类型
         * 3.限制文件的大小
         * 4.是否生成新的文件名
         * 让用户可以不用按照位置传递参数
         */
        function __construct($options=array()){
            //查看本类的属性
//            print_r(@get_class_vars(get_class($this)));
            foreach ($options as $key=>$value){
                $key = strtolower($key);
//                echo "传递的数组参数".$key."=>".$value."<br>";
                //查看传递的数组下标是否存在成员属性的数组里
                if (!@in_array($key, get_class_vars(get_class($this)))){
                    continue;
                }else{
                    $this->setOptions($key, $value);
                }
            }
        }
        /**
         * 设置成员属性
         * Enter description here ...
         * @param unknown_type $key
         * @param unknown_type $value
         */
        private function setOptions($key,$value){
            $this->$key=$value;
        }
        /**
         * 获取错误信息
         * Enter description here ...
         */
        private function getError(){
            $str = "上传文件".$this->originame."出错！";
            switch ($this->errorNum){
                case 4:$str.="没有文件被上传";break;
                case 3:$str.="文件只有部分上传";break;
                case 2:$str.="上传文件超过了html表单中MAX_FILE_SIZE指定的值";break;
                case 1:$str.="上传文件超过了php.ini的upload_max_filsize的值";break;
                case -1:$str.="类型不合法";break;
                case -2:$str.="文件过大，上传文件不能超过".$this->maxsize."个字节";break;
                case -3:$str.="上传失败";break;
                case -4:$str.="建立文件目录失败，请重新指定上传目录";break;
                case -5:$str.="必须指定上传文件的路径";break;
                
                default:$str.="未知错误";
            }
            return $str."<br>";
        }
        /**
         * 检查路径
         */
        private function checkFilePath(){
            if (empty($this->filepath)){
                $this->setOptions('errorNum', -5);
                return false;
            }
            if (!file_exists($this->filepath)||!is_writable($this->filepath)){
                if (!@mkdir($this->filepath,0755)){
                    $this->setOptions("errorNum", -4);
                    return false;
                }
            }
            return true;
        }
        /**
         * 检查文件类型
         * Enter description here ...
         */
        private function checkType(){
            if (@in_array(strtolower($this->filetype), $this->allowtype)){
                return true;
            }else{
                $this->setOptions("errorNum", -1);
                return false;
            }
        }
        /**
         * 检查文件大小
         * Enter description here ...
         */
        private function checkFileSize(){
            if ($this->filesize>$this->maxsize){
                $this->setOptions("errorNum", -2);
                return false;
            }else {
                return true;
            }
        }
        /**
         * 设置上传后的文件名
         * Enter description here ...
         */
        private function setNewFilename(){
            if ($this->isnewname)
                $this->setOptions("newfilename", $this->proName());
            else
                $this->setOptions("newfilename", $this->originame);
        }
        /**
         * 设置文件名
         * Enter description here ...
         */
        private function proName(){
            $filename = @date("YmdHis").rand(100, 999);
            return $filename.".".$this->filetype;
        }
        private function copyFile(){
            if (!$this->errorNum){
                $filepath = rtrim($this->filepath,'/').'/';
                $filepath.=$this->newfilename;
                if (@move_uploaded_file($this->tmpfilename, $filepath)){
                    return true;
                }else{
                    $this->setOptions("error", -3);
                    return false;
                }
            }else {
                return false;
            }
        }
        
        /**
         * 用于上传一个文件
         * Enter description here ...
         * @param unknown_type $fileField
         */
        function uploadFile($fileField){
            $return = true;
            //检查文件路径是否正确
            if (!$this->checkFilePath()){
                $this->errormess = $this->getError();
                return false;
            }
            $name=$_FILES[$fileField]['name'];
            $tmp_name=$_FILES[$fileField]['tmp_name'];
            $size=$_FILES[$fileField]['size'];
            $error=$_FILES[$fileField]['error'];
            
            if (is_array($name)){
                $filnames = array();
                $errors = array();
                for ($i=0;$i<count($name);$i++){
                    if ($this->setFiles($name[$i],$tmp_name[$i],$size[$i],$error[$i])){
                        if (!$this->checkFileSize()||!$this->checkType()){
                            $errors[]=$this->getError();
                            $return = false;
                        }else {
                            $this->setNewFilename();
                            if ($this->copyFile()){
                                $filnames[] = $this->newfilename;
                            }else{
                                $return = false;
                            }
                        }
                    }else{
                        $errors[]=$this->getError();
                        $return = false;
                    }
                    if (!$return)
                        $this->setFiles();
                }
                $this->errormess=$errors;
                $this->newfilename=$filnames;
                return $return;
            }else{
                if ($this->setFiles($name,$tmp_name,$size,$error)){
                    if ($this->checkFileSize()&&$this->checkType()){
                        $this->setNewFilename();
                        if ($this->copyFile()){
                            return true;
                        }else{
                            $return = false;
                        }
                    }else {
                        $return = false;
                    }
                }else{
                    $return = false;
                }
                if (!$return)
                    $this->errormess = $this->getError();
                return $return;
            }
        }
        /**
         * 设置和$FILES有关的内容
         * Enter description here ...
         */
        private function setFiles($name="",$tmp_name="",$size=0,$error=0){
            $this->setOptions("errorNum", $error);
            if ($error){
                return false;
            }
            $this->setOptions("originame", $name);
            $this->setOptions("tmpfilename", $tmp_name);
            $this->setOptions("filesize", $size);
            $arrStr = explode(".", $name);
            $this->setOptions("filetype", strtolower($arrStr[count($arrStr)-1]));
            return true;
        }
        /**
         * 获取上传后的文件名
         * Enter description here ...
         */
        function getNewFileName(){
            return $this->newfilename;
        }
        /**
         * 上传如果失败则调用此方法
         * 查看错误报告
         * Enter description here ...
         */
        function getErrorMsg(){
            return $this->errormess;
        }
    }

?>