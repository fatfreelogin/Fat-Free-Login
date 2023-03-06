<!DOCTYPE html>
<html lang="en">
  
  <?php echo $this->render('head.htm',NULL,get_defined_vars(),0); ?>

  <body>
    <?php echo $this->render('header.htm',NULL,get_defined_vars(),0); ?>
    <?php echo $this->render($view,NULL,get_defined_vars(),0); ?>
    <?php echo $this->render('footer.htm',NULL,get_defined_vars(),0); ?>
  </body>
</html>