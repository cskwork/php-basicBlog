<?php

/* --------------DATA SOURCE OBJECT-------------*/
/**
 * Gets the root path of the project
 *
 * @return string
 */
function getRootPath()
{
    return realpath(__DIR__ . '/..');
}
/**
 * Gets the full path for the database file
 *
 * @return string
 */
function getDatabasePath()
{
    return getRootPath() . '/data/data.sqlite';
}
/**
 * Gets the DSN for the SQLite connection
 *
 * @return string
 */
function getDsn()
{
    return 'sqlite:' . getDatabasePath();
}
/**
 * Gets the PDO object for database access
 *
 * @return \PDO
 */
function getPDO()
{
    $pdo = new PDO(getDsn());

    //FK constraint enabled manually - req in sqllite
    $result = $pdo->query('PRAGMA foreign_keys = ON');
    if($result === false){
        throw new Exception('Could not turn on FK constraints');
    }

    return $pdo;
}

function redirectAndExit($script)
{
	//Get domain-relative URL
	$relativeUrl = $_SERVER['PHP_SELF'];
	$urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
	//Resirect to full Url
	$host = $_SERVER['HTTP_HOST'];
	$fullUrl = 'http://' . $host . $urlFolder . $script;
	header('Location: ' . $fullUrl);
	exit();
}

/* --------------DATA SOURCE OBJECT-------------*/


/* --------------STRING AND DATE UTIL-------------*/

/**
 * Escapes HTML so it is safe to output
 *
 * @param string $html
 * @return string
 */
function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

//Date Parsing
function convertSqlDate($sqlDate){
/* @var $date DateTime */
	$date = DateTime::createFromFormat('Y-m-d H:i:s',$sqlDate);
	return $date->format('d M Y, H:i');
}

/**
 * Converts unsafe text to safe, paragraphed, HTML
 *
 * @param string $text
 * @return string
 */
function convertNewlinesToParagraphs($text)
{
    $escaped = htmlEscape($text);
    return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
}

function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}

/* --------------STRING AND DATE UTIL-------------*/

/* --------------COMMENTS-------------*/
/**
 * Returns the number of comments for the specified post
 * @param PDO $pdo
 * @param integer $postId
 * @return integer
 */
 function countCommentsForPost(PDO $pdo, $postId){
 	//$pdo = getPDO();
 	$sql = "
 		SELECT 
 			COUNT(*) c 
 		FROM 
 			comment 
 		WHERE 
 			post_id = :post_id
 		   ";
 	$stmt = $pdo->prepare($sql);
 	$stmt->execute(
 		array('post_id'=>$postId,)
 	);
 	return (int) $stmt->fetchColumn();
 }

 /**
 * Returns all the comments for the specified post
 * @param PDO $pdo
 * @param integer $postId
 */
function getCommentsForPost(PDO $pdo, $postId)
{
    //$pdo = getPDO();
    $sql = "
        SELECT
            id, name, text, created_at, website
        FROM
            comment
        WHERE
            post_id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* --------------COMMENTS-------------*/

/* --------------LOGIN-------------*/
function tryLogin(PDO $pdo, $username, $password){
    $sql = "
        SELECT
            password 
        FROM
            user
        WHERE
            username= :username";
    $stmt = $pdo->prepare($sql);

    $stmt->execute(
        array('username' => $username,)
    );

    //Get hash from this row, use hashing lib to check.
    $hash = $stmt->fetchColumn();
    //echo $hash;


    //for admin only remove later 
    /*if('admin'== $username && 'unhashed-password' == $password){
        $success = 1;
    }else{
        $success = password_verify($password, $hash);
    }*/
    $success = password_verify($password, $hash);
    return $success;
}

/**
 * Logs the user in
 *
 * For safety, we ask PHP to regenerate the cookie, so if a user logs onto a site that a cracker
 * has prepared for him/her (e.g. on a public computer) the cracker's copy of the cookie ID will be
 * useless.
 *
 * @param string $username
 */
function login($username){
    session_regenerate_id();
    $_SESSION['logged_in_username'] = $username;
}

function isLoggedIn(){
    return isset($_SESSION['logged_in_username']);
}

/**
 * Logs the user out
 */
function logout(){
    unset($_SESSION['logged_in_username']);
}

function getAuthUser(){
    return isLoggedIn() ? $_SESSION['logged_in_username'] : null;
}


/* --------------LOGIN-------------*/

?>