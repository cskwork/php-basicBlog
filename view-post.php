<?php
require_once 'lib/common.php';


//GET post ID
if(isset($_GET['post_id'])){
	$postId = $_GET['post_id'];
}else{
	//always have post ID defined
	$postId = 0;
}

$pdo = getPDO();
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

//Swap CR for para. breaks.
$bodyText = htmlEscape($row['body']);
echo $bodyText;
//Make line break for php (\n doesn't work)
$paraText = str_replace("\n", "</p><p>", $bodyText);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog App |
		<?php echo htmlEscape($row['title'])?>
	</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
	<?php require 'templates/title.php' ?>

	<h2>
		<?php echo htmlEscape($row['title']) ?>
	</h2>
	<div>
		<?php echo convertSqlDate($row['created_at']) ?>
	</div>
	<p>
		<?php echo $paraText ?>
	</p>
	<br>
	<!-- COMMENT -->
	<h3><?php countCommentsForPost($postId) ?> comments</h3>
	<?php foreach (getCommentsForPost($postId) as $comment): ?>
		<?php //Comment split ?>
		<hr />
		<div class="comment">
			<div class="comment-meta">
				Comment from 
				<?php echo htmlEscape($comment['name']) ?>
				on
				<?php echo convertSqlDate($comment['created_at'])?>
			</div>
			<div class="comment-body">
				<?php echo htmlEscape($comment['text']) ?>
			</div>
		</div>
	<?php endforeach ?>


</body>
</html>