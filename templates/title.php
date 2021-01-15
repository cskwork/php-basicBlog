<div style="float: right;">
	<?php if(isLoggedIn()):?>
	안녕 <?php echo htmlEscape(getAuthUser()) ?>.
		<a href="logout.php">로그아웃</a>
	<?php else: ?>
		<a href="login.php">로그인</a>
	<?php endif ?>
</div>

<a href="index.php">
	<h1>블로그</h1>
</a>
