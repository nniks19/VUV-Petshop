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
<div class="container mt-2 bg-white text-center">
    <h2>Opis: </h2>

    <?php the_content(); ?>
    <?php echo '<div>Cijena: ' . get_post_meta ( $post->ID, 'cijena_artikla', TRUE) . ' kn</div><br>'; ?>
    <?php
    if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
        echo 'Kolicina: '. get_post_meta( $post->ID, 'kolicina_artikla', TRUE )[0]; 
        echo ' kom';
        echo '<div class="mt-auto justify-content-between d-flex align-items-center"><button id="'.$post->ID.'" onclick="alertMe(this, \'';
        echo the_title();
        echo '\')" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</button>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';
    } else{
        echo '<div><b>Proizvod trenutno nije dostupan!</b></div>';
    }
     ?>
</div>

<?php
get_footer();

?>