<?php
    mb_internal_encoding("utf8");
    session_start();

    //mypage_phpからの導線以外は、login_error.phpへリダイレクト
    if(empty($_POST['from_mypage'])){
        header("Location:login_error.php");
    }

?>

<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>登録情報編集</title>
        <link rel="stylesheet" type="text/css" href="mypage_hensyu.css">
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

            <form action="mypage_update.php" method="post">
                <div class="right">
                    <div class="name">
                        <?php echo "氏名：<input type='text' name='name' value='".$_SESSION['name']. "'>" ?><br>
                    </div>

                    <div class="mail">
                        <?php echo "メール：<input type='text' name='mail' value='".$_SESSION['mail']. "'>" ?><br>
                    </div>

                    <div class="password">
                        <?php echo "パスワード：<input type='text' name='password' value='".$_SESSION['password']. "'>" ?><br>
                    </div>
                </div>

                <div class="comments">
                    <?php echo "<textarea name='comments' rows='7'cols='70'>" .$_SESSION['comments']. "</textarea>" ?><br>
                </div>

                <div class="form_center">
                    <input type="submit" class="button" size="35" value="この内容に変更する">
                </div>

            </form>
        </main>

        <footer>
            ©2018 InterNous.inc. All rights reserved
        </footer>

    </body>

</html>