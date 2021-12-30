<?php
    get_header();
    wp_head();
    $args = array( 'category' => 'dogs', 'post_type' =>  'artikl' ); 
    $postslist = get_posts( $args );    
    echo'<div class="container">';
    echo'<div class="row row-cols-1 row-cols-md-2 g-4">';
    // Slicica artikla: the_post_thumbnail();
    // Link do artikla: the_permalink();
    /* Prikaz kolicine artikla: if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
        echo '<div class=""><button class="narancasti_btn"><i class="fas fa-cart-plus"></i></button></div>';
    } else{
        echo '<div><b>Nema na stanju!</b></div>';}*/
    // 
    foreach ($postslist as $post) :  setup_postdata($post); 
    ?>  
    test
    
    <?php endforeach; get_footer();
?> 
 