<?php
get_header();
wp_head();
?>
<div class="container bijeli_tekst">
    <div class="text-center">
    <h1><?php single_post_title() ?> <h1>
        <?php the_post_thumbnail(); ?>
    </div>
    <h2 class="bijeli_tekst">Opis: </h2>
</div>
<div class="container narancasti_tekst">
    <?php the_content(); ?>
    <?php echo '<div>Cijena: ' . get_post_meta ( $post->ID, 'cijena_artikla', TRUE) . ' kn</div><br>'; ?>
    <?php
    if(get_post_meta( $post->ID, 'kolicina_artikla', TRUE)){
        echo 'Kolicina: '. get_post_meta( $post->ID, 'kolicina_artikla', TRUE )[0]; 
        echo ' kom';
        echo '<div class=""><button class="narancasti_btn"><i class="fas fa-cart-plus"></i></button></div>';
    } else{
        echo '<div><b>Proizvod trenutno nije dostupan!</b></div>';
    }
     ?>
</div>

<?php
get_footer();

?>