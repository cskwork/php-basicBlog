<?php
/**
 * @var $errors string
 * @var $commentData array
 */
?>

<?php // We'll use a rule-off for now, to separate page sections ?>
<!-- Removed due to new style css -->
<!--<hr /> -->

<?php // Report any errors in a bullet-point list ?>
<?php if ($errors): ?>
	 <div class="error box comment-margin">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<h3>댓글</h3>

<form method="post" class="comment-form">
	<div>
		<label for="comment-name">
			성함:
		</label>
		<input 
		type="text" id="comment-name" name="comment-name"
		value="<?php echo htmlEscape($commentData['name']) ?>" />
	</div>
	<div>
		<label for="comment-website">
			웹사이트:
		</label>
		<input type="text" id="comment-website" name="comment-website"
		value="<?php echo htmlEscape($commentData['website']) ?>" />
	</div>
	<div>
		<label for="comment-text">
			댓글:
		</label>
		<textarea id="comment-text" name="comment-text" rows="8" cols="70"><?php echo htmlEscape($commentData['text']) ?></textarea>
	</div>

	<div>
		<button type="submit">Submit comment</button>
	</div>
</form>