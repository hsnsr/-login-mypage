<?php
    mb_internal_encoding("utf8");
    session_start();

    if(empty($_SESSION['id'])){

        try{
            $pdo=new PDO("mysql:dbname=lesson01;host=localhost;","root","");
        }catch(PDOException $e){
            die("<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセスが出来ません。<br>しばらくしてから再度ログインをしてください。</p>
            <a href='http://localhost/PHP中級演習/login_mypage/login.php'>ログイン画面へ</a>");
        }

        $stmt=$pdo->prepare("select * from login_mypage where mail=? && password=?");

        $stmt->bindValue(1,$_POST["mail"]);
        $stmt->bindValue(2,$_POST["password"]);

        $stmt->execute();
        $pdo=NULL;

        while($row=$stmt->fetch()){
            $_SESSION['id']=$row["id"];
            $_SESSION['name']=$row["name"];
            $_SESSION['mail']=$row["mail"];
            $_SESSION['picture']=$row["picture"];
            $_SESSION['password']=$row["password"];
            $_SESSION['comments']=$row["comments"];
        }

        //sessionにデータを格納出来ていなければリダイレクトでエラーへ飛ばす。
        if(empty($_SESSION['id'])){
        header("Location:login_error.php");
        }

        //「ログイン状態を保持」する場合、postされたlogin_keepの値をsessionに保存する。
        if(!empty($_POST['login_keep'])){
            $_SESSION['login_keep']=$_POST['login_keep'];
        }
    }

    //ログインに成功かつログイン状態保持が有効の場合、cookieにデータを保存する。（有効期限は7日後になってる）
    //ログイン状態保持が無効の場合は、過去の時間を指定しcookieからデータを削除できる。
    if(!empty($_SESSION['id']) && !empty($_SESSION['login_keep'])){
        setcookie('mail',$_SESSION['mail'],time()+60*60*24*7);
        setcookie('password',$_SESSION['password'],time()+60*60*24*7);
        setcookie('login_keep',$_SESSION['login_keep'],time()+60*60*24*7);
    }else if(empty($_SESSION['login_keep'])){
        setcookie('mail','',time()-1);
        setcookie('password','',time()-1);
        setcookie('legin_keep','',time()-1);
    }
?>

<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>マイページ</title>
        <link rel="stylesheet" type="text/css" href="mypage.css">
    </head>

    <body>
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="logout"><a href="log_out.php">ログアウト</a></div>
        </header>

        <main>

            <h2>会員情報</h2><br>
            
            <div class="hello"><?php echo "こんにちは！".$_SESSION['name']."さん" ?></div>

            <div class="left">
                <?php echo "<img src=".$_SESSION['picture'].">" ?>
            </div>

            <div class="right">
                <div class="name">
                    <?php echo "氏名：".$_SESSION['name'] ?><br>
                </div>

                <div class="mail">
                    <?php echo "メール：".$_SESSION['mail'] ?><br>
                </div>

                <div class="password">
                    <?php echo "パスワード：".$_SESSION['password'] ?><br>
                </div>
            </div>

            <div class="comments">
                <?php echo $_SESSION['comments'] ?>
            </div>

            <form action="mypage_hensyu.php" method="post" class="form_center">
                <input type="hidden" value="<?php echo rand(1,10); ?>" name="from_mypage">
                    <input type="submit" class="button" size="35" value="編集する">
            </form>
        </main>

        <footer>
            ©2018 InterNous.inc. All rights reserved
        </footer>

    </body>

</html>