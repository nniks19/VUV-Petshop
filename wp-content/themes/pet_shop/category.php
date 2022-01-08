<?php
    get_header();
    wp_head();
    $page_object = get_queried_object_id();
    $args = array( 'cat' => $page_object, 'post_type' =>  'artikl', 'posts_per_page' => 50, 'post_status' => 'publish'); 
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
               <p class="card-text mb-4"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Prikaži više</a></p>
               <?php
               if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
                   echo '<div class="mt-auto justify-content-between d-flex align-items-center"><a href="#" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</a>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';
               } else{
                   echo '<div class="mt-auto justify-content-between d-flex align-items-center"><b>Trenutno nema na stanju!</b>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';}

               ?>
               
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
    echo '<div class="text-center">Odabrana kategorija nema artikala!</div>';
endif;

    echo '</section> </div> </div>';
     ?>
    
</div>
<?php  


    get_footer();
    

    // Sintaksa: 
    // Slicica artikla: the_post_thumbnail();
    // Link do artikla: the_permalink();
    /* Prikaz kolicine artikla: if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
        echo '<div class=""><button class="narancasti_btn"><i class="fas fa-cart-plus"></i></button></div>';
    } else{
        echo '<div><b>Nema na stanju!</b></div>';}*/
    // Opis: the_excerpt();
    // Naslov artikla: the_title();
?> 
 