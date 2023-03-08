<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href=" <?= ($SCHEME.'://'.$HOST.$BASE.'/') ?> ">
	<title>Brighter Taxis Ltd</title>
<!--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css" />
<!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/petite-vue/0.4.1/petite-vue.umd.js" integrity="sha512-GNDUE32Gz3qGA0PI6+dhvMEWemGCiwIbwCFSqx1QJKaByERrWyTxWgvWga+U+ZRfQ0LLV4/2brQhr9oU1sl8ag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --> -->
        <link rel="stylesheet" href="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/css/bulma.min.css" />

  <script src="https://unpkg.com/petite-vue"></script>
  <?php if ($daytime): ?>
    
      <link rel="stylesheet" href="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/css/day.css" />
    
    <?php else: ?>
      <link rel="stylesheet" href="https://BTAXFF3PetiteVue.spurblickale.repl.co/public/css/night.css" />
    
  <?php endif; ?>
</head>

      