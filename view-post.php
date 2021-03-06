<?php

require_once 'lib/common.php';
require_once 'lib/view-post.php';

session_start();

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
    redirectAndExit("index.php?not-found=1");
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
		redirectAndExit('view-post.php?post_id=' . $postId);#POSTID~!!!
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
/*$commentData = array(
	        'name' => '',
	        'website' => '',
	        'text' => '',
	    );
*/
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP 블로그 |
		<?php echo htmlEscape($row['title'])?>
	</title>
	<?php require 'templates/head.php' ?>
</head>
<body>
	<?php require 'templates/title.php' ?>
	<div class="post">
		<h2>
			<?php echo htmlEscape($row['title']) ?>
		</h2>
		<div class="date">
			<?php echo convertSqlDate($row['created_at']) ?>
		</div>
		<?php // This is already escaped, so doesn't need further escaping ?>
	    <?php echo convertNewlinesToParagraphs($row['body']) ?>
	</div>
	<br>
	<!-- COMMENT -->
	<div class="comment-list">
		<h3><?php countCommentsForPost($pdo, $postId) ?> 댓글</h3>
		<?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
			<?php //Comment split ?>
			
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
	</div>
	<?php require 'templates/comment-form.php' ?>
</body>
</html>