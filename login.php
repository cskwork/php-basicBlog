<?php
require_once 'lib/common.php';
// We need to test for a minimum version of PHP, because earlier versions have bugs that affect security
if (version_compare(PHP_VERSION, '5.3.7') < 0)
{
    throw new Exception(
        'This system needs PHP 5.3.7 or later'
    );
}

session_start();

//로그인 됐으면 메인페이지로 이동
if(isLoggedIn()){
    redirectAndExit('index.php');
}

//Handle Login Submit
$username = '';
if($_POST){
    //Init db
    $pdo = getPDO();
    //Direct only pw is correct 
    $username = $_POST['username'];
    $ok = tryLogin($pdo, $username, $_POST['password']);
    //$ok = 1;
    if($ok){
        login($username);
        redirectAndExit('index.php');
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            PHP 블로그 | Login
        </title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php require 'templates/title.php' ?>
         <?php // If we have a username, then the user got something wrong, so let's have an error ?>
        <?php if ($username): ?>
            <div class="error box">
                The username or password is incorrect, try again
            </div>
        <?php endif ?>

        <p>로그인:</p>
        <form
            method="post"
        >
            <p>
                사용자ID:
                <input type="text" name="username" 
                value="<?php echo htmlEscape($username) ?>">
            </p>
            <p>
                암호:
                <input type="password" name="password" />
            </p>
            <input type="submit" name="submit" value="로그인" />
        </form>
    </body>
</html>