<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <script src="https://kit.fontawesome.com/33ab154de2.js" crossorigin="anonymous"></script>
      <title><?php wp_title(); ?></title>
      <?php wp_head(); ?>
   </head>
   <body <?php body_class(); ?> >
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
               <a class="navbar-brand" href="#">
                  <?php theme_prefix_the_custom_logo() ?>

                  <?php echo get_bloginfo(); ?>
               </a>
               

               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>              
                    <?php
                        $args = array(
                           'menu' => 'glavni-menu',
                           'depth' => 3,
                           'container' => 'div',
                           'container_class' =>'collapse navbar-collapse',
                           'container_id' =>'navbarSupportedContent',
                           'menu_class' => 'nav navbar-nav',
                           'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                           // Korištenje navigacijskog izbornika pomoću navwalker-a
                           'walker' => new wp_bootstrap_navwalker());
                        wp_nav_menu( $args );

                    ?>   

   
                  </ul>

                  <div class="d-flex px-5">
                  <?php echo '<a href="https://localhost/petshop/kosarica/"><i class="fas fa-shopping-cart d-flex justify-content-center mx-auto"></i></a>'; ?>

                  </div>
            </div>
         </nav>
