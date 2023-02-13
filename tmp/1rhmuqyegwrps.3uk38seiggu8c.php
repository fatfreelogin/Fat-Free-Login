<div class="container py-5">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 mx-auto">
					<h1><?= ($i18n_login) ?> </h1>
					<?php if (isset($message)): ?>
						
						<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only"><?= ($i18n_error) ?></span>
						<?= ($this->raw($message))."
" ?>
						</div>
						
						<?php else: ?>
							<?php if (isset($SESSION['login_message'])): ?>
								
								<div class="alert alert-success" role="alert">
							  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							  <span class="sr-only"><?= ($i18n_msg) ?></span>
								<?= ($this->raw($SESSION['login_message']))."
" ?>
								</div>
								
							<?php endif; ?>
						
					<?php endif; ?>
					<form action="" method="post">
						<div class="form-group"><label class="control-label" for="last_name"><?= ($i18n_username) ?></label>
						<div class="form-field"><input class="form-control input-lg" type="text" placeholder="<?= ($i18n_username) ?>" name="username" id="username" required autofocus /></div>
						</div>

						<div class="form-group"><label class="control-label" for="last_name"><?= ($i18n_password) ?></label>
						<div class="form-field"><input class="form-control input-lg " type="password" placeholder="<?= ($i18n_password) ?>" name="password" id="password" required /></div>
						</div>
						<input type="hidden" name="login" value="login" />
						<input type="hidden" name="session_csrf" value="<?= ($CSRF) ?>" />
						<div class="col-lg-xs text-center"><input class="btn btn-primary" name="submit" value="<?= ($i18n_login) ?>" type="submit"></div>
					</form>
				</div>
			</div>
			<div class="col-lg-xs text-center py-5">
				<a class="btn btn-lg btn-primary" href="register"><?= ($i18n_register) ?></a>
				<a class="btn btn-lg btn-warning" href="lostpassword"><?= ($i18n_lostpassword) ?></a>
			</div>
		</div>
	</div>
</div>
