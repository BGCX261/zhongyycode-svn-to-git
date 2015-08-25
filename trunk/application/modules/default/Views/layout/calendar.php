<?php
$y=date("Y");
$m=date("m");
$today=date("Y").date("m").date("d");
function getWF($y,$m){//得到某年某月的1号星期几
	return idate("w",mktime(0,0,0,$m,1,$y));
}
function getTS($y,$m){//得到某年某月的总天数
	return idate("t",mktime(0,0,0,$m,1,$y));
}
function getW($y,$m,$d){ //得到某年某月的几号星期几
	return idate("w",mktime(0, 0, 0, $m,$d,$y));
}
function getFD($y,$m,$d){
	return date("Ymd",mktime(0, 0, 0, $m,$d,$y));
}
//function getRowNums($y,$m){
// //(int)(($total+$pagesize-1)/$pagesize)
// return (int)((getWF($y,$m)+getTS($y,$m)+7-1)/7);
//}
?>
<div class="cate-title">日历</div>
<div class="cate-content">
		<div style="margin:0px; padding:0px; font-size:14px; font-weight:bold; color:#000;">
			<?=date("Y-m-d ");?>
		</div>
		<table>
		<tr>
		   <th class="week0"><strong>日</strong></th>
		   <th><strong>一</strong></th>
		   <th><strong>二</strong></th>
		   <th><strong>三</strong></th>
		   <th><strong>四</strong></th>
		   <th><strong>五</strong></th>
		   <th class="week6"><strong>六</strong></th>
		</tr>
		<?php
		$hao= 1;
		echo "<tr>";
		for($i=getTS($y,$m-1)-(getWF($y,$m)-1);$i<=getTS($y,$m-1);$i++){
		   echo "<td class=\"pre\">".$i."</td>";
		}

		for($i=1;$i<=7-getWF($y,$m);$i++){
		   if($today==getFD($y,$m,$i)){
			echo "<td class=\"today\">".$hao++."</td>";
		   }else{
			echo "<td class=\"week".getW($y,$m,$hao)."\">".$hao++."</td>";
		   }
		}
		echo "</tr>";
		?>
		<?php for($i=2;$i<7;$i++){?>
		<tr>
		   <?php
		   for($j=0;$j<7;$j++){
			if($hao>getTS($y,$m)){
			 echo "<td class=\"next\">".($hao-getTS($y,$m))."</td>";
			 //echo '<td class="next">'.($hao-getTS($y,$m)).'</td>';
			}else{
			 if($today==getFD($y,$m,$hao)){
			  echo "<td class=\"today\">".$hao."</td>";
			 }else{
			  echo "<td class=\"week".$j."\">".$hao."</td>";
			 }
			}
			$hao++;
		   }
		   ?>
		</tr>
		<?php } ?>
		</table>
		<div class="clearfloat"></div>
</div>