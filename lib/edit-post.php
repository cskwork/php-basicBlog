<!--
문제해결: 
 - Separation of concern 
 - 세션 유지 (반복적인 로그인 X)
 - 모든 글 가져와서 출력 
-->

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

function editPost(PDO $pdo, $title, $body, $postId){
	//insert
	$sql ="
	UPDATE 
		post 
	SET 
		title = :title, 
		body = :body
	WHERE
		id = :post_id";

	$stmt = $pdo->prepare($sql);

	if($stmt === false){
		throw new Exception('Could not prepare post update query');
	}

	//Run query with parameters
	$result = $stmt->execute(
		array(
			'title'=>$title,
			'body' => $body,
            'post_id' => $postId,
        )
    );

    if($result === false){
    	throw new Exception('Could not post update query');
    }

    return true;
}


?>