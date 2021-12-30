<?php
    get_header();
    wp_head();
    $args = array( 'category' => 'dogs', 'post_type' =>  'artikl' ); 
    $postslist = get_posts( $args );    
    echo'<div class="container">';
    // Slicica artikla: the_post_thumbnail();
    // Link do artikla: the_permalink();
    /* Prikaz kolicine artikla: if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
        echo '<div class=""><button class="narancasti_btn"><i class="fas fa-cart-plus"></i></button></div>';
    } else{
        echo '<div><b>Nema na stanju!</b></div>';}*/
    // Opis: the_excerpt();
    // Naslov artikla: the_title();
    echo '<section class="bg-light pt-5 pb-5 shadow-sm">
          <div class="container"><div class="row pt-5">';
    $brojac = 0;
    foreach ($postslist as $post) :  setup_postdata($post);
     $brojac = $brojac + 1;
     if ($brojac == 4){
        $brojac = 1;
     }
     if($brojac == 1){
        echo'<div class="row">';
     }
    ?>  
      <!--ADD CLASSES HERE d-flex align-items-stretch-->
      <div class="col-lg-4 mb-3 d-flex align-items-stretch">
        <div class="card">
          <!--<img src="https://i.postimg.cc/28PqLLQC/dotonburi-canal-osaka-japan-700.jpg" class="card-img-top" alt="Card Image">-->
          <div class="cardimageholder"><?php the_post_thumbnail('thumbnail', array('class' => 'cardimage')); ?></div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php the_title(); ?></h5>
            <p class="card-text mb-4"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Prikaži više</a></p>
            <a href="#" class="btn btn-primary mt-auto align-self-start">Book now</a>
          </div>
        </div>
      </div>
    



    
    <?php 
    endforeach;
    if ($brojac == 3)
    {
        echo'</div>';
    }
    echo '</section> </div> </div>';
    get_footer();
?> 
 