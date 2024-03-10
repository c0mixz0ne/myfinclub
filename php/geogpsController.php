<?php

//$new_object=new geogpsController('http://rnis54.ru/api/Api.svc/','demo','demo');
$new_object=new geogpsController('http://rnis54.ru/api/Api.svc/','mega','mega2116');

$connect=$new_object->connect();
$gettree=$new_object->gettree();
//echo "cookie:";
//print_r($new_object->cookie);
$gettree=json_decode($gettree,true);

$gettree=$gettree['children'];
$gettree=$gettree[0]['children'];
$gettree=$gettree[0]['children'];

//echo "<table>";
foreach ($gettree as $node) {
	//echo "<pre>";
	//print_r($node);

	switch($node['move'])
	{

		case 110:$move="стоит, связь есть";break;
	 	case 111:$move="едет, связь есть";break;
	 	case 101:$move="нет связи, до потери связи ехал";break;
	 	case 100:$move="нет связи, до потери связи стоял";break;
	 	case 201:$move="в последнем сообщении GPS не валиден, сейчас нет связи, до этого ехал";break;
	 	case 200:$move="в последнем сообщении GPS не валиден, сейчас нет связи, до этого стоял";break;
	 	case 210:$move="GPS не валиден связь есть";break;
	 	case 211:$move="GPS не валиден связь есть";break;
	 	case 666:$move="Объект заблокирован за неуплату";break;
	 	case 667:$move="Объект заблокирован пользователем (ручная блокировка)";break;

	}

	$adress=$new_object->getadress($node['lat'],$node['lon']);

$geo_alarm=$new_object->pointgeozone($node['lat'],$node['lon']);

	$info=$new_object->fullobjinfo($node['oid']);


//print_r($geo_alarm);


	//echo "<tr><td>Имя авто: </td<td>".$node['name']."</td><td>".$move."</td>  <td>".$adress." </td> </tr>" ;
}
//echo "</table>";

class geogpsController 
{
var $server;
var $login_auth;
var $login_pass;
var $cookie;
var $reports_number;
var $main_geozone;
var $max_day_kilometres;

//http://rnis54.ru/api/Api.svc/pointintozone?geo_id=11904&lat=58.0277750651042&lon=56.302197265625

function __construct($server,$login_auth,$login_pass) {
	$this->server=$server;
	$this->login_auth=$login_auth;
	$this->login_pass=$login_pass;

}

public function connect_to_gps()
	{
		$this->server=0;
	}	
	
	//отслеживание выезда из геозоны
	
public function geozone_escape($geozone_id) {
	//функция осматривает все автомобили на предмет выезда из геозоны  шлет оповещения об этом
	}


public function fullobjinfo($oid) {
	 $url=$this->server."fullobjinfo?oid=$oid";


	 $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookie); 
            $head = curl_exec($ch); 
            curl_close($ch); 
            return $head;
}
	
public function getadress($lat,$lon){
	 $url=$this->server."getaddress?lat=$lat&lon=$lon";

	 $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookie); 
            $head = curl_exec($ch); 
            curl_close($ch); 
            return $head;
}

public function last_check_point($auto_id) {
	//функция отдает координаты маяка пропавшего из сети

	return $data;
	}
	
public function day_track_monitoring($auto_id) {
	//функция оповещает если пробег автомобиля превысил заданный параметр-километраж
	
	/*
	ло
Метод getobjectsreport
Метод возвращает различные данные по указанному объекту за определенный промежуток времени: пробег, расход, моточасы, время стоянок и т.д.
	*/
	}
	
	
//БАЗОВЫЕ ФУНКЦИИ-------------------------------------------------------------------------

public function connect()	{

$url=$this->server."connect?login=".$this->login_auth."&password=".$this->login_pass."&lang=ru-ru&timezone=3";


 /* $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

            $ua = 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 MRA 5.7 (build 03796) Firefox/3.6.13';

    curl_setopt($ch, CURLOPT_HEADER, 1); 
    // не показывать тело страницы (для экономии траффика):
    curl_setopt($ch, CURLOPT_NOBODY, 1); 
    // это чтобы прикинуться браузером:
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
            $head = curl_exec($ch); 
            curl_close($ch); 
   preg_match_all('/^Set-Cookie:\s*([^;]+)/',
    $head,
    $out, PREG_PATTERN_ORDER);

  print_r($head);
  echo "<br>";
  print_r($out);
    // и возвращаем результат:
    $this->cookie=$cookie;*/
    /* STEP 1. let’s create a cookie file */
$ckfile = tempnam ("/tmp", "CURLCOOKIE");
/* STEP 2. visit the homepage to set the cookie properly */
$ch = curl_init ($url);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);

$this->cookie=$ckfile;




	/*Метод используется для открытия сессии взаимодействия с сервером. Любая сессия взаимодействия может проводиться только полсе авторизации пользователя.
	Тип запроса - GET
	Входные параметры:
		•	login - имя пользователя из под которого будут осуществляться запросы
		•	password - пароль пользователя
		•	lang - язык пользователя 
		•	Возможные варианты:
		◦	ru-ru - русский
		◦	en-us - английский
		◦	ro-ro - румынский
		•	timezone - отклонение временной зоны пользователя от UTC в часах, например, для Москвы 3 (для регионов западнее Гринвича часы смещения передаются со знаком "-")
	Ответ:
	"Ok" - при успешном подключении (Ok - в англ.раскладке) или текст ошибки на языке заданном в параметре lang
	Примеры запросов:
	https://rnis54.ru/api/Api.svc/connect?login=demo&password=demo&lang=ru-ru&timezone=3
	https://rnis54.ru/api/Api.svc/connect?login=demo&password=no_password&lang=ruru&timezone=3
	Примеры ответов:
	"Ok"
	"Неверный логин или пароль."
	*/
	
	}
	
public function disconnect()	{
	/*
	Метод disconnect
	Метод используется для закрытия текущей сессии пользователя
	Тип запроса - GET
	*/
	}
	
public function gettree() {

	$url=$this->server."gettree?all=true";

  $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookie); 
            $head = curl_exec($ch); 
            curl_close($ch); 
            return $head;




	/*
		Метод gettree
	Метод возвращает сгруппированный в дерево список доступных для пользователя объектов мониторинга.
	Тип запроса - GET
	Входные параметры:
		•	all - в случае передачи true - будут возвращены объекты и группы всех компаний видимых пользователю, в случае передачи false - только родной компании пользователя
	Ответ:
		•	result - Результат выполнения запроса. "Ok" - если запрос выполнен успешно, или текст ошибки.
		•	children - список групп верхнего уровня
		•	Каждый объект в списке имеет следующие поля:
		◦	id - Идентификатор группы или объекта в пределах данного дерева
		◦	parent_id - Идентификатор в базе данных родительской группы объекта
		◦	real_id - Идентификатор объекта в базе данных
		◦	name - Текстовое имя объекта заданное ему при создании

		◦	leaf - Признак что данная запись - объект (false - группа, true - объект)
		◦	iconCls - Имя CSS класса для отображения объекта в дереве
		◦	obj_icon - Имя файла иконки для отображения объекта на карте (все файлы с иконками доступны по адресу http://[DNS имя или IP адрес сервера]/icons/objects/[имя файла])
		◦	obj_icon_height - Высота иконки объекта в пикселях
		◦	obj_icon_width - Ширина иконки объекта в пикселях
		◦	obj_icon_rotate - Признак необходимости поворачивать иконку объекта на карте при изменении направления его движения (true - поворачивать, false - не поворачивать)
		◦	IMEI - Идентификатор объекта передаваемый им при подключении к серверу в собственном протоколе, обычно это IMEI GSM модуля
		◦	status - Текущий статус объекта (наиболее критичное незакрытое событие)
		◦	Возможные варианты:
		▪	1 - Критичное
		▪	2 - Серьезное
		▪	3 - Несущественное
		▪	4 - Информационное
		▪	5 - Нормальное
		◦	lat - широта местоположения объекта в формате градусы – доли градусов
		◦	lon - долгота местоположения объекта в формате градусы – доли градусов
		◦	direction - Направление движения объекта в градусах относительно севера
		◦	dt - Время последних данных от объекта (добавлено в версии 3.3)
		◦	move - Текущий статус перемещения объекта
		◦	Возможные варианты:
		▪	110 - стоит, связь есть
		▪	111 - едет, связь есть
		▪	101 - нет связи, до потери связи ехал
		▪	100 - нет связи, до потери связи стоял
		▪	201 - в последнем сообщении GPS не валиден, сейчас нет связи, до этого ехал
		▪	200 - в последнем сообщении GPS не валиден, сейчас нет связи, до этого стоял
		▪	210 - GPS не валиден связь есть
		▪	211 - GPS не валиден связь есть
		▪	666 - Объект заблокирован за неуплату
		▪	667 - Объект заблокирован пользователем (ручная блокировка)
		◦	IsGroup - Признак что данная запись это группа (true - это группа, false - это объект)
		◦	block_reason - признак блокировки объекта
		◦	Возможные варианты:
		▪	0 - не заблокирован
		▪	1 - заблокирован пользователем (ручная блокировка)
		▪	2 - заблокирован за неуплату
		◦	children - Список объектов или групп входящих в данную группу
	Пример запроса:
	http://rnis54.ru:65080/api/Api.svc/gettree?all=true
	Пример ответа:
	{"children":[{"IMEI":null,"IsGroup":true,"block_reason":0,"children": [{"IMEI":null,"IsGroup":true,"block_reason":0,"children": [{"IMEI":"863071010643622","IsGroup":false,"block_reason":0,"children":null,"direction": 355,"iconCls":"object-leaf","id":4,"lat":54.37055,"leaf":true,"lon":48.62209,"move": 111,"name":"543 УАЗ","obj_ico_colored":false,"obj_icon":"car.png","obj_icon_height":45, "obj_icon_rotate":true,"obj_icon_width":20,"parent_id":438,"real_id":1435,"status":5}, {"IMEI":"863071011205223","IsGroup":false,"block_reason":0,"children":null,"direction": 55,"iconCls":"object-leaf","id":5,"lat":54.37305, "leaf":true,"lon":48.61282,"move":
	110,"name":"331 УАЗ","obj_ico_colored":false,"obj_icon":"car.png","obj_icon_height": 45,"obj_icon_rotate":true,"obj_icon_width":20,"parent_id":438, "real_id":1745,"status":5}, {"IMEI":"863071011200547","IsGroup":false,"block_reason":0,"children":null,"direction":119, "iconCls":"object-leaf","id":6,"lat":54.32408,"leaf":true,"lon":48.39508,"move":110,"name":"401 Нива","obj_ico_colored":false,"obj_icon":"car.png","obj_icon_height":45,"obj_icon_rotate":true, "obj_icon_width":20,"parent_id":438,"real_id":1746,"status":5}], "direction":0,"iconCls":"x-treeicon-parent","id":3,"lat":0,"leaf":false,"lon": 0,"move":-2,"name":"Авиастар","obj_ico_colored":false,"obj_icon":null,"obj_icon_height":0, "obj_icon_rotate":false,"obj_icon_width":0,"parent_id":402,"real_id":438,"status":-2}],"direction": 0,"iconCls":"x-tree-icon-parent","id":2,"lat":0,"leaf":false,"lon":0, "move":-2,"name":"АвиастарСП","obj_ico_colored":false,"obj_icon":null, "obj_icon_height": 0,"obj_icon_rotate":false,"obj_icon_width":0,"parent_id":0,"real_id":402,"status":-2}], "result":"Ok"}
	В 
	*/
}



public function pointgeozone($lat, $lon) {
/*
	pointintozone
Тип: GET
Параметры:
geo_id - уид геозоны
lat - широта точки (WGS84 lat/lon, градусы и десятые доли градусов)
lon - долгота точки (WGS84 lat/lon, градусы и десятые доли градусов)

Ответ: {"result":"True"}

Возможные варианты result:
True - координаты входят в геозону
False - координаты не входят в геозону
NoAuth - сессия пользователя не найдена
NoPermiss - нет прав на просмотр данной геозоны (н-р, геозона находится в другой компании, которую данный пользователь не видит)
NotFound - геозона с таким уидом не найдена (либо была ошибка при ее загрузке)
Error - ошибка при обработке запроса

Пример запроса:
http://192.168.0.201/api/Api.svc/pointintozone?geo_id=11904&lat=58.0277750651042&lon=56.302197265625
*/
$geoid=3;

$url=$this->server."pointintozone?geo_id=$geoid?lat=$lat&lon=$lon";

  $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->cookie); 
            $head = curl_exec($ch); 
            curl_close($ch); 
           
//if ($head =='False')  {
	# code...
//}

//если ответ false - мы должны отправит смс

            return $head;


}
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>GeoGPS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
    </script>
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap, 
            myPlacemark;

        function init(){ 
            myMap = new ymaps.Map("map", {
                center: [55.04, 82.93],
                zoom: 12
            }); 


            

            <?php
            foreach ($gettree as $node) {
	//echo "<pre>";
	//print_r($node);

	switch($node['move'])
	{

		case 110:{$move="стоит, связь есть";$icon="img/car_stop.png";}break;
	 	case 111:{$move="едет, связь есть";$icon="img/car_drive.png";}break;
	 	case 101:{$move="нет связи, до потери связи ехал";$icon="img/car_warning.png";}break;
	 	case 100:{$move="нет связи, до потери связи стоял";$icon="img/car_warning.png";}break;
	 	case 201:{$move="в последнем сообщении GPS не валиден, сейчас нет связи, до этого ехал";$icon="img/car.png";}break;
	 	case 200:{$move="в последнем сообщении GPS не валиден, сейчас нет связи, до этого стоял";$icon="img/car.png";}break;
	 	case 210:{$move="GPS не валиден связь есть";$icon="img/car.png";}break;
	 	case 211:{$move="GPS не валиден связь есть";$icon="img/car.png";}break;
	 	case 666:{$move="Объект заблокирован за неуплату";$icon="img/car.png";}break;
	 	case 667:{$move="Объект заблокирован пользователем (ручная блокировка)";$icon="img/car.png";}break;
	 	default:$icon="img/car.png";break;

	}

	?>
            myPlacemark = new ymaps.Placemark([<?php echo $node['lat']; ?> ,<?php echo $node['lon']; ?>], {
                hintContent: '<?php echo $node['name']; ?>',
                balloonContent: '<?php echo $move; ?>'

            }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
            iconImageHref: "<?php echo $icon; ?>",
            // Размеры метки.
            iconImageSize: [50, 50],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -25]
        }

            );
            
            myMap.geoObjects.add(myPlacemark);

            <?php } ?>
        }
    </script>
</head>

<body>
    <div id="map" style="width: 1000px; height: 1000px"></div>
</body>

</html>