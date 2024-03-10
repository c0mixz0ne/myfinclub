<?php
if (isset($_POST['txtphone'])){
include('SxGeo.php');
$ip = $_SERVER['REMOTE_ADDR'];
$SxGeo = new SxGeo('SxGeoCity.dat');
$city=$SxGeo->getCity($ip);
$cityname=$city['city']['name_ru'];

//$cityname=iconv('Windows-1251','UTF-8',$cityname);



// this is email send form. (WORKING 100%)

/*$recepient = "ur email";
$sitename = "myfinclub.ru";

$name = trim($_POST['txtname']);
$lastname = trim ($_POST['txtlastname']);
$message =trim( $_POST['txtmessage']);
$email = trim($_POST['txtemail']);
$phone =trim ($_POST['txtphone']);
$gorod = ($cityname);
$message = "Имя: $name \n Фамилия: $lastname \nСообщение: $message \nMail: $email \n Phone:$phone \n Gorod:$gorod \n Mess:$message";

$pagetitle = "Новая заявка с сайта \"$sitename\"";
mail($recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient");*/
if (isset($_POST['summa'])){
	$summa=$_POST['summa'];
	preg_replace('/[^0-9]/', '', $summa); 
}
if (isset($_POST['txtname'])){
	$txtname=$_POST['txtname'];
}
if (isset($_POST['txtphone'])){
	$txtphone=$_POST['txtphone'];
}
if (isset($_POST['drop_downmenu'])){
	$drop_downmenu=$_POST['drop_downmenu'];
}
if (isset($_POST['cityname'])){
	$cityname=$_POST['cityname'];
}
if (isset($_POST['fin_surname'])){
	$fin_surname=$_POST['fin_surname'];
}
if (isset($_POST['type'])){
	$drop_downmenu=$_POST['type'];
}




	
//$summa=int($summa);

/*$message='';
if (isset($_POST['txtmessage'])){
	$message=$_POST['txtmessage']
}
$txtname='';
if (isset($_POST['txtname'])){
	$message=$_POST['txtname']
}
$txtlastname='';
if (isset($_POST['txtlastname'])){
	$message=$_POST['txtlastname']
}
$txtemail='';
if (isset($_POST['txtemail'])){
	$message=$_POST['txtemail']
}
$txtphone='';
if (isset($_POST['txtphone'])){
	$message=$_POST['txtphone']
}
$type='';
if (isset($_POST['type'])){
	$type=$_POST['type']
}*/


$post_data = array(
"fin_name"=>$txtname,
"istochnik"=>'myfinclub.ru',
"type"=>$drop_downmenu,
"phone"=>$txtphone,
"city"=>$cityname,
"summ"=>preg_replace('/[^0-9]/', '', $summa),
"fin_surname"=>$fin_surname, //email

);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://avtoaukcion.online/blank_avtokredit_save');
curl_setopt($curl, CURLOPT_RETURNTRANSFER,0);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_exec($curl);
curl_close($curl);
}
else 
{
	header("location:index.html");
}
?>

