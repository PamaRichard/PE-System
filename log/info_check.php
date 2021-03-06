<?php
/**
 * ___                      ___  _      _                   _
 * | _ \ __ _  _ __   __ _  | _ \(_) __ | |_   __ _  _ _  __| |
 * |  _// _` || '  \ / _` | |   /| |/ _|| ' \ / _` || '_|/ _` |
 * |_|  \__,_||_|_|_|\__,_| |_|_\|_|\__||_||_|\__,_||_|  \__,_|
 * 作者：Pama Richard - 李嘉珂
 * QQ：1249072779
 * 郵箱：pama@lfdevs.com
 * 如果遇到問題，請使用郵箱聯繫
 *
 * //======關於這個文件=======
 * 創建時間：下午2:46
 * 所屬項目名稱：PE-System
 */
$location = "../";
include "../functions.php";
include_once "verb.php";
session_start();
if (!isset($_GET['high']) or !isset($_GET['weight'])) {
    echo "false";
    return false;
} else {
    $name = $_SESSION['username'];
    $school = $_SESSION['school'];
    $high = $_GET['high'];
    $weight = $_GET['weight'];
    $choose = $_GET['choose'];
    if (!is_numeric($weight) or !is_numeric($high)) {
        into_me($name,"用户完善信息失败");
        echo "false";
        return false;
    }
    $sql = link_admin()->query("update student set high='$high', weight='$weight' ,choose_what='$choose' where name='$name' and school='$school'");
    if ($sql) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['username'] = $name;
        $_SESSION['school'] = $school;
        $_SESSION['info'] = get_info($school, $name);
        $_SESSION['who'] = "student";
        into_me($name,"用户完善信息成功");
        echo "true";
        return true;
    } else {
        into_me($name,"用户完善信息失败2");
        echo "false";
        return false;
    }

}


?>