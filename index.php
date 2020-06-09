<title>Mobsters</title>
<body bgcolor='black'>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<font color='white'><?php
// Turn off all error reporting
//error_reporting(0);

$device = $_SERVER['HTTP_USER_AGENT'];
//echo $device;

if(strpos($device, 'Chrome') !== false || strpos($device, 'Firefox') !== false) {
if(strpos($device, 'Android') !== false || strpos($device, 'iPhone') !== false) {
}else{
$enable = '1';
}
}

if($enable == '1') {
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$computer_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$externalContent = file_get_contents('http://ipecho.net/');
preg_match('/Your IP is \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$ip_address = $m[1];
if($computer_name == '' || $ip_address == ''){
echo "<center><font size='5' color='red'>Could not get information.</font></center><br>";
}else{
include_once 'conn1651651651651.php';

if(isset($_GET['register'])){
echo "<center><a style='font-size:35px;text-decoration:none;color:white;' href='../ '>[<-Back]</a></center><br>";
if(isset($_POST['email'])){
$email = $_POST['email'];
$password = $_POST['password'];
if($email == '' || $password == ''){
echo "<center><font size='5' color='red'>Information not correct. Please correct it!</font></center>";
}else{
$result = $mysqli->query("SELECT * FROM registered_users WHERE email='".$email."'");
$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);
if($count > 0){
echo "<center><font size='5' color='red'>Email already exists.</font></center>";
}else{
$mysqli->query("INSERT INTO registered_users
(ip, picture, email, password) VALUES('$ip_address','','$email','$password')") 
or die(mysqli_connect_errno());
header("Refresh:0; url=../?registered=1");
}
}

}
echo "<center>
<form action='?register' method='POST'>
<font size='5' color='white'>Email:</font><br>
  <input type='text' style='width:300px;font-size:20px;height:28px;' name='email' value=''><br>
<font size='5' color='white'>Password:</font><br>
  <input type='text' style='width:300px;font-size:20px;height:28px;' name='password' value=''><br><br>
  <input style='font-size:18px;' type='submit' value='Submit Registration'></form>
</center>";
}else{
session_start();
$value = "";
if($_SESSION['character_id'] == null){
$_SESSION['character_id'] = $value;
$get_variables = file_get_contents('php://input');
if($get_variables !== ''){
$email = strstr($get_variables, 'email');
$email = substr($email, 0, strpos($email, '&'));
$email = str_replace('%40', '@', $email);
$email = str_replace('email=', '', $email);
$email = str_replace(' ', '', $email);

$password = strstr($get_variables, 'password');
$password = str_replace('password=', '', $password);
$password = str_replace(' ', '', $password);

//echo "<center><font size='5' color='white'>".$email."</font></center>";
//echo "<center><font size='5' color='white'>".$password."</font></center>";

if($email == '' || $password == ''){
echo "<center><font size='5' color='white'>Information not correct. Please correct it!</font></center>";
header("Refresh:0; url=../?error=112");
}else{
$rrrr = $mysqli->query("SELECT * FROM registered_users WHERE email='".$email."' AND password='".$password."'") or die("Cannot Connect");
$row = mysqli_fetch_array($rrrr);
$count = mysqli_num_rows($rrrr);

if($count > 0){
if($row['banned'] == '1'){
header("Refresh:0; url=../?banned");
}else{
$result = $mysqli->query("SELECT * FROM characters WHERE belongsto='".$row['id']."' AND characterloaded='1'");
$count = mysqli_num_rows($result);
if($count > 0){
$y = mysqli_fetch_assoc($result);
$_SESSION['character_id'] = $y['id'];
}else{
$_SESSION['character_id'] = "";
}

$_SESSION['user_id'] = $row['id'];
header("Refresh:0; url=../home/");
}
}else{
echo "<center><font size='5' color='white'>Email or password is incorrect.</font></center>";
header("Refresh:0; url=../?error=132");
}
}
}else{
$rando = rand(1,99);
$email = $rando."_email";
$password = $rando."_password";

if(isset($_GET['banned'])){
echo "<center><font size='5' color='red'>This account is banned.</font></center><br>";
header("Refresh:0; url=../?error=126");
}
if(isset($_GET['error'])){
$error = $_GET['error'];
if($error == '132'){
echo "<center><font size='5' color='white'>Email or password is incorrect.</font></center><br>";
}
if($error == '126'){
echo "<center><font size='5' color='red'>This account is banned.</font></center><br>";
}
if($error == '112'){
echo "<center><font size='5' color='white'>Information not correct. Please correct it!</font></center><br>";
}
}

if($_GET['registered'] == '1'){
echo "<center><font size='5' color='green'>You have registered. You may now login.</font></center>";
}
?>
<center>
<form method='POST'>
<font size='5' color='white'>Email:</font><br>
  <input type="text" style="width:300px;font-size:20px;height:28px;" name="<?php echo $email; ?>" value="" autocomplete="on"><br>
<font size='5' color='white'>Password:</font><br>
  <input type="text" style="width:300px;font-size:20px;height:28px;" name="<?php echo $password; ?>" value="" autocomplete="on"><br><br>
  <input style='font-size:18px;' type="submit" value="Login"></form>
</center>
<center><font size='5' color='white'>Don't have a account yet?</font></center>
<center>
<a style='text-decoration:none;' href='?register'><input style='font-size:18px;' type="submit" value="Register"></a>
</center>
<br>
<center><b><font size='5' color='red'>WARNING!!!!</font></b></center>
<center><font size='4' color='white'>If you try to exploit the system you WILL<br>get a account ban and IP ban.<br>Play fair with your fellow mobbies.</font></center>
<br>
<?php 
} 
}else{
header("Refresh:0; url=../home/");
}
}
}
}else{
echo "<center><font size='6' color='white'>Your device/web browser is not supported!</font></center>";
}
?>
