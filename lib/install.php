<?php

function installBlog()
{
    // ---Get the PDO DSN string
    // Get DB , project paths
    $root = getRootPath();
    $database = getDatabasePath();
    $error = '';
    // DB exist check - security measure
    if (is_readable($database) && filesize($database) > 0)
    {
        $error = 'Please delete the existing database manually before installing it afresh';
    }
    // Create an empty file for database
    if (!$error)
    {
        $createdOk = @touch($database);
        if (!$createdOk)
        {
            $error = sprintf(
                'Could not create the database, please allow the server to create new files in \'%s\'',
                dirname($database)
            );
        }
    }
    // Grab SQL commands 
    if (!$error)
    {
        $sql = file_get_contents($root . '/data/init.sql');
        if ($sql === false)
        {
            $error = 'Cannot find SQL file';
        }
    }
    // Connect to the new database and SQL commands
    if (!$error)
    {
        $pdo = getPDO();
        $result = $pdo->exec($sql);
        if ($result === false)
        {
            $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
        }
    }
    // See how many rows we created, if any
    $count = array();
    foreach(array('post', 'comment') as $tableName)
    {
        if (!$error)
        {
            $sql = "SELECT COUNT(*) AS c FROM " . $tableName;
            $stmt = $pdo->query($sql);
            if ($stmt)
            {
                // We store each count in an associative array
                $count[$tableName] = $stmt->fetchColumn();
            }
        }
    }
    return array($count, $error);
}


/* --------------USER TABLE-------------*/

/**
 * Creates a new user in db
 *
 * @param PDO $pdo
 * @param string $username
 * @param integer $length
 * @return array Duple of (password, error)
 */
function createUser(PDO $pdo, $username, $length = 10){
    //Create random password
    //ord — Convert the first byte of a string to a value between 0 and 255
    $alphabet = range(ord('A'),ord('z'));
    $alphabetLength = count($alphabet);

    $password = '';

    for( $i=0; $i < $length; $i++){
        $letterCode = $alphabet[rand(0, $alphabetLength-1)];
        //chr — Generate a single-byte string from a number
        //.= : concatenation assignment; APPEND!
        $password .= chr($letterCode);
    }

    $error = '';

/**
 * Updates the admin user in the database
 *
 * @param PDO $pdo
 * @param string $username
 */
    $sql = "
        UPDATE user
        SET
            password = :password, created_at= :created_at, is_enabled=1
        
        WHERE
            username = :username
        ";

    $stmt = $pdo->prepare($sql);
    if($stmt === false){
         $error = 'Could not prepare the user update';
    };

    if (!$error){
        // Create a hash of the password, to make a stolen user database (nearly) worthless
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($hash === false)
        {
            $error = 'Password hashing failed';
        }
    }
    // Storing the password in plaintext, will fix that later
    // Insert user details, including hashed password
    if (!$error)
    {
        $result = $stmt->execute(
            array(
                'username'=>$username,
                'password'=>$hash,
                'created_at'=>getSqlDateForNow(),
            )
        );
        if($result === false){
            $error = 'Could not run the user creation';
        }
    }
    if ($error)
    {
        $password = '';
    }

    return array($password, $error);
}


/* --------------USER TABLE-------------*/
?>
