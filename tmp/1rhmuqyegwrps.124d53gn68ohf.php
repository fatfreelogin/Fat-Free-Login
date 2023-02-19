    <!-- <div class="flex flex-col h-screen justify-between"> -->

<main class="columns">
	<div class="column">
		<!-- <h1>Fat Free Login</h1> -->
		<?php if (isset($SESSION['logged_in']) && $SESSION['logged_in']): ?>
			
				<p>Welcome <?= ($SESSION['username']) ?>!</p>
				<p>You managed to log in succesfully. Have a look at the options in the menu item with your username. </p>
				<p>
				<a class="" href="/user/update">Go to your settings</a>
				<a class="" href="/logout">Logout</a></p>
			
			<?php else: ?>
				<?php echo $this->render('customer.htm',NULL,get_defined_vars(),0); ?>
				<!-- <p>Congratulations on installing the Fat Free Login script. You are not logged in right now. </p>
				<p><a href="/login">You can login here</a>.</p> -->
			
		<?php endif; ?>
	</div>
</main>
