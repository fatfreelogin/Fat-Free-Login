<!DOCTYPE html>
<html lang="en">
  
  <?php echo $this->render('head.htm',NULL,get_defined_vars(),0); ?>

  <body>
    <div id="wrapper"> <!-- @vue:mounted="mounted">-->
      <?php echo $this->render('nav.htm',NULL,get_defined_vars(),0); ?>
      <?php echo $this->render('header.htm',NULL,get_defined_vars(),0); ?>
      <?php echo $this->render($view,NULL,get_defined_vars(),0); ?>
      
    </div>
    <?php echo $this->render('footer.htm',NULL,get_defined_vars(),0); ?>
    <script src="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/js/petite.js"></script>
  </body>
</html>