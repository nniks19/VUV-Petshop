<?php
    get_header();
    wp_head();
    $args = array('post_type' =>  'brend', 'posts_per_page' => 50, 'post_status' => 'publish'); 
    $postslist = new WP_QUERY( $args );    
    echo'<div class="container pt-1">';
    echo '<section class="bg-light pt-1 pb-1 shadow-sm">
          <div class="container"><div class="row pt-15">';
    $brojac = 0;
    if ($postslist->have_posts()) :
        while($postslist->have_posts()): $postslist->the_post();
        $brojac = $brojac + 1;
        if ($brojac == 4){
           $brojac = 1;
        }
        if($brojac == 1){
           echo'<div class="row">';
        }
       ?>  
         <div class="col-lg-4 mb-3 d-flex align-items-stretch">
           <div class="card">
             <div class="cardimageholder"><?php the_post_thumbnail('thumbnail', array('class' => 'cardimage')); ?></div>
             <div class="card-body d-flex flex-column">
               <h5 class="card-title"><?php the_title(); ?></h5>
               <p class="card-text mb-4"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Prikaži artikle</a></p>
               
             </div>
           </div>
         </div>
       <?php 
           if ($brojac == 3)
           {
               echo'</div>';
           }
    endwhile;
else:
    echo '<div class="text-center">Nema brendova!</div>';
endif;

    echo '</section> </div> </div>';
     ?>
    
</div>
<?php  


    get_footer();

?> 
 