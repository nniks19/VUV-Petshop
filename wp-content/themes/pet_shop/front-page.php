<?php
   get_header();
   ?>
<div class="container">
   <div class="row">
      <div class="col-md-3 border-end  bg-white">
         <div class="widget-content">
            <div class="widget-title">
               <aside data-css-sidebar="sidebar">
                  <form data-css-form="filter" data-js-form="filter">
                     <h2 data-css-form="title">Filtriraj proizvode</h2>
                     <fieldset data-css-form="group">
                        <label data-css-form="label" for="artikl-naslov">Pretraži po naslovu</label>
                        <input data-css-form="input" type="text" id="artikl-naslov" name="artikl-naslov" placeholder="Akvarij">
                     </fieldset>
                     <fieldset data-css-form="group">
                        <label data-css-form="label" for="artikl-kategorija">Kategorije</label>
                        <?php
                           $kategorije = get_terms( array(
                               'taxonomy' => 'category',
                               'hide_empty' => false,
                           ) );
                           ?>
                        <select data-css-form="input select" id="artikl-kategorija" name="artikl-kategorija">
                           <option>Odaberi kategoriju</option>
                           <?php foreach($kategorije as $kategorija) : ?>
                           <option value="<?= $kategorija->term_id; ?>"><?= $kategorija->name; ?></option>
                           <?php endforeach; ?>
                        </select>
                     </fieldset>
                     <fieldset data-css-form="group">
                        <label data-css-form="label">Brendovi</label>
                        <?php
                           $args = array('post_type' =>  'brend', 'posts_per_page' => 50, 'post_status' => 'publish'); 
                           $postslist = new WP_QUERY( $args );  
                           while($postslist->have_posts()): $postslist->the_post()
                           ?>
                        <div data-css-form="input-group">
                           <input type="checkbox" id="<?= the_title(); ?>" name="artikl-brendovi[]" value="<?= the_title(); ?>"><label for="<?= the_title(); ?>"><?php the_title(); ?></label>
                        </div>
                        <?php endwhile; ?>
                     </fieldset>
                     <fieldset data-css-form="group">
                        <label data-css-form="label" for="artikl-redoslijed">Poredaj po</label>
                        <select data-css-form="input select" id="artikl-redoslijed" name="artikl-redoslijed">
                           <option value="">List Order</option>
                           <option value="Popularity">Popularity</option>
                           <option value="Alphabetical">Abecedi</option>
                        </select>
                     </fieldset>
                     <fieldset data-css-form="group right">
                        <button data-css-button="button red">Filter</button>
                        <input type="hidden" name="action" value="filter">
                     </fieldset>
                  </form>
               </aside>
            </div>
         </div>
      </div>
      <div class="col w-25 container-xl">
         <?php
            $args = array(
              'post_type' => 'artikl',
              'posts_per_page' => -1,
              'order' => 'ASC'
            );
            $query = new WP_Query($args);
            $brojac = 0;
            echo '<main data-css-content="main">
            <div data-css-content="wrapper" data-js-filter="target">';
            if($query->have_posts()) : 
              
              $counter = 0;
              
              while($query->have_posts()) : $counter++; $query->the_post();
            
              $artikl_id = get_the_ID();
            
              $url = get_the_permalink();
              $title = get_the_title();
              $thumb = get_the_post_thumbnail_url();
              $excerpt = get_the_excerpt();
              $kolicina = get_post_meta($artikl_id,'kolicina',true);
               print_r($kolicina);
              $taxonomy = 'genre';
            
              // Get the term IDs assigned to post.
              $post_terms = wp_get_object_terms( $artikl_id, $taxonomy, array( 'fields' => 'ids' ) );
              
              // Separator between links.
              $separator = ', ';
              
              if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
              
                  $term_ids = implode( ',' , $post_terms );
              
                  $terms = wp_list_categories( array(
                      'title_li' => '',
                      'style'    => 'none',
                      'echo'     => false,
                      'taxonomy' => $taxonomy,
                      'include'  => $term_ids
                  ) );
              
                  $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
              }
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
                                  echo '<div class="mt-auto justify-content-between d-flex align-items-center"><a href="#" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</a>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';
                              } else{
                                  echo '<div class="mt-auto justify-content-between d-flex align-items-center"><b>Nije raspoloživo!</b>'.'<a class="">Cijena: ' . get_post_meta( $post->ID, 'cijena_artikla', TRUE). ' kn</a>'.'</div>';}
                              
                              ?>
                        </div>
                     </div>
                  </div>
               <?php  if ($brojac == 3)
           {
               echo'</div>';
           }
         endwhile;
                  endif; wp_reset_postdata(); 
                  ?>
            </div>
      </div>
   </div>
</div>
</main>
<?php
   get_footer();
   ?>