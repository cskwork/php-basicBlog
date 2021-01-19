<?php
require_once 'lib/common.php';
require_once 'lib/list-posts.php';

session_start();

// Don't let non-auth users see this screen
if (!isLoggedIn())
{
    redirectAndExit('index.php');
}

if($_POST){
	$deleteResponse = $_POST['delete-post'];
	if($deleteResponse){
		$keys = array_keys($deleteResponse);
		$deletePostId = $keys[0];
		if($deletePostId){
			deletePost(getPDO(), $deletePostId);
			redirectAndExit('list-posts.php');
		}
	}
}

// Connect to the database, run a query
$pdo = getPDO();
$posts = getAllPosts($pdo);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application | Blog posts</title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php require 'templates/top-menu.php' ?>
        <h1>글 목록</h1>
        <p>현재 글 <?php echo count($posts) ?></p>
        <form method="post">
            <table id="post-list">
                <tbody>
 					<?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <?php echo htmlEscape($post['title']) ?>
                            </td>
                            <td>
                                <?php echo convertSqlDate($post['created_at']) ?>
                            </td>
                            <td>
                                <a href="edit-post.php?post_id=<?php echo $post['id']?>">Edit</a>
                            </td>
                            <td>
                                <input
                                    type="submit"
                                    name="delete-post[<?php echo $post['id']?>]"
                                    value="Delete"
                                />
                            </td>
                        </tr>
                    <?php endforeach ?>

                	<!-- Replace Mock Data with real data-->
                	<!--
                    <tr>
                        <td>Title of the first post</td>
                        <td>
                        	dd MM YYYY h:mi
                        </td>
                        <td>
                            <a href="edit-post.php?post_id=1">Edit</a>
                        </td>
                        <td>
                            <input
                                type="submit"
                                name="post[1]"
                                value="Delete"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Title of the second post</td>
                        <td>
                        	dd MM YYYY h:mi
                        </td>
                        <td>
                            <a href="edit-post.php?post_id=2">Edit</a>
                        </td>
                        <td>
                            <input
                                type="submit"
                                name="post[2]"
                                value="Delete"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Title of the third post</td>
                        <td>
                    	<td>
                        	dd MM YYYY h:mi
                        </td>
                            <a href="edit-post.php?post_id=3">Edit</a>
                        </td>
                        <td>
                            <input
                                type="submit"
                                name="post[3]"
                                value="Delete"
                            />
                        </td>
                    </tr>
                -->
                </tbody>
            </table>
        </form>
    </body>
</html>