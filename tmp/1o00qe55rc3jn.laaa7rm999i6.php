

	<!-- /.container -->

	<!-- Footer -->
	<footer class="footer">
		<div class="content has-text-centered">
		  <p>Coopyright © <?= (date('Y')) ?> - Brighter Taxis Ltd</p>
		  <P>Driving you forward since 2021</P>
		</div>
	</footer>

	<?php if (isset($js_imports)): ?><?php echo $this->render($js_imports,NULL,get_defined_vars(),0); ?><?php endif; ?>
