<!-- ADD DB CONNECTION -->
<?php
require_once 'lib/common.php';

session_start();

//Connect to db, run query, handle error
$pdo = getPDO();//PHP DATA OBJECT
$stmt = $pdo->query(
    'SELECT
        id, title, created_at, body
     FROM
        post
     ORDER BY
        created_at DESC'
);
if($stmt == false){
    throw new Exception('Problem running query');
    };

//echo $_GET['not-found'];
//FIND REASON
//$notFound = isset($_GET['not-found']);
$notFound=''
?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
         <?php require 'templates/title.php' ?>
         <?php if ($notFound): ?>
            <div style="border:1px solid #ff6666; padding: 6px;">
                Error: Cannot find requested blog post.
            </div>
        <?php endif ?>
<!-- mysqli_fetch_assoc 함수는 mysqli_query 를 통해 얻은 리절트 셋(result set)에서 레코드를 1개씩 리턴해주는 함수입니다.-->
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?> 

            <h2><?php echo htmlEscape($row['title']) ?></h2>
            <div><?php echo convertSqlDate($row['created_at']) ?></div>
            (<?php echo countCommentsForPost($row['id'])?> comments)

            <p><?php echo htmlEscape($row['body']) ?></p>
            <p>
                <a href="view-post.php?post_id=<?php echo $row['id'] ?>"
                >Read more...</a>
            </p>
            
        <?php endwhile ?> 
<!-- 1 Changed to PHP Loop -->
<!--
        <h2>Article 2 title</h2>
        <div>dd Mon YYYY</div>
        <p>A paragraph summarising article 2.</p>
        <p>
            <a href="#">Read more...</a>
        </p>

        <h2>Article 3 title</h2>
        <div>dd Mon YYYY</div>
        <p>A paragraph summarising article 2.</p>
        <p>
            <a href="#">Read more...</a>
        </p>
-->
<!-- 2 Remove Mock-up-->
   <!-- <?php for ($postId = 1; $postId <=3; $postId++): ?>
            <h2>Article <?php echo $postId ?>title</he>
            <div>dd Mon YYYY</div>
            <p>A paragraph summarizing article<?php echo $postId ?></p>
            <p>
                <a href="#">Read More...</a>
            </p>
        <?php endfor ?> -->

    </body>
</html>