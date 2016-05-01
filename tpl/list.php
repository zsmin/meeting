<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7">
<title>会议室预定列表</title>

<link href="./style/css/skin_0.css" rel="stylesheet" type="text/css"/>
<script language="javascript" type="text/javascript" src="./style/js/jquery.js"></script>
<style type="text/css">
body{
	font-family: '微软雅黑',Arial;
	font-weight: normal;
	color: #2e434c;
}
a {
    color: white;
    text-decoration: none;
    color: #2e434c;
}
a.btn { font-size: 14px; color: #555; font-weight: bold; line-height:18px; background: transparent url(./style/img/bg_position.gif) no-repeat scroll 0 -280px; display: inline-block; height: 38px; padding-left: 15px; margin-right:6px; cursor: pointer; width:44px;}
a.btn:hover { background-position: 0 -318px;}
a.btn:active { background-position: 0 -356px;}
a.btn span { background: #FFF url(./style/img/bg_position.gif) no-repeat scroll 100% -280px; display: inline-block; height: 18px; padding: 10px 15px 10px 0;}
a:hover.btn span { color: #1AA3D1; background-position: 100% -318px;}
a:active.btn span { color: #63C7ED; background-position: 100% -356px;}

td, th{height:30px;}
td{text-align:center;}
td a{cursor:pointer;}
th{
	background: #66a3d5;
	color: #fff;
	font-size: 16px;
	font-weight: normal;
}
td{
	font-size: 14px;
}
td.even{
	background: #f7fbff;
}
#idContainer{
	padding-top:10px;
	padding-left:30px;
	width:1000px;
	margin: 0 auto;
}
#idUserContainer{
	margin-top:10px;
	margin-bottom:20px;
	margin-right:50px;
	float:right;
}
#idPager{
	margin-left:200px;
	margin-top:20px;
	float:left;
}
#idLists{
	float:left;
}
#idNav{
	float:left;
	margin-left:10px;
	margin-top:20px;
}
#idNotice{
	float:left;
	margin-top:20px;
}

</style>
</head>

<body scroll="no">
<div id="idContainer">
	<div id="idUserContainer">
		<?php if ( $output['user'] ) { ?>
			<span>当前用户：<?php echo $output['user']; ?></span>
		<?php } else { ?>
		<form id="idLoginForm" enctype="multipart/form-data" method="post">
			<label>用户名：<input type="text" name="user" id="idUser" /></label>
			<label>密码：<input type="password" name="pass" id="idPass" /></label>
			<a href="JavaScript:void(0);" nctype="login_user" class="btn" id="submitBtn"><span>登录</span></a>
		</form>
		<?php } ?>
	</div>
	<div id="idNav">
		<a href="./index.php" class="nav_day"><span>会议室预定</span></a>
	</div>

	<div id="idLists">
		<form id="idForm" enctype="multipart/form-data" method="post">
			<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
			 <table data-sort="sortDisabled" border="1px" bordercolor="#aac4dc" cellspacing="0px" width="950px">
			  <thead>
				<tr>
					<th>预订人</th>
					<th>会议室名称</th>
					<th>开始时间</th>
					<th>结束时间</th>
					<th>操作</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
					if ( $lists = $output['lists'] ){
						foreach ( $lists as $list ) {
							$action_del = ( $output['is_admin'] || $output['user'] ==  $list['name'] ) ? '<a href="JavaScript:void(0);" nctype="del_room" tag="' . $list['id'] . '">删除</a>' : '/';

							echo '<tr>';
								echo '<td>' . $list['name'] . '</td>';
								echo '<td>' . $list['room_name'] . '</td>';
								echo '<td>' . $list['start_time'] . '</td>';
								echo '<td>' . $list['end_time'] . '</td>';
								echo '<td>' . $action_del . '</td>';
							echo '</tr>';
						}
					}
				?>
			  </tbody>
			</table>
		</form>
		<div id="idPager">
			<Script Language="JavaScript" type="text/JavaScript" src="./style/js/showPageYz.js"></Script>
			<script language="javascript">
				ShowoPage("","","页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","","上一页","下一页","","","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $output['total_num']; ?>,<?php echo $output['page_size']; ?>,4);
			</script>
		</div>
	</div>
	<div id="idNotice">
		<p>
			注：会议室预定存在冲突请联系当事人或前台协调调整。
		</p>
	</div>

</div>
<script type="text/javascript">
$(function(){
	$('a[nctype="login_user"]').click(function(){
		var user = $("#idUser").val();
		var pass = $("#idPass").val();
		if ( !user ) {
			alert("用户名不能为空！");
			return;
		} else if ( !pass ) {
			alert("密码不能为空！");
			return;
		}
        $.post("./list.php?act=login", { user: user, pass: pass },
		   function(data){
			 var msg = '';
			 switch( data ) {
				case 'null_err':
					msg = "账户名或密码传递出错！";
					break;
				case 'pass_err':
					msg = "账户名或密码错误！";
					break;
				case 'succ':
					msg = "登录成功";
					break;
				case 'fail':
					msg = "登录失败";
					break;
				default:
					msg = data;
					break;
			 }
			 if ( data != 'succ' ) alert(msg);
			 else window.location.href = "./list.php?Page=<?php echo $output['page']; ?>";
		});

	});

	$('a[nctype="del_room"]').click(function(){
		var id = $(this).attr('tag');
		if ( !id ) {
			alert("删除栏目不存在，请重新确认！");
			return;
		}
        $.post("./list.php?act=del", { id: id },
		   function(data){
			 var msg = '';
			 switch( data ) {
				case 'id_err':
					msg = "信息提交出错";
					break;
				case 'user_err':
					msg = "当前用户没有删除权限，请联系管理员";
					break;
				case 'succ':
					msg = "删除成功";
					break;
				case 'fail':
					msg = "删除失败，请确认是否有删除权限！";
					break;
				default:
					msg = data;
					break;
			 }
			 if ( data != 'succ' ) alert(msg);
			 else window.location.href = "./list.php?Page=<?php echo $output['page']; ?>";
		});
	});

	$('#idLists tr:even').find('td').addClass('even')
});
</script>
</body>
</html>