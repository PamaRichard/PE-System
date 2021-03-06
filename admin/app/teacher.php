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
 * 創建時間：下午9:07
 * 所屬項目名稱：PE-System
 */

session_start();
$location = "../../";
$title = "教师管理";
include_once "../../functions.php";
$school = $_SESSION['info']['school'];
$grade = $_SESSION['info']['grade'];


if (isset($_GET["c"]) and $_GET['c'] == "del") {
    $names = $_GET['teacher'];
    $id = link_admin()->query("delete from teacher where school='$school' and grade='$grade' and name='$names'");
    if ($id) {
        message("删除成功!", "top", "2000");
        echo "<script>setTimeout('history.go(-2)',1000)</script>";
    } else {
        message("删除失败!", "top", "2000");
        echo "<script>setTimeout('history.go(-2)',1000)</script>";
    }
}

if (isset($_GET['c']) and $_GET['c'] == "new_teacher") {
    $name=$_GET['name'];
    $class=$_GET['class'];
    $school=$_SESSION['info']['school'];
    $grade=$_SESSION['info']['grade'];
    $num=link_admin()->query("select * from teacher where school='$school' and grade='$grade' and class='$class'")->num_rows;
    if ($num>0){
        echo "class";
        return false;
    }
    $pwd="12345678";
    $pwd=md5($pwd);
    $uid=rand(100000,999999);
    $sql=link_admin()->query("insert into teacher (uid,name, pwd, school, grade, class)values ('$uid','$name','$pwd','$school','$grade','$class')");
    if ($sql){
        echo "true";
        return true;
    }else{
        echo "false";
        return false;
    }
}

?>


<button class='mdui-btn mdui-color-theme-accent mdui-ripple' onclick="new_teacher()">添加</button>
<script>
    function new_teacher(){
        mdui.confirm('您确定添加一个教师吗?', function () {
            var ur = window.location.href.replace("#mdui-dialog", "");
            mdui.alert(ur);
            window.location.href = ur + "&c=newteacher";
        });
    }
</script>
<div class="mdui-table-fluid">
    <table class="mdui-table mdui-table-hoverable">
        <?php
        echo " <thead>
        <tr>
            <th>UID</th>
            <th>姓名</th>
            <th>班级</th>
            <th>密码</th>
            <th>登录次数</th>
            <th>是否登录过</th>
            <th>操作</th>
        </tr>
        </thead>";
        echo "<tbody>";
        $teacher = link_admin()->query("select * from teacher where school='$school' and grade='$grade'");
        foreach ($teacher as $row) {
            if ($row['first_time_login'] == 0) {
                $first = "否";
            } else {
                $first = "是";
            }
            echo "<tr>";
            echo "<td>" . $row['uid'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['class'] . "班</td>";
            echo "<td>".$row['pwd']."</td>";
            echo "<td>" . $row['login_time'] . "</td>";
            echo "<td>" . $first . "</td>";
            $name = $row['name'];
            $class=$row['class'];
            echo "<td><button class='mdui-btn mdui-color-theme-accent mdui-ripple' onclick=\"re('$name','$class')\">修改</button><button class='mdui-btn mdui-color-theme mdui-ripple' onclick=\"";
            ?>funs('<? echo $name; ?>');
            <?php echo "\">删除</button> </td>";
        }

        echo "</tbody>";

        ?>

    </table>
</div>
<?php
if (isset($_GET['teacher'])) {
    $name = $_GET['teacher'];
    $infoes = link_admin()->query("select * from teacher where school='$school' and grade='$grade' and name='$name'")->fetch_array();
}


?>
<div class="mdui-dialog mdui-color-theme" id="re">
    <div class="mdui-container mdui-color-white mdui-dialog-content">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">account_box</i>
            <label class="mdui-textfield-label">姓名</label>
            <input class="mdui-textfield-input" type="text" value="<?php echo $infoes['name']; ?>" required
                   name="username" id="username"/>
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">class</i>
            <label class="mdui-textfield-label">班级</label>
            <input class="mdui-textfield-input" type="text" value="<?php echo $infoes['class']; ?>" required
                   name="classes" id="classes"/>
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">lock</i>
            <label class="mdui-textfield-label">密码</label>
            <input class="mdui-textfield-input" type="text"  required
                   name="pwd" id="pwd"/>
        </div>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" id="submit" onclick="que()">确定</button>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="inst.close();history.go(-1);">取消</button>

    </div>
</div>
<div class="mdui-dialog mdui-color-theme" id="newteacher">
    <div class="mdui-container mdui-color-white mdui-dialog-content">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">account_box</i>
            <label class="mdui-textfield-label">姓名</label>
            <input class="mdui-textfield-input" type="text"  required
                   name="teacher_name" id="teacher_name"/>
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">
            <i class="mdui-icon material-icons">class</i>
            <label class="mdui-textfield-label">班级</label>
            <input class="mdui-textfield-input" type="text" required
                   name="teacher_class" id="teacher_class"/>
        </div>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" id="submit2" onclick="new_teacher_que()">确定</button>
        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="teacher.close();history.go(-1);">取消</button>

    </div>
</div>

<script>
    function check() {
        var clases = document.getElementById("class").value;
        window.location.href = "./index.php?t=teacher&class=" + clases;
    }

    function funs(teacher) {
        mdui.confirm('您确定删除这个教师吗?', function () {
            var urls = window.location.href.replace("#mdui-dialog", "");
            window.location.href = urls + "&c=del&teacher=" + teacher;
        });
    }



    function re(teacher,classes) {
        mdui.confirm('您确定修改这个教师的信息吗?', function () {
            var urls = window.location.href.replace("#mdui-dialog","");
            setTimeout(function () {
                window.location.href = urls+"&c=re&teacher="+teacher+"&reclass="+classes;
            },500);

        });
    }
    function new_teacher_que() {
        var username = $("#teacher_name").val();
        var classes = $("#teacher_class").val();
        $("#submit2").attr("disabled", "true");
        document.getElementById("submit2").innerHTML = "添加中...";
        $.ajax({
            type: "GET",
            url: "app/teacher.php",
            data: "c=new_teacher&name=" + username + "&class=" + classes,
            success: function (data) {
                if (data.indexOf("服务端出现错误") != -1) {
                    document.write("<h1>" + data + "</h1>");
                }
                if (data == "true") {
                    mdui.snackbar({
                        closeOnOutsideClick: false,
                        timeout: "2000",
                        message: '添加成功!',
                        position: 'top'
                    });
                    document.getElementById("submit2").innerHTML = "添加成功!";
                    setTimeout("inst.close()", 2000);
                    setTimeout("history.go(-1)", 3000);
                }if(data == "class") {
                    mdui.snackbar({
                        closeOnOutsideClick: false,
                        timeout: "2000",
                        message: '该班级已经存在教师!',
                        position: 'top'
                    });
                    document.getElementById("submit2").innerHTML = "添加失败!";
                    setTimeout("window.location.reload()", 3000);
                }if (data == 'false'){
                    mdui.snackbar({
                        closeOnOutsideClick: false,
                        timeout: "2000",
                        message: '添加失败!正在重载!',
                        position: 'top'
                    });
                    document.getElementById("submit2").innerHTML = "添加失败!";
                    setTimeout("window.location.reload()", 3000);
                }
            }
        })

    }
    function que() {
        var username = $("#username").val();
        var classes = $("#classes").val();
        var pwd = $("#pwd").val();
        $("#submit").attr("disabled", "true");
        document.getElementById("submit").innerHTML = "修改中...";
        $.ajax({
            type: "GET",
            url: "app/teacher_check.php",
            data: "rename=<?echo $_GET['teacher']?>&reclass=<? echo $_GET['reclass']?>&name=" + username + "&class=" + classes+"pwd="+pwd,
            success: function (data) {
                if (data.indexOf("服务端出现错误") != -1) {
                    document.write("<h1>" + data + "</h1>");
                }
                if (data == "true") {
                    mdui.snackbar({
                        closeOnOutsideClick: false,
                        timeout: "2000",
                        message: '修改成功!',
                        position: 'top'
                    });
                    document.getElementById("submit").innerHTML = "修改成功!";
                    setTimeout("inst.close()", 2000);
                    setTimeout("history.go(-1)", 3000);
                }else{
                    mdui.snackbar({
                        closeOnOutsideClick: false,
                        timeout: "2000",
                        message: '修改失败!',
                        position: 'top'
                    });
                    document.getElementById("submit").innerHTML = "修改失败!";
                    setTimeout("window.location.reload()", 3000);
                }
            }
        })

    }
</script>

<?php
if (isset($_GET['c']) and $_GET['c'] == "re") {
    echo "<script>
var inst = new mdui.Dialog('#re',{
    history:false,
    modal:true
});
  inst.open();
</script>
";
}
if (isset($_GET['c']) and $_GET['c'] == "newteacher") {
    echo "<script>
var teacher = new mdui.Dialog('#newteacher',{
    history:false,
    modal:true
});
  teacher.open();
</script>
";
}
?>




