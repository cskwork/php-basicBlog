<div class="top-menu">
	<div class="menu-options">
		<?php if (isLoggedIn()):?>
			<a href="list-posts.php">글 전체보기</a>
            |
			<a href="edit-post.php">글쓰기</a>
			|
			안녕 <?php echo htmlEscape(getAuthUser())?>
			<a href="logout.php">로그 아웃</a>
		<?php else: ?>
			<a href="login.php">로그인</a>
		<?php endif ?>
	</div>
</div>