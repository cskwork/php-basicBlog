<!-- ADD DB CONNECTION -->
<?php
//Path to database - connect sqllite/pdo connection
$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;
//Check path
//echo $dsn;

//Connect to db, run query, handle error
$pdo = new PDO($dsn); //PHP DATA OBJECT
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

?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <h1>Blog title</h1>
        <p>This paragraph summarises what the blog is about.</p>

        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?> 
            <h2><?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?></h2>
            <?php echo $row['created_at'] ?>
            <p><?php echo htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?></p>
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