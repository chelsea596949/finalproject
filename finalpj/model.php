<?php
require("dbconnect.php");


    function insert_img ($src='', $b_name='', $b_stage='', $date='', $author='') {
    global $conn;
	if ($src > ' ') {
		//基本安全處理
        $src=mysqli_real_escape_string($conn,$src);
        $b_name=mysqli_real_escape_string($conn,$b_name);
        $b_stage=mysqli_real_escape_string($conn,$b_stage);
        $date=mysqli_real_escape_string($conn,$date);
        $author=mysqli_real_escape_string($conn,$author);
        
        $sql = "insert into img (src, b_name, b_stage, date, author) values ('$src', '$b_name', '$b_stage', '$date', '$author');";
        return mysqli_query($conn, $sql); //執行SQL
	} else return false;
}

function getButterflyList() {
    global $conn;
	$sql = "SELECT * FROM `butterfly`";
	return mysqli_query($conn, $sql);
}
function deleteimg($id){
    global $conn;
    $id = (int) $id;
    $sql = "delete from img where id=$id;";
    return mysqli_query($conn, $sql);
}
function showButterfly() {
    global $conn;
	$sql = "SELECT * FROM `img`";
	return mysqli_query($conn, $sql);
}
function updatedata($id,$b_name,$b_stage,$date,$author){
	global $conn;
	$b_name=mysqli_real_escape_string($conn,$b_name);
	$b_stage=mysqli_real_escape_string($conn,$b_stage);
	$date=mysqli_real_escape_string($conn,$date);
	$author=mysqli_real_escape_string($conn,$author);
	$id = (int)$id;
	if ($b_name and $id) { //if title is not empty
		$sql = "update img set b_name='$b_name',b_stage='$b_stage' ,date='$date',author='$author' where id=$id;";
		mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
	}
}
function search($name, $season, $stage) {
    global $conn;
	if($name == '--') {
		if($season == '--') {
			if($stage == '--') {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE name = b_name AND stage = b_stage";
			} else {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE stage LIKE '$stage' AND name = b_name AND stage = b_stage";
			}
		} else {
			if($stage == '--') {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE season LIKE '$season' AND name = b_name AND stage = b_stage";
			}
			else {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE season LIKE '$season' AND stage LIKE '$stage' AND name = b_name AND stage = b_stage";
			}
		}
	}else {
		if($season == '--') {
			if($stage == '--') {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE name LIKE '$name' AND name = b_name AND stage = b_stage";
			} else {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE name LIKE '$name' AND stage LIKE '$stage' AND name = b_name AND stage = b_stage";
			}
		} else {
			if($stage == '--') {
				$sql = "SELECT * FROM `butterfly`,`img` WHERE season LIKE '$season' AND name LIKE '$name' AND name = b_name AND stage = b_stage";
			} else {
				$sql = "SELECT * FROM `butterfly`, `img` WHERE season LIKE '$season' AND name LIKE '$name' AND stage LIKE '$stage' AND name = b_name AND stage = b_stage";
			}
		}
	}
	return mysqli_query($conn, $sql);
}
function show_results($name, $season, $stage) {
	$results=search($name, $season, $stage);
    // $i=1;
    // echo "<table class='pic'>";
    // while ($rs=mysqli_fetch_array($results)) {
        // if ($i%3==1) 
            // echo "<tr>";
            // echo "<td class='k'><div style=\"background-image:url('upload/", $rs['src'], "')\" class='img'></div>";
            // if ($i%3==0)
                // echo "</tr>";
            // $i++;
    // }
    // echo "</table>";
    $result =array();
    while ($rs=mysqli_fetch_array($results)) {
       array_push($result,'upload/'.$rs['src'], $rs['id']);
    }
    return json_encode($result,JSON_UNESCAPED_UNICODE);
}
function showMyButterfly($uid){
	global $conn;
    if ((int)($uid)==1)
        $sql = "SELECT * FROM `img`";
    else
        $sql = "SELECT `img`.src,`img`.id FROM `img`, `user` WHERE img.author=user.name and user.id=$uid ";
	return mysqli_query($conn, $sql);
}
function getitButterflyList($id) {
    global $conn;
	$sql = "SELECT `butterfly`.*, `img`.`src` FROM `img`, `butterfly` WHERE img.b_name=butterfly.name AND img.b_stage=butterfly.stage AND img.id=$id";
	return mysqli_query($conn, $sql);
}
function editdata($id,$name,$nickname,$field,$gender,$stage,$season,$description){
	global $conn;
	$name=mysqli_real_escape_string($conn,$name);
	$nickname=mysqli_real_escape_string($conn,$nickname);
	$field=mysqli_real_escape_string($conn,$field);
	$gender=mysqli_real_escape_string($conn,$gender);
	$stage=mysqli_real_escape_string($conn,$stage);
	$season=mysqli_real_escape_string($conn,$season);
	$description=mysqli_real_escape_string($conn,$description);
	$id = (int)$id;
	if ($name and $id) { //if title is not empty
		$sql = "update butterfly set name='$name',nickname ='$nickname' ,field='$field',gender='$gender',stage='$stage',season='$season',description='$description' where butterfly.name='$name' and butterfly.stage='$stage';";
		mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
	}
}
function checkUser ($id) {
    global $conn;
    $id = (int)$id;
    $sql = "SELECT `name` FROM `user` WHERE user.id=$id";
    return mysqli_query($conn, $sql);
}
?>