<?php

require_once 'lib/common.php';
require_once 'lib/view-post.php';

//GET post ID
if(isset($_GET['post_id'])){
	$postId = $_GET['post_id'];
}else{
	//always have post ID defined
	$postId = 0;
}

$pdo = getPDO();
$row = getPostRow($pdo, $postId);

// If the post does not exist, let's deal with that here

if (!$row)
{
    redirectAndExit('index.php?not-found=1');
}

//Check ERROR
$errors = null;
//echo $_POST['comment-name'];
if($_POST)
{
	//echo $_POST['comment-name'];
	$commentData = array(
		'name'=>$_POST['comment-name'],
		'website'=>$_POST['comment-website'],
		'text'=>$_POST['comment-text'],
	);
	$errors = addCommentToPost(
		$pdo,
		$postId,
		$commentData
	);

	//If no error redirect to self
	if(!$errors)
	{
		redirectAndExit('view-post.php?post_id=' . $post_id);
	}
}
else
{
	    $commentData = array(
	        'name' => '',
	        'website' => '',
	        'text' => '',
	    );
}

//NO LONGER NEEDED
//Swap CR for para. breaks.
//$bodyText = htmlEscape($row['body']);
//echo $bodyText;
//Make line break for php (\n doesn't work)
//$paraText = str_replace("\n", "</p><p>", $bodyText);

//INIT COMMENTDATA (null issue)
$commentData = array(
	        'name' => '',
	        'website' => '',
	        'text' => '',
	    );

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
	<?php // This is already escaped, so doesn't need further escaping ?>
    <?php echo convertNewlinesToParagraphs($row['body']) ?>
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
				<?php // This is already escaped ?>
                <?php echo convertNewlinesToParagraphs($comment['text']) ?>
			</div>
		</div>
	<?php endforeach ?>
	<?php require 'templates/comment-form.php' ?>
</body>
</html>