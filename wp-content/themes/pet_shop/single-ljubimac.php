<?php
get_header();
wp_head();
?>
<div class="container mt-2 bg-white">
    <div class="text-center">
    <h1><?php single_post_title() ?> <h1>
        <?php the_post_thumbnail(); ?>
    </div>
</div>
<div class="container narancasti_tekst">
<?php
the_content();
?>
</div>
<?php 
$category=get_the_category();
$catid = "";
$catname = "";
foreach ( $category as $cat){
    $catid= $cat->cat_ID;
    $catname = $cat->cat_name;
}
echo $catid;
$args = array( 'cat' => $catid, 'post_type' =>  'artikl', 'posts_per_page' => 3, 'post_status' => 'publish', 'orderby' => 'rand'); 
$postslist = new WP_QUERY( $args );    
echo'<div class="container pt-1">';
    echo '<section class="bg-light pt-1 pb-1 shadow-sm">
          <div class="container"><div class="text-center"><h3><b>Preporučeni proizvodi iz kategorije '.strtolower($catname).':</b></h3></div><div class="row pt-15">';
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
                echo '<div class="mt-auto justify-content-between d-flex align-items-center"><button id="'.$post->ID.'" onclick="alertMe(this, \'';
                echo the_title();
                echo '\')" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</button>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';
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

?>