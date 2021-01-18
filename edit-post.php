<!--
문제해결: 
 - Separation of concern 
 - 세션 유지 (반복적인 로그인 X)
 - 권한이 없는 사용자는 메인 페이지로 이동
 - 폼 초기화.
 - db 연결에 필요한 오브젝트 초기화
 - 폼 고유 id로 불러온 글 변수에 설정
 - 제목, 내용 등이 없는 경우 예외 처리 
 - 기존에 폼 고유 ID가 있는(즉 이미 있는 글이면) 수정함수 실행 없으면 추가함수 실행 
 - 에러가 있으면 에러 페이지로 리다이렉트 
 - 글 작성 양식 html 구현 
-->

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
    //echo $post['body'];
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
        redirectAndExit('index.php');
    }else{
    	$userId = getAuthUserId($pdo);
    	$postId = addPost($pdo, $title, $body, $userId);

    	if($postId ===false){
    		$errors[] = 'Post Operation Failed';
    	}
        //글 쓰고 메인 페이지로 이동
        redirectAndExit('index.php');
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
        <?php require 'templates/top-menu.php' ?>

        <?php if (isset($_GET['post_id'])):?>
            <h1>글수정</h1>
        <?php else: ?>
            <h1>글쓰기</h1>
        <?php endif ?>

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
                    ><?php echo htmlEscape($body)?></textarea>
            </div>
            <div>
				<button type="submit">글쓰기</button>
			    <a href="index.php">취소</a>
            </div>
        </form>
    </body>
</html>