#!/usr/bin/php
<?php
function doSomething($input){
include ('account.php');
$db = mysqli_connect($hostname,$username,$password,$project);
if(mysqli_connect_error()){
	Print "Failed to connect to MYSQL:" .mysqli_conect_error();
	exit();
}
mysqli_select_db($db, $project);
var_dump($input);
switch($input['type']){

	case "login":

		$sql = "Select * FROM users WHERE username = '{$input['data']['username']}'";
		echo $sql;
		$result = mysqli_query($db,$sql);
		if(mysqli_num_rows($result) == 0){
			return 1;
		}else{
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				if($password == $row["password"]){
					return 0;
				}else{
					return 2;
				}
			}
		}
	case "register":
			
		$s="select * from it490 where user = '{$input['data']['username']}'";
		$result = mysqli_query($db,$s);
		if(mysqli_num_rows($result) != 0){
			return 1;
		}else{
		
			$sql="insert into users 'username', 'password', 'firstname', 'lastname') values ({$input['data']['username']},{$input['data']['password']},{$input['data']['firstname']}, {$input['data']['$lastname']})";
			mysqli_query($db,$sql);
			return 0;
		}
	case "sanatize":
	
		return mysqli_real_escape_string($db, $input['data']);
}
}
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
function process($recieved){
	//var_dump($recieved);
if($recieved['type'] == 'login'){
	return doSomething($recieved);
}else if($recieved['type'] == 'register'){
	return doSomething($recieved);
}else if($recieved['type'] == 'sanatize'){
	return doSomething($recieved);
}else if($recieved['type'] == 'log'){

}else if($recieved['type'] == 'update'){

}
}

$server = new rabbitMQServer("rabbitMQ.ini", "database");
echo "server started up";
$server->process_requests('process');
?>
