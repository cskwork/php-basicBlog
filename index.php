<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <h1>Blog title</h1>
        <p>This paragraph summarises what the blog is about.</p>

        <h2>Article 1 title</h2>
        <div>dd Mon YYYY</div>
        <p>A paragraph summarising article 1.</p>
        <p>
            <a href="#">Read more...</a>
        </p>

<!-- Changed to PHP Loop -->
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
		<?php for ($postId = 1; $postId <=3; $postId++): ?>
			<h2>Article <?php echo $postId ?>title</he>
			<div>dd Mon YYYY</div>
			<p>A paragraph summarizing article<?php echo $postId ?></p>
			<p>
				<a href="#">Read More...</a>
			</p>
		<?php endfor ?>

    </body>
</html>