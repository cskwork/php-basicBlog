<?php

function addPost(PDO $pdo, $title, $body, $userId){
	//insert
	$sql ="
	INSERT INTO 
		post 
	(title, body, user_id, created_at)
	VALUES 
	(:title, :body, :user_id, :created_at)";

	$stmt = $pdo->prepare($sql);

	if($stmt === false){
		throw new Exception('Could not prepare post insert query');
	}

	//Run query with parameters
	$result = $stmt->execute(
		array(
			'title'=>$title,
			'body' => $body,
            'user_id' => $userId,
            'created_at' => getSqlDateForNow(),
        )
    );

    if($result === false){
    	throw new Exception('Could not post insert query');
    }

    return $pdo->lastInsertId();
}