<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if(isset($_POST['timeout'])){
    $timeout = $_POST['timeout'];
}else{
    $timeout = 10;
}

if(isset($_POST['host'])){
    $host = $_POST['host'];
}else{
    $host = "smtp.example.com";
}

if(isset($_POST['port'])){
    $port = $_POST['port'];
}else{
    $port = 587;
}

if(isset($_POST['secure'])){
    $secure = $_POST['secure'];
}else{
    $secure = "tls";
}

if(isset($_POST['auth'])){
    $auth = $_POST['auth'];
}else{
    $auth = "true";
}

if(isset($_POST['user'])){
    $user = $_POST['user'];
}else{
    $user = "email@example.com";
}

if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
}else{
    $pass = "replace_password";
}

if(isset($_POST['process'])){

    $mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

    try {
        $mail->SMTPDebug = 4;
        $mail->Debugoutput = "html";
        $mail->IsSMTP();
        $mail->Timeout = "".$timeout."";
        if($auth == "true"){
            $mail->SMTPAuth = true;
        }
        if(!empty($secure)){
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "".$secure."";
        }
        if(!empty($port)){
            $mail->Port = "".$port."";
        }
        $mail->Host = "".$host."";
        $mail->Username = "".$user."";
        $mail->Password = "".$pass."";
        $mail->From = "".$user."";
        $mail->FromName = "TEST SCRIPT";
        $mail->Subject = "Test Email";
        $mail->AltBody = "testing text";
        $mail->MsgHTML("<strong><i>testing html</i></strong>");
        $mail->AddAddress("person@example.com", "Person Name");
        $mail->IsHTML(true);

        echo "Timeout is: ".$mail->Timeout."s<br /><br />";

        $mail->Send();
        echo "Sent.<br /><br />";
    } catch (Exception $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (\Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
    }
}
?>

<br /><br />
<div style="clear:both;"></div>

<form id="form1" name="form1" method="post" action="">
    <input type="hidden" name="process" value="1" />
    timeout:<input type="text" name="timeout" value="<?=$timeout;?>" style="width:400px" /><br />
    host:<input type="text" name="host" value="<?=$host;?>" style="width:400px" /><br />
    port:<input type="text" name="port" value="<?=$port;?>" style="width:400px" /><br />
    secure:<input type="text" name="secure" value="<?=$secure;?>" style="width:400px" /><br />
    authenticate:<input type="radio" name="auth" value="true" <?php if($auth == "true"){echo "checked";}?> /> Yes | <input type="radio" name="auth" value="false" <?php if($auth == "false"){echo "checked";}?> /> No <br />
    user:<input type="text" name="user" value="<?=$user;?>" style="width:400px" /><br />
    pass:<input type="text" name="pass" value="<?=$pass;?>" style="width:400px" /><br />
    <br />
    <input type="submit" name="Send" id="send" value="Send" />
</form>


