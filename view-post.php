<?php

//Connect to DB
$root = __DIR__;
$db = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $db ; //datasourcename with host,port,dbname

//GET post ID
if(isset($_GET['post_id'])){
	$postId = $_GET['post_id'];
}else{
	//always have post ID defined
	$postId = 0;
}

$pdo = new PDO($dsn);
$stmt = $pdo->prepare(
	'SELECT
		title, created_at, body
	FROM 
		post 
	WHERE 
		id=:id'
	);

if($stmt === false){
	throw new Exception('Problem preparing query');
}
$result = $stmt -> execute(
	//GET postId
	array('id' =>$postId, )
	//array('id' =>1, )
);

if($result === false){
	throw new Exception('Problem running query');
}

//Get row
$row = $stmt -> fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Blog App |
		<?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8')?>
	</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<h1>Blog title</h1>


	<h2>
		<?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
	</h2>
	<div>
		<?php echo $row['created_at']?>
	</div>
	<p>
		<?php echo htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?>
	</p>

</body>
</html>