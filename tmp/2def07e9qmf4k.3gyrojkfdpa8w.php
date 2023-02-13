<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href="<?= ($SCHEME.'://'.$HOST.$BASE.'/') ?>">
	<title>Fat Free Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>

  <body>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg bg-dark ">
	  <div class="container">
		<a class="navbar-brand" href="#">Fat Free Login</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		  <ul class="navbar-nav ml-auto">
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Fat Free Framework
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="https://fatfreeframework.com/3.6/home">F3 homepage</a>
				  <a class="dropdown-item" href="https://fatfreeframework.com/3.6/user-guide">User Guide</a>
				  <a class="dropdown-item" href="https://fatfreeframework.com/3.6/api-reference">API references</a>
				</div>
			  </li>
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  F3 Help
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="https://groups.google.com/forum/#!forum/f3-framework">Google Group</a>
				  <a class="dropdown-item" href="https://stackoverflow.com/questions/tagged/fat-free-framework">Stack Overflow</a>
				</div>
			  </li>
			  <?php if (isset($SESSION['logged_in']) && $SESSION['logged_in']): ?>
			   
				<li class="nav-item dropdown">				
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <?= ($SESSION['username']) ?></a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <?php if ($SESSION['user_type']==100): ?>
				<a class="dropdown-item" href="/admin/users">Show all users</a>
				
			  <?php endif; ?>
				  <a class="dropdown-item" href="/user/update"><?= ($i18n_settings) ?></a>
				  <a class="dropdown-item" href="/logout"><?= ($i18n_logout) ?></a>
				</div>
			  </li>
			  
			  <?php else: ?>
				<li class="nav-item"> 
					<a href="/login" class="nav-link"><?= ($i18n_login) ?></a>
				</li>
			  
			  <?php endif; ?>
		  </ul>
		  
		</div>
	  </div>
	</nav>

	<!-- Page Content -->
	<div class="container my-4 py-3">
