<div class="">
  <p><?= ($BASE) ?></p>
	<form action="<?= ($BASE.'/login') ?>" method="post" class="">

		<input type="text" class="form-control" placeholder="Email" name="username" id="username" required autofocus>
		<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
		<input type="hidden" name="login" value="login" />
		<input type="text" name="session_csrf" value="<?= ($CSRF) ?>" />
		<button class="btn" type="submit">Login</button>
	</form>
</div>