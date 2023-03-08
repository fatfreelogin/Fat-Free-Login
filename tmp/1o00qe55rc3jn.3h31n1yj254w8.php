<!DOCTYPE html>
<html lang="en">
  
  <?php echo $this->render('head.htm',NULL,get_defined_vars(),0); ?>

  <body>
    <div id="wrapper" class="">
      <?php echo $this->render('nav.htm',NULL,get_defined_vars(),0); ?>
      <?php echo $this->render('header.htm',NULL,get_defined_vars(),0); ?>
      <div class="columns">
        <div class="column">
          <?php echo $this->render($view,NULL,get_defined_vars(),0); ?>
        </div>
        <div class="column is-3 is-hidden-mobile is-hidden-widescreen-only">
          <p>Desktop ad bar</p>
        </div>
        <div class="column is-hidden-tablet-only is-hidden-desktop-only">
          <p>Mobile ad bar</p>
        </div>
      </div>
    </div>
    <script src="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/js/petite.js"></script>
  </body>
</html>