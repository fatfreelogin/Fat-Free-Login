<?php echo $this->render('header.htm',NULL,get_defined_vars(),0); ?>
<div class="container py-5">
	<div class="row">
		<div class="col-12">
		<h1><?= ($i18n_errorpage_header) ?></h1>

<?php switch ($ERROR['code']): ?><?php case '401': ?>
		<p><?= ($i18n_401) ?></p>
		<p><a href="/login">Log in</a></p>
	<?php if (TRUE) break; ?><?php case '403': ?>
		<p><?= ($i18n_403) ?></p>
	<?php if (TRUE) break; ?><?php case '404': ?>
		<p><?= ($i18n_404) ?></p>
	<?php if (TRUE) break; ?><?php case '405': ?>
		<p><?= ($i18n_405) ?></p>
	<?php if (TRUE) break; ?><?php case '500': ?>
		<p><?= ($i18n_500) ?></p>
	<?php if (TRUE) break; ?><?php default: ?>
		<p><?= ($i18n_othererror) ?></p>
	<?php break; ?><?php endswitch; ?>




		</div>
	</div>
</div>

<?php echo $this->render('footer.htm',NULL,get_defined_vars(),0); ?>