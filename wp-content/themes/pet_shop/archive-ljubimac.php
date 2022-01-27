<?php
    get_header();
    wp_head(); 
    echo'<div class="container pt-1">';
    echo '<section class="bg-light pt-1 pb-1 shadow-sm">
          <div class="container"><div class="row pt-15">';
          $categories = get_categories();
foreach($categories as $category) {
    $args = array('post_type' =>  'ljubimac',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
          'taxonomy' => 'category', // your tax
          'field' => 'id',
          'terms' => $category->term_id, // your term ID
        )
      ),  
    'post_status' => 'publish'); 
    $postslist = new WP_QUERY( $args );   
   $brojac = 0;
   if ($postslist->have_posts()) :
    echo '<hr><b><div class="text-center pb-3">'.$category->name . '</div></b><hr>';

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
              <p class="card-text mb-4"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Prikaži više</a></p>
              
            </div>
          </div>
        </div>
      <?php 
          if ($brojac == 3)
          {
              echo'</div>';
          }
   endwhile;

endif;

}
echo '</section> </div> </div>';

     ?>
    
</div>
<?php  


    get_footer();

?> 
 