

	<!-- /.container -->

	<!-- Footer -->
	<footer class="footer footer-center p-4 bg-base-300 text-base-content">
		<div>
		  <p>Copyright © <?= (date('Y')) ?> - Brighter Taxis Ltd</p>
		  <P>Driving you forward since 2021</P>
		</div>
	</footer>

	<?php if (isset($js_imports)): ?><?php echo $this->render($js_imports,NULL,get_defined_vars(),0); ?><?php endif; ?>
	</body>

</html>
