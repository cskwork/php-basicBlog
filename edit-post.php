<?php
require_once 'lib/common.php';
require_once 'lib/edit-post.php';
require_once 'lib/view-post.php';

session_start();

//Don't let non-auth user access to screen
if(!isLoggedIn()){
	redirectAndExit('index.php');
}

//Empty Default
$title = '';
$body ='';

//Init db and get handle
$pdo = getPDO();

$postId = null;
if (isset($_GET['post_id']))
{
    $post = getPostRow($pdo, $_GET['post_id']);
    if ($post)
    {
        $postId = $_GET['post_id'];
        $title = $post['title'];
        $body = $post['body'];
    }
}

//Post operation
$errors = array();
if($_POST){
	$title = $_POST['post-title'];
	if(!$title){
		$errors[] = '제목이 없습니다.';
	}
	$body = $_POST['post-body'];
	if(!$body){
		$errors[] = '내용이 없습니다.';
	}

	if(!$errors){
		//$pdo = get PDO();
		
/*
		$userId = getAuthUserId($pdo);
		$postId = addPost(
			$pdo,
			$title,
			$body,
			$userId);
		if($postId === false){
			$errors[] = 'Post Operation Failed';
		}
*/
	// Decide if we are editing or adding
	// Replaced to have both add and
    if ($postId){
    	editPost($pdo, $title, $body, $postId);
    }else{
    	$userId = getAuthUserId($pdo);
    	$postId = addPost($pdo, $title, $body, $userId);

    	if($postId ===false){
    		$errors[] = 'Post Operation Failed';
    	}
    }


		if(!$errors){
			redirectAndExit('edit-post.php?post_id=' . $postId);
		}
	}
}
/*
}elseif(isset($_GET['post_id'])){
	$post = getPostRow($pdo, $_GET['post_id']);
	if($post){
		$title = $post['title'];
		$body = $post['body'];
	}
}
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP 블로그 | 글쓰기</title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php require 'templates/title.php' ?>

        <?php if ($errors): ?>
        	<div class="error box">
        		<ul>
        			<?php foreach ($errors as $error): ?>
        				<li>
        					<?php echo $error ?>
        				</li>
        			<?php endforeach ?>
        		</ul>
        	</div>
        <?php endif ?>

        <form method="post" class="post-form user-form">
            <div>
                <label for="post-title">제목:</label>
                <input
                    id="post-title"
                    name="post-title"
                    type="text"
                    value="<?php echo htmlEscape($title)?>"
                /> <!-- prevent html user-input -->
            </div>
            <div>
                <label for="post-body">내용:</label>
                <textarea
                    id="post-body"
                    name="post-body"
                    rows="12"
                    cols="70"
                    value="<?php echo htmlEscape($body) ?>"></textarea>
            </div>
            <div>
				<button type="submit">글쓰기</button>
			</div>
        </form>
    </body>
</html>