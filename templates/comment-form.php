<?php
/**
 * @var $errors string
 * @var $commentData array
 */
?>

<?php // We'll use a rule-off for now, to separate page sections ?>
<hr />
<?php // Report any errors in a bullet-point list ?>
<?php if ($errors): ?>
	<div style="border: 1px solid #ff6666; padding: 6px;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<h3>댓글</h3>

<form method="post">
	<p>
		<label for="comment-name">
			성함:
		</label>
		<input 
		style="margin-left: 2em" type="text" id="comment-name" name="comment-name"
		value="<?php echo htmlEscape($commentData['name']) ?>" />
	</p>
	<p>
		<label for="comment-website">
			웹사이트:
		</label>
		<input style="margin-left: 1em" type="text" id="comment-website" name="comment-website"
		value="<?php echo htmlEscape($commentData['website']) ?>" />
	</p>
	<p>
		<label for="comment-text">
			댓글:
		</label>
		<textarea id="comment-text" name="comment-text" rows="8" cols="70"><?php echo htmlEscape($commentData['text']) ?></textarea>
	</p>
	<input type="submit" value="Submit comment">
</form>