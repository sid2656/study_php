<?php

class Calendar{
    //当月的第一天对应周几
    private $star_weekday;
    //当月的天数
    private $days;
    private $year;
    private $month;
    function __construct(){
        $this->year=isset($_GET["year"])?$_GET["year"]:date("Y");
        $this->month=isset($_GET["month"])?$_GET["month"]:date("m");
        $this->star_weekday = date("w",mktime(0,0,0,$this->month,1,$this->year));
        $this->days = date("t",mktime(0,0,0,$this->month,1,$this->year));
    }
    function out(){
        echo "<table align='center'>";
        $this->changeDate("date.php");
        $this->weekList();
        $this->dayList();
        echo "</table>";
    }
    /**
     * 循环输出星期
     * Enter description here ...
     */
    private function weekList(){
        $week = array("日","一","二","三","四","五","六");
        echo "<tr>";
        for ($i=0;$i<count($week);$i++){
            echo "<th class='fonth'>".$week[$i]."</th>";
        }
        echo "</tr>";
    }
    /**
     * 循环输出天数
     * Enter description here ...
     */
    private function dayList() {
        echo "<tr>";
        //输出空格
        for ($j=0;$j<$this->star_weekday;$j++){
            echo "<td></td>";
        }
        for ($i=1;$i<$this->days;$i++){
            $j++;
            if ($i==date("d"))
                echo "<th class='fonth'>".$i."</th>";
            else
                echo "<td>".$i."</td>";
                
            if ($j%7==0) {
                echo "</tr><tr>";;
            }
        }
        while ($j%7==0){
            echo "<td></td>";
            $j++;
        }
        echo "</tr>";
    }
    private function prevYear($year,$month){
        $year=$year-1;
        if ($year<1970)
            $year = 1970;
        return "year={$year}&month={$month}";
    }
    private function prevMonth($year,$month){
        if ($month==1){
            $year=$year-1;
            if ($year<1970)$year = 1970;
            $month=12;
        }else{
            $month=$month-1;
        }
        return "year={$year}&month={$month}";
    }
    private function nextYear($year,$month){
        $year=$year+1;
        if ($year>2038)
            $year = 2038;
        return "year={$year}&month={$month}";
    }
    private function nextMonth($year,$month){
        if ($month==12){
            $year=$year+1;
            if ($year>2038)$year = 2038;
            $month=1;
        }else{
            $month=$month+1;
        }
        return "year={$year}&month={$month}";
    }
    
    private function changeDate($url=""){
        echo "<tr>";
        echo "<td><a href='?".$this->prevYear($this->year, $this->month)."'>"."<<"."</a></td>";
        echo "<td><a href='?".$this->prevMonth($this->year, $this->month)."'>"."<"."</a></td>";
        
        echo "<td colspan='3'>";
        echo "<form>";
        echo '<select name="year" onchange="window.location=\''.$url.'?year=\'+this.options[selectedIndex].value+\'&month='.$this->month.'\'">';
        for ($y = 1970;$y<2039;$y++){
            $selected = ($y==$this->year)?"selected":"";
            echo "<option ".$selected." value='".$y."'>".$y."</option>";
        }
        echo "</select>";
        echo '<select name="month"  onchange="window.location=\''.$url.'?year='.$this->year.'&month=\'+this.options[selectedIndex].value">';
        for ($m = 1;$m<13;$m++){
            $selected = ($m==$this->month)?"selected":"";
            echo "<option ".$selected." value='".$m."'>".$m."</option>";
        }
        echo "</select>";
        echo "</form>";
        echo "</td>";
        
        echo "<td><a href='?".$this->nextMonth($this->year, $this->month)."'>".">"."</a></td>";
        echo "<td><a href='?".$this->nextYear($this->year, $this->month)."'>".">>"."</a></td>";
        echo "</tr>";
    }
}
?>