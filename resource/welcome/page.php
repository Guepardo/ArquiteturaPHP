<!doctype html>
<html class="no-js" lang="">

   <!-- Adiciona a tag head dinamicamente. -->
   <?php echo self::get_head(); ?>

    <body>
 		<!-- Adiciona um header dinamicamente. -->
        <?php echo self::get_header(); ?>


        <p>Welcome!</p>

        <!-- Adiciona um Footer dinamicamente. -->
        <?php echo self::get_footer(); ?>


        <!-- Recupera caso haja algum arquivo js para ser anexado. -->
        <?php foreach(self::get_js_files() as $path):?>
        	<script src='<?php echo $path; ?>'></script>
        <?php endforeach; ?>

    </body>
</html>