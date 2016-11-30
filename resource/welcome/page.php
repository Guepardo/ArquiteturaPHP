<!doctype html>
<html class="no-js" lang="">

   <!-- Adiciona a tag head dinamicamente. -->
   <?php echo self::get_head(); ?>

    <body>
 		<!-- Adiciona um header dinamicamente. -->
        <?php echo self::get_header(); ?>


        <div class="container" style="height: 550px;">
        	<div class="row">	
        		<div class="col-md-4 col-md-offset-4" style="text-align: center;">
        			<h1>Welcome!</h1>
        			<p>This is a MicroFramework on PHP.</p>
        		</div>			
        	</div>
        </div>

        <!-- Adiciona um Footer dinamicamente. -->
        <?php echo self::get_footer(); ?>


        <!-- Recupera caso haja algum arquivo js para ser anexado. -->
        <?php foreach(self::get_js_files() as $path):?>
        	<script src='<?php echo $path; ?>'></script>
        <?php endforeach; ?>

        <!-- Arquivos Js estáticos -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

         <!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>