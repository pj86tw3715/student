<?php require_once('Connections/student.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_POST['delid'])) && ($_POST['delid'] != "") && (isset($_POST['delsure']))) {
  $deleteSQL = sprintf("DELETE FROM stud WHERE stud_id=%s",
                       GetSQLValueString($_POST['delid'], "int"));

  mysql_select_db($database_student, $student);
  $Result1 = mysql_query($deleteSQL, $student) or die(mysql_error());

  $deleteGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_student, $student);
$query_Recordset1 = sprintf("SELECT * FROM stud WHERE stud_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">刪除學員資料</td>
    </tr>
    <tr>
      <td>姓名</td>
      <td><?php echo $row_Recordset1['stud_name']; ?></td>
    </tr>
    <tr>
      <td>身分證號碼</td>
      <td><?php echo $row_Recordset1['stud_idno']; ?></td>
    </tr>
    <tr>
      <td>性別</td>
      <td><?php echo $row_Recordset1['stud_sex']; ?></td>
    </tr>
    <tr>
      <td>出生日期</td>
      <td><?php echo $row_Recordset1['stud_birthday']; ?></td>
    </tr>
    <tr>
      <td>學校名稱</td>
      <td><?php echo $row_Recordset1['stud_school']; ?></td>
    </tr>
    <tr>
      <td>科系</td>
      <td><?php echo $row_Recordset1['stud_major']; ?></td>
    </tr>
    <tr>
      <td>行動電話</td>
      <td><?php echo $row_Recordset1['stud_phone']; ?></td>
    </tr>
    <tr>
      <td>地址</td>
      <td><?php echo $row_Recordset1['stud_address']; ?></td>
    </tr>
    <tr>
      <td>相片</td>
      <td><img src="學員相片/<?php echo $row_Recordset1['stud_photo']; ?>" width=150 height="150"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center">確認是否要刪除嗎?
      <input type="submit" name="button" id="button" value="送出" />
      &nbsp; <input type="button" name="button2" id="button2" value="回首頁" />
      <input name="delsure" type="hidden" id="delsure" value="true" />
      <input name="delid" type="hidden" id="delid" value="<?php echo $row_Recordset1['stud_id']; ?>" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
