<?php
	$view = 'list';
	require_once("global.php");

	$link = mysql_connect($db_config['server'], $db_config['user'], $db_config['pass'])
		or die("Could not connect: " . mysql_error());
	mysql_query("SET NAMES 'UTF8'");
	mysql_select_db( $db_config['database'], $link );

	$meeting_name = $_COOKIE['meeting_name'];
//	setcookie("meeting_name", $user, time()-60*60*24*30 );		//设置为30天有效期
//	setcookie("meeting_name_pass", md5($pass), time()-60*60*24*30 );		//设置为30天有效期

	$is_admin = $meeting_name && in_array($meeting_name, array_keys($db_users) ) && $_COOKIE['meeting_name_pass'] == md5($db_users[$meeting_name]) ? true : false;
	
	$action = $_GET['act'];
	if ( $action ) {
		switch($action){
			case 'del' :
				$id = $_POST['id'];
				if ( !$id ) {
					echo 'id_err';
					exit;
				}

				$flag_del = false;
				$r_state  = false;

				if ( $is_admin ) {		//白名单中的管理员可以删除任何栏目

					$flag_del = true;

				} else if ( $meeting_name ){		//可以删除自己添加的栏目
					$sql = 'select name from boc_meeting_scheduled where id=' . $id;
					$r = mysql_query($sql);
					$r = mysql_fetch_row($r);

					if ( $r ) $item_name = $r[0];
					if ( $meeting_name == $item_name ) $flag_del = true;
				}

				if ( $flag_del ) {
					$sql = 'update boc_meeting_scheduled set display="F" where id=' . $id;
					$r_state = mysql_query($sql);
				}

				echo $r_state ? 'succ' : 'fail';
				exit;
				break;
			case 'login' :
				$user = $_POST['user'];
				$pass = $_POST['pass'];
				if ( empty($user) || empty($pass) ){
					echo 'null_err';
					exit;
				}

				$r = false;
				if ( $db_users[$user] && $db_users[$user] == $pass ) {
					$r = true;

					setcookie("meeting_name", $user, time()+60*60*24*30 );		//设置为30天有效期
					setcookie("meeting_name_pass", md5($pass), time()+60*60*24*30 );		//设置为30天有效期
				}

				echo $r ? 'succ' : 'fail';
				exit;
				break;
		}
	}

	$page_size = 20;

	$sql_total = "select count(*) from boc_meeting_scheduled where display='T'";

	$r = mysql_query($sql_total);
	$r = mysql_fetch_row($r);
	$total_num = $r[0];
	
	$page = $_GET["Page"];
	if ( !$page ) $page = 1;
	$limit = " limit " . ( $page-1 ) * $page_size . ", " . $page_size;

	$sql = "select * from boc_meeting_scheduled where display='T' order by id desc" . $limit;

	$result = mysql_query($sql);
	
	$lists = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$id = $row['id'];
		$room_no = $row['room_no'];
		$row['room_name'] = $rooms_arr[$room_no]['name'];

		$lists[$id] = $row;
    }

	$output['lists'] = $lists;
	$output['total_num'] = $total_num;
	$output['page_size'] = $page_size;
	$output['page'] = $page;

	$output['is_admin'] = $is_admin;
	if ( $meeting_name ) $output['user'] = $meeting_name;

	if ( $view ) require_once('./tpl/' . $view . '.php');

?>