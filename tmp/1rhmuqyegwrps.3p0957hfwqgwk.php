<div class="container py-5">
	<div class="row">
		<div class="col-md-6 mx-auto">

			<h1><?= ($i18n_create_user) ?></h1>
			<?php if (isset($message)): ?>
				
				<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
				<?= ($this->raw($message))."
" ?>
				</div>
				
			<?php endif; ?>

			<form action="" method="post" class="">

				  <div class="form-group">
					<label class="control-label" for="username"><?= ($i18n_username) ?></label>
					<div class="form-field"><input type="text" class="form-control input-lg" name="username" id="username" required />
				  </div></div>

				  <div class="form-group">
					<label class="control-label" for="email"><?= ($i18n_email) ?></label>
					<div class="form-field"><input type="email" class="form-control input-lg" data-validation="email" value="<?= ($POST['email']) ?>" name="email" required />
					</div>
				  </div>
				  
				  <div class="form-group">
					<label class="control-label" for="password"><?= ($i18n_password) ?></label>
					<div class="form-field"><input type="password" class="form-control input-lg" data-validation="length"  data-validation-length="min8" name="password" id="password" required />
					</div>
				  </div>
				  
				  <div class="form-group">
					<label class="control-label" for="confirm"><?= ($i18n_password_conf) ?></label>
					<div class="form-field"><input type="password" class="form-control input-lg" name="confirm" id="confirm" required />
					</div>
				  </div>
				  
				  <div class="form-group">
					<label class="control-label checkbox-inline" for="conditions"> 
					<div class="form-field"><input value=1 type="checkbox" name="conditions" id="conditions" required /><?= ($this->raw($i18n_agree_conditions)) ?></label>
					</div>
				  </div>
				  
				<input type="hidden" name="session_csrf" value="<?= ($CSRF) ?>" />

				<div class="col-lg-xs text-center"><input class="btn btn-primary" value="<?= ($i18n_submit) ?>" name="create" id="create" type="submit"></div>

			</form>
		</div>
	</div>
</div>