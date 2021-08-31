<?php
    require_once('include.php');
    session_start();
    $connection = mysqli_connect($root_name,$username,$password,$blanks);
?>
<html>
    <head>
        <title>
            AWARD - 主页
        </title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width,initial-scale=0.8">
    </head>
    <body>
        <?php displayMenu($_SESSION['logged']) ?>
        <div class="logintip">
            <?php
                if(!$_SESSION['logged']){
                    die("<h1>你尚未登录！请 <a href=\"login.php\">登录</a><br></h1><h3>如果你还没有账号，请<a href=\"register.php\">注册</a></h3><br>");
                }else if (mysqli_connect_errno()) {
                    die("<h1>连接数据库失败! 请联系管理员</h1>" . $connection->connect_error);
                }
                echo "Hello! ".$_SESSION['email']."</h1><br>";
                $sql = "SELECT checked FROM user WHERE email=\"".$_SESSION['email']."\"";
                $row = mysqli_fetch_array(mysqli_query($connection,$sql));
                if(!$row['checked']){
                    echo "<a href=\"quit.php\">登出</a><br>";
                    die("<h1>你的账号还未被管理员确认</h1>");
                }
            ?>
            <h2>这是一个简单的测试网站 <br> Powered By GregTao</h2>
        </div>
    </body>
</html>