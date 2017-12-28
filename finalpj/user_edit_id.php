<?php
session_start();
require("dbconnect.php");
require('model.php');
//取得目標內容
$id = (int)$_REQUEST['id'];
//SELECT * FROM `img`, `butterfly` WHERE `img`.`b_name`=`butterfly`.`name` AND `img`.`b_stage`=`butterfly`.`stage`
$sql = "select * from img where id=$id;";
$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
if ($rs=mysqli_fetch_assoc($result)) {
	$src=$rs['src'];
    $b_name=$rs['b_name'];
    $b_stage=$rs['b_stage'];
    $date=$rs['date'];
    $author=$rs['author'];
} else {
	echo "Your id is wrong!!";
	exit(0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User</title>
<link type="text/css" rel="stylesheet" href="user_upload.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
window.onload=function(){
	
$(function (){
    $('.upload_input').hide();
    function preview(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.upload_icon').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("body").on("change", ".upload_input", function (){
        preview(this);
    })
    
})
}
</script>
</head>

<body>
<div id="title">
<img src="image/圖片7.png" alt="Avatar" class="avatar" id="u">
<div id="menu">
<button class="tool" onclick="location.href='user_edit.php'">Edit</button><br />
<button class="tool" onclick="location.href='user_upload.php'">Upload</button>
</div>
</div>
<div id="content">
<form method="post" action="control.php" enctype="multipart/form-data">
<table id="t">
<tr><td rowspan="7" id="up_p"><label class="upload_cover">
    <input type="hidden" name="act" value="update">
    <input class="upload_input" type="file" name="upfile" />
    <?php echo "<img src='upload/", $src, "' class='img'/></label></td>"; ?>
    <th>名稱</th><td><select name='b_name'>
<?php
$results=getButterflyList();
global $i;
$i=1;
while ($rs=mysqli_fetch_array($results)) {
    if ( ($i%3) == 1) {
        echo "<option "; 
         if ($b_name==$rs['name']) 
             echo "selected"; 
         echo ">", $rs['name'], "</option>";
    }
    $i++;
}
echo "</td></tr>";
?>
<tr><th>階段</th><td><label><select name="b_stage">
        <option >幼蟲期</option>
        <option >變態期</option>
        <option >成蟲期</option>
</select></label></td></tr>
<tr><th>日期</th><td><label>
        <input type="text" name="date" value="<?php echo $date;?>"/>
</label></td></tr>
<tr><th>作者</th><td><label>
        <input name="author" type="text" value="<?php echo $author;?>" />
</label></td></tr>
</table>
<input type="submit" class="button" value="Submit" />
</form>

</div>
</body>
</html>
