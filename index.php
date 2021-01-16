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

$notFound = isset($_GET['not-found']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <!--Modularize header- meta contenttype, utf-8 -->
         <?php require 'templates/head.php' ?>
    </head>
    <body>
         <?php require 'templates/title.php' ?>
         <?php if ($notFound): ?>
               <div class="error box">
                Error: Cannot find requested blog post.
            </div>
        <?php endif ?>
<!-- mysqli_fetch_assoc 함수는 mysqli_query 를 통해 얻은 리절트 셋(result set)에서 레코드를 1개씩 리턴해주는 함수입니다.-->
    <div class="post-list">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?> 
            <div class="post-synopsis">

            <h2><?php echo htmlEscape($row['title']) ?></h2>
            <div class="meta"><?php echo convertSqlDate($row['created_at']) ?></div>
            (<?php echo countCommentsForPost($pdo, $row['id'])?> 댓글)

            <p><?php echo htmlEscape($row['body']) ?></p>
            <div class="read-more">
                <a href="view-post.php?post_id=<?php echo $row['id']?>"
                >더 읽기...</a>
            </div>
        </div>
            
        <?php endwhile ?> 
    </div>
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


    </body>
</html>