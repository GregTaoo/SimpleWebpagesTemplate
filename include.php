<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './phpmailer/src/Exception.php';
    require './phpmailer/src/PHPMailer.php';
    require './phpmailer/src/SMTP.php';

    $root_name = "localhost";
    $username = "1145141919810";
    $password = "1145141919810";
    $blanks = "1145141919810";

    function redirect($url, $msg){
       echo $msg."</br>";
       echo "<h3><a href=\"".$url."\">如果跳转失败，请点击这里</a></h3>";
       echo "<script language=\"javascript\">setTimeout(\"window.location.href='".$url."'\",3000)</script>";
    }

    function spamcheck($field){
        $field=filter_var($field, FILTER_SANITIZE_EMAIL);
        if(filter_var($field, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
        }
    }

    function sendemail($email,$title,$body){
        if(!spamcheck($email)){
            return false;
        }
        $mail = new PHPMailer(true);
        try {
            //服务器配置
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = 'smtp.qq.com';                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = '1145141919810';                // SMTP 用户名  即邮箱的用户名
            $mail->Password = '1145141919810';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
        
            $mail->setFrom('1145141919810', 'Auto-Service');  //发件人
            $mail->addAddress($email, 'Auto-Service');  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            //$mail->addReplyTo('xxxx@163.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
            //$mail->addCC('cc@example.com');                    //抄送
            //$mail->addBCC('bcc@example.com');                    //密送
        
            //发送附件
            // $mail->addAttachment('../xy.zip');         // 添加附件
            // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
        
            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $title;
            $mail->Body    = $body . "<br>" . date('Y-m-d H:i:s');
            $mail->AltBody = '你的浏览器不被支持，请更换浏览器或客户端';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function sendRegMsg($email,$passport){
        $root_name = "localhost";
        $username = "1145141919810";
        $password = "1145141919810";
        $blanks = "1145141919810";
        $connection = mysqli_connect($root_name,$username,$password,$blanks);
        if(mysqli_connect_errno()){
            return false;
        }else{
            $sql = "SELECT * FROM user WHERE isadmin=1";
            $result = mysqli_query($connection,$sql);
            $title = "有新的用户注册了";
            $urlsend = "http://1145141919810/v2/check.php?email=".$email."&passport=".$passport;
            $body = "<h2>点击下方链接以确保对方账户能够正常使用</h2><br><a href=\"".$urlsend."\">点这里</a>";
            $success = true;
            while($row = mysqli_fetch_array($result)){
                $success = sendemail($row['email'],$title,$body);
            }
            return $success;
        }
    }

    function displayMenu($logged){
        echo "<div class=\"topMenu\">";
        echo "<a href=\"index.php\">主页</a>";
        echo "<a href=\"".($logged?"quit.php\">登出":"login.php\">登录</a><a href=\"register.php\">注册")."</a>";
        echo "<a href=\"userset.php?action=changepassword\">密码修改</a>";
        echo "<a href=\"help.php\">帮助</a>";
        echo "<a href=\"about.php\" class=\"text\">About</a>";
        echo "</div><br><br>";
    }
?>