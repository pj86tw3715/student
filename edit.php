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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE stud SET stud_name=%s, stud_idno=%s, stud_sex=%s, stud_birthday=%s, stud_school=%s, stud_major=%s, stud_phone=%s, stud_address=%s WHERE stud_id=%s",
                       GetSQLValueString($_POST['stud_name'], "text"),
                       GetSQLValueString($_POST['stud_idno'], "text"),
                       GetSQLValueString($_POST['stud_sex'], "text"),
                       GetSQLValueString($_POST['stud_birthday'], "date"),
                       GetSQLValueString($_POST['stud_school'], "text"),
                       GetSQLValueString($_POST['stud_major'], "text"),
                       GetSQLValueString($_POST['stud_phone'], "text"),
                       GetSQLValueString($_POST['stud_address'], "text"),
                       GetSQLValueString($_POST['stud_id'], "int"));

  mysql_select_db($database_student, $student);
  $Result1 = mysql_query($updateSQL, $student) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" align="center">學生資料管理系統-資料修改</td>
    </tr>
    <tr>
      <td>學號</td>
      <td><input name="stud_id" type="hidden" id="stud_id" value="<?php echo $row_Recordset1['stud_id']; ?>" /></td>
    </tr>
    <tr>
      <td>姓名</td>
      <td><label for="stud_name"></label>
      <input name="stud_name" type="text" id="stud_name" value="<?php echo $row_Recordset1['stud_name']; ?>" /></td>
    </tr>
    <tr>
      <td>身分證號碼</td>
      <td><label for="stud_idno"></label>
      <input name="stud_idno" type="text" id="stud_idno" value="<?php echo $row_Recordset1['stud_idno']; ?>" /></td>
    </tr>
    <tr>
      <td>性別</td>
      <td><input <?php if (!(strcmp($row_Recordset1['stud_sex'],"M"))) {echo "checked=\"checked\"";} ?>   name="stud_sex" type="radio" id="radio" value="M" checked="checked" />
        <label for="stud_sex"></label>
        <label for="stud_sex">男
          <input <?php if (!(strcmp($row_Recordset1['stud_sex'],"F"))) {echo "checked=\"checked\"";} ?>    type="radio" name="stud_sex" id="radio2" value="F" />
女</label></td>
    </tr>
    <tr>
      <td>出生日期</td>
      <td><label for="stud_birthday"></label>
      <input name="stud_birthday" type="text" id="stud_birthday" value="<?php echo $row_Recordset1['stud_birthday']; ?>" /></td>
    </tr>
    <tr>
      <td>學校名稱</td>
      <td><label for="stud_school"></label>
      <input name="stud_school" type="text" id="stud_school" value="<?php echo $row_Recordset1['stud_school']; ?>" /></td>
    </tr>
    <tr>
      <td>科系</td>
      <td><label for="stud_major"></label>
      <input name="stud_major" type="text" id="stud_major" value="<?php echo $row_Recordset1['stud_major']; ?>" /></td>
    </tr>
    <tr>
      <td>行動電話</td>
      <td><label for="stud_phone"></label>
      <input name="stud_phone" type="text" id="stud_phone" value="<?php echo $row_Recordset1['stud_phone']; ?>" /></td>
    </tr>
    <tr>
      <td>地址</td>
      <td><label for="stud_address"></label>
      <input name="stud_address" type="text" id="stud_address" value="<?php echo $row_Recordset1['stud_address']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="送出" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
