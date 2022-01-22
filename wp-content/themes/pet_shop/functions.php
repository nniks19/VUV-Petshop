<?php
require_once "class-wp-bootstrap-navwalker.php"; # Funkcionalnost izbornika sa bootstrapom
#Inicijalizacija teme
if (!function_exists("inicijaliziraj_temu"))
{
    function inicijaliziraj_temu()
    {
        # Inicijalizacija teme
        add_theme_support("post-thumbnails");
        add_theme_support("title-tag");
        add_theme_support("custom-logo", ["height" => 32, "width" => 32, "flex-width" => true, "flex-height" => true, "class" => "navlogo", ]);
        register_nav_menus(["glavni-menu" => "Glavni navigacijski izbornik", # Registracija glavnog izbornika (koji ima id glavni-menu), a naziva se: Glavni navigacijski izbornik
        ]);
        $args = ["default-color" => "#1a1a1a", # Promjena pozadinske boje na temi
        ## 'default-image' => get_template_directory_uri() . '', # Promjena početne pozadinske slike na temi (ako druga nije zadana)
        "default-position-x" => "right", # Pozicija slike po x osi
        "default-position-y" => "top", # Pozicija slike po y osi
        "default-repeat" => "no-repeat", # Da se slika ovisno o velicini ekrana ne ponavlja
        "default-attachment" => "scroll", ];
        add_theme_support("custom-background", $args); # Dodavanje temi da može podržavati prilagođenu pozadinu
        add_theme_support("customize-selective-refresh-widgets"); # Selektivno osvježavanje je hibridni mehanizam za pregled koji ima prednost u izvedbi jer ne mora osvježavati cijeli prozor za pregled. Ovo je prije bilo dostupno uz JS-primijenjene postMessage preglede.
        
    }
}
add_action("after_setup_theme", "inicijaliziraj_temu");

# Bootstrap 5 ->da radi navwalker (upgrade)
add_filter('nav_menu_link_attributes', 'prefix_bs5_dropdown_data_attribute', 20, 3);
function prefix_bs5_dropdown_data_attribute($atts, $item, $args)
{
    if (is_a($args->walker, 'WP_Bootstrap_Navwalker'))
    {
        if (array_key_exists('data-toggle', $atts))
        {
            unset($atts['data-toggle']);
            $atts['data-bs-toggle'] = 'dropdown';
        }
    }
    return $atts;
}

#Includanje navwalkera
function prefix_modify_nav_menu_args($args)
{
    return array_merge($args, array(
        'walker' => new wp_bootstrap_navwalker() ,
    ));
}
add_filter('wp_nav_menu_args', 'prefix_modify_nav_menu_args');

# Dodavanje logotipa
function theme_prefix_the_custom_logo()
{
    if (function_exists("the_custom_logo"))
    {
        the_custom_logo();
    }
}
add_filter("get_custom_logo", "change_logo_class");
function change_logo_class($html)
{
    $html = str_replace("custom-logo-link", "replace-this-with-your-classes", $html);
    return $html;
}

// Register Custom Post Type
function registriraj_artikl_cpt()
{
    $labels = ["name" => _x("Artikli", "Post Type General Name", "text_domain") , "singular_name" => _x("Artikl", "Post Type Singular Name", "text_domain") , "menu_name" => __("Artikli", "text_domain") , "name_admin_bar" => __("Artikl", "text_domain") , "archives" => __("Arhiva artikala", "text_domain") , "attributes" => __("Atributi artikla", "text_domain") , "parent_item_colon" => __("Parent Item:", "text_domain") , "all_items" => __("Svi artikli", "text_domain") , "add_new_item" => __("Dodaj novi artikl", "text_domain") , "add_new" => __("Dodaj novi artikl", "text_domain") , "new_item" => __("Novi artikl", "text_domain") , "edit_item" => __("Uredi artikl", "text_domain") , "update_item" => __("Ažuriraj artikl", "text_domain") , "view_item" => __("Pregledaj artikl", "text_domain") , "view_items" => __("Pregledaj artikle", "text_domain") , "search_items" => __("Pretraži artikl", "text_domain") , "not_found" => __("Nije pronađen", "text_domain") , "not_found_in_trash" => __("Nije pronađen u smeću", "text_domain") , "featured_image" => __("Preporučena slika", "text_domain") , "set_featured_image" => __("Postavi preporučenu sliku", "text_domain") , "remove_featured_image" => __("Obriši preporučenu sliku", "text_domain") , "use_featured_image" => __("Koristi kao preporučenu sliku", "text_domain") , "insert_into_item" => __("Dodaj u artikl", "text_domain") , "uploaded_to_this_item" => __("Prenesi u artikl", "text_domain") , "items_list" => __("Lista artikala", "text_domain") , "items_list_navigation" => __("Navigacijska lista artikala", "text_domain") , "filter_items_list" => __("Filtrirana lista artikala", "text_domain") , ];
    $args = ["label" => __("Artikl", "text_domain") , "description" => __("artikl", "text_domain") , "labels" => $labels, "supports" => ["title", "editor", 'thumbnail'], "taxonomies" => ["category"], "hierarchical" => false, "public" => true, "show_ui" => true, "show_in_menu" => true, "menu_position" => 5, "show_in_admin_bar" => true, "show_in_nav_menus" => true, "can_export" => true, "has_archive" => true, "exclude_from_search" => false, "publicly_queryable" => true, "capability_type" => "page", ];
    register_post_type("artikl", $args);
}
add_action("init", "registriraj_artikl_cpt", 0);

function registriraj_brend_cpt()
{
    $labels = ["name" => _x("Brendovi", "Post Type General Name", "text_domain") , "singular_name" => _x("Brend", "Post Type Singular Name", "text_domain") , "menu_name" => __("Brendovi", "text_domain") , "name_admin_bar" => __("Brend", "text_domain") , "archives" => __("Arhiva brendova", "text_domain") , "attributes" => __("Atributi brenda", "text_domain") , "parent_item_colon" => __("Parent Item:", "text_domain") , "all_items" => __("Svi brendovi", "text_domain") , "add_new_item" => __("Dodaj novi brend", "text_domain") , "add_new" => __("Dodaj novi brend", "text_domain") , "new_item" => __("Novi brend", "text_domain") , "edit_item" => __("Uredi brend", "text_domain") , "update_item" => __("Ažuriraj brend", "text_domain") , "view_item" => __("Pregledaj brend", "text_domain") , "view_items" => __("Pregledaj brendove", "text_domain") , "search_items" => __("Pretraži brend", "text_domain") , "not_found" => __("Nije pronađen", "text_domain") , "not_found_in_trash" => __("Nije pronađen u smeću", "text_domain") , "featured_image" => __("Preporučena slika", "text_domain") , "set_featured_image" => __("Postavi preporučenu sliku", "text_domain") , "remove_featured_image" => __("Obriši preporučenu sliku", "text_domain") , "use_featured_image" => __("Koristi kao preporučenu sliku", "text_domain") , "insert_into_item" => __("Dodaj u brend", "text_domain") , "uploaded_to_this_item" => __("Prenesi u brend", "text_domain") , "items_list" => __("Lista brendova", "text_domain") , "items_list_navigation" => __("Navigacijska lista brendova", "text_domain") , "filter_items_list" => __("Filtrirana lista brendova", "text_domain") , ];
    $args = ["label" => __("Brend", "text_domain") , "description" => __("brend", "text_domain") , "labels" => $labels, "supports" => ["title", "editor", 'thumbnail'], "taxonomies" => [], "hierarchical" => false, "public" => true, "show_ui" => true, "show_in_menu" => true, "menu_position" => 5, "show_in_admin_bar" => true, "show_in_nav_menus" => true, "can_export" => true, "has_archive" => true, "exclude_from_search" => false, "publicly_queryable" => true, "capability_type" => "page", ];
    register_post_type("brend", $args);
}
add_action("init", "registriraj_brend_cpt", 0);

function registriraj_recenziju_cpt()
{
    $labels = ["name" => _x("Recenzije", "Post Type General Name", "text_domain") , "singular_name" => _x("Brend", "Post Type Singular Name", "text_domain") , "menu_name" => __("Recenzije", "text_domain") , "name_admin_bar" => __("Recenzija", "text_domain") , "archives" => __("Arhiva recenzija", "text_domain") , "attributes" => __("Atributi recenzije", "text_domain") , "parent_item_colon" => __("Parent Item:", "text_domain") , "all_items" => __("Sve recenzije", "text_domain") , "add_new_item" => __("Dodaj novu recenziju", "text_domain") , "add_new" => __("Dodaj novu recenziju", "text_domain") , "new_item" => __("Nova recenzija", "text_domain") , "edit_item" => __("Uredi recenziju", "text_domain") , "update_item" => __("Ažuriraj recenziju", "text_domain") , "view_item" => __("Pregledaj recenziju", "text_domain") , "view_items" => __("Pregledaj recenzije", "text_domain") , "search_items" => __("Pretraži recenziju", "text_domain") , "not_found" => __("Nije pronađena", "text_domain") , "not_found_in_trash" => __("Nije pronađena u smeću", "text_domain") , "featured_image" => __("Preporučena slika", "text_domain") , "set_featured_image" => __("Postavi preporučenu sliku", "text_domain") , "remove_featured_image" => __("Obriši preporučenu sliku", "text_domain") , "use_featured_image" => __("Koristi kao preporučenu sliku", "text_domain") , "insert_into_item" => __("Dodaj u recenziju", "text_domain") , "uploaded_to_this_item" => __("Prenesi u recenziju", "text_domain") , "items_list" => __("Lista recenzija", "text_domain") , "items_list_navigation" => __("Navigacijska lista recenzija", "text_domain") , "filter_items_list" => __("Filtrirana lista recenzija", "text_domain") , ];
    $args = ["label" => __("Recenzija", "text_domain") , "description" => __("recenzija", "text_domain") , "labels" => $labels, "supports" => ["title", "editor", 'thumbnail'], "taxonomies" => ["category"], "hierarchical" => false, "public" => true, "show_ui" => true, "show_in_menu" => true, "menu_position" => 5, "show_in_admin_bar" => true, "show_in_nav_menus" => true, "can_export" => true, "has_archive" => true, "exclude_from_search" => false, "publicly_queryable" => true, "capability_type" => "page", ];
    register_post_type("recenzija", $args);
}
add_action("init", "registriraj_recenziju_cpt", 0);

# Dodavanje metabox-a
function add_meta_box_artikl()
{
    add_meta_box("petshop_artikl", "O artiklu", "html_meta_box_artikl", "artikl");
}

function html_meta_box_artikl($post)
{
    wp_nonce_field("spremi_podatke_artikla", "artikl_kolicina_nonce");
    wp_nonce_field("spremi_podatke_artikla", "artikl_cijena_nonce");
    //dohvaćanje meta vrijednosti
    $kolicina_artikla = get_post_meta($post->ID, "kolicina_artikla", true);
    $cijena_artikla = get_post_meta($post->ID, "cijena_artikla", true);
    echo '
			<div>
				<div>
					<label for="kolicina_artikla">Kolicina artikla: </label>
					<input type="number" min="0" onkeypress="return event.charCode != 45" id="kolicina_artikla" name="kolicina_artikla" value="' . $kolicina_artikla . '" /> kom
				</div><br/>
                <div>
                    <label for="cijena_artikla">Cijena artikla: </label>
                    <input type="number" min="0.1" step="0.01" id="cijena_artikla" required="true" name="cijena_artikla" value="' . $cijena_artikla . '" /> kn
                </div>
			</div>';
}
function spremi_podatke_artikla($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce_artikl_kolicina = (isset($_POST['artikl_kolicina_nonce']) && wp_verify_nonce($_POST['artikl_kolicina_nonce'], basename(__FILE__))) ? 'true' : 'false';
    $is_valid_nonce_artikl_cijena = (isset($_POST['artikl_cijena_nonce']) && wp_verify_nonce($_POST['artikl_cijena_nonce'], basename(__FILE__))) ? 'true' : 'false';
    if ($is_autosave || $is_revision || !$is_valid_nonce_artikl_kolicina || !$is_valid_nonce_artikl_cijena)
    {
        return;
    }
    if (!empty($_POST["kolicina_artikla"]))
    {
        update_post_meta($post_id, "kolicina_artikla", $_POST["kolicina_artikla"]);
    }
    else
    {
        delete_post_meta($post_id, "kolicina_artikla");
    }
    if (!empty($_POST["cijena_artikla"]))
    {
        update_post_meta($post_id, "cijena_artikla", $_POST["cijena_artikla"]);
    }
    else
    {
        delete_post_meta($post_id, "cijena_artikla");
    }
}
add_action("add_meta_boxes", "add_meta_box_artikl");
add_action("save_post", "spremi_podatke_artikla");

function add_meta_box_brend()
{
    add_meta_box("petshop_brend", "Odabir artikala od odabranog brenda", "html_meta_box_brend", "brend");
}
function html_meta_box_brend($post)
{
    wp_nonce_field("spremi_podatke_brenda", "brend_artikl_nonce");
    $artikli_brenda_ids = get_post_meta($post->ID, 'artikli_od_brenda', true);
    $artikli_brenda_ids = explode(',', $artikli_brenda_ids);

    //dohvaćanje meta vrijednosti
    $args = array(
        'post_type' => 'artikl',
        'orderby' => 'ID',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => - 1 // dohvaćanje svih postova
        
    );
    $result = new WP_Query($args);

    if ($result->have_posts()):
        echo '<select name="brendovi[]" id="brendovi[]" multiple="yes">';
        while ($result->have_posts()):
            $result->the_post();
            $selected_text = (in_array(get_the_ID() , $artikli_brenda_ids)) ? "selected" : "";
            echo '<option ' . $selected_text . ' value="' . get_the_ID() . '">' . get_the_title() . '</option>';
        endwhile;
        echo '</select>';
    endif;
    wp_reset_postdata();

}
function spremi_podatke_brenda($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['brend_artikl_nonce']) && wp_verify_nonce($_POST['brend_artikl_nonce'], basename(__FILE__))) ? 'true' : 'false';
    if ($is_autosave || $is_revision || !$is_valid_nonce)
    {
        return;
    }

    if (isset($_POST['brendovi']))
    {
        $brendovi = implode(',', $_POST['brendovi']);
        update_post_meta($post_id, 'artikli_od_brenda', $brendovi);
    }
    else
    {
        delete_post_meta($post_id, 'brendovi');
    }
}

add_action("add_meta_boxes", "add_meta_box_brend");
add_action("save_post", "spremi_podatke_brenda");

function filter_ajax()
{
    #print_r($_POST);
    # Dohvaćanje odabranih stvari koje ću koristiti u Query-u
    $artikl_naslov = $_POST['artikl-naslov'];
    $artikl_kategorija = $_POST['artikl-kategorija'];
    $artikl_brend = $_POST['artikl-brend'];
    $artikl_raspolozivost = $_POST['artikl-raspolozivost'];
    $artikl_redoslijed = $_POST['artikl-redoslijed'];
    $artikl_akcija = $_POST['action'];
    $artikl_min_cijena = $_POST['min-price'];
    $artikl_max_cijena = $_POST['max-price'];
    #Argumenti
    $args = array(
        'post_type' => 'artikl',
        'posts_per_page' => - 1,
        'order' => 'ASC'
    );
    # Za search
    if (!empty($artikl_naslov))
    {
        $args['s'] = $artikl_naslov; # Dinamicki nacin za punjenje argumenata iznad.
    }
    if (!empty($artikl_kategorija)){
        $args['cat']= $artikl_kategorija;
    }
    if (!empty($artikl_brend) && $artikl_brend != "Odaberi brend"){
        $artikli_od_brenda = explode(",",get_post_meta($artikl_brend, 'artikli_od_brenda', true));
        $args['post__in'] = $artikli_od_brenda;
    }
    if (!empty($artikl_redoslijed)){
        $args['orderby'] = 'title';
        if ($artikl_redoslijed == 'ASC'){
        $args['order']= 'ASC';
        } if ($artikl_redoslijed == 'DESC'){
        $args['order']= 'DESC';
        } if ($artikl_redoslijed == 'rand'){
        $args['orderby']= 'rand';
        }
    }
    if (!empty($artikl_raspolozivost)){
        if ($artikl_raspolozivost == 'available'){
            $args['meta_query'] = array(array('key' => 'kolicina_artikla', 'value' => 1, 'type'=>'numeric', 'compare' => '>='));
        } if ($artikl_raspolozivost == 'not_available'){
            $args['meta_query'] = array(array('key' => 'kolicina_artikla', 'compare' => 'NOT EXISTS'));
        }
    }
    if (!empty($artikl_min_cijena) && !empty($artikl_max_cijena)){
        if ($artikl_min_cijena > $artikl_max_cijena){
            echo '<script>alert("Maksimalna cijena ne može biti veća od minimalne cijene artikla!");</script>';
            echo '<script>console.log('.$artikl_min_cijena.');</script>';
        } else{
            $args['meta_query'][] = array(array('key' => 'cijena_artikla','value' => array( $artikl_min_cijena, $artikl_max_cijena),'type' => 'numeric','compare' => 'BETWEEN'));
        }
    }
    $query = new WP_Query($args);
    $brojac = 0;

    if ($query->have_posts()):

        $counter = 0;

        while ($query->have_posts()):
            $counter++;
            $query->the_post();

            $artikl_id = get_the_ID();

            $url = get_the_permalink();
            $title = get_the_title();
            $thumb = get_the_post_thumbnail_url();
            $excerpt = get_the_excerpt();
            $kolicina = get_post_meta($artikl_id, 'kolicina', true);

            $taxonomy = 'category';
            // Get the term IDs assigned to post.
            $post_terms = wp_get_object_terms($artikl_id, $taxonomy, array(
                'fields' => 'ids'
            ));

            // Separator between links.
            $separator = ', ';

            if (!empty($post_terms) && !is_wp_error($post_terms))
            {

                $term_ids = implode(',', $post_terms);

                $terms = wp_list_categories(array(
                    'title_li' => '',
                    'style' => 'none',
                    'echo' => false,
                    'taxonomy' => $taxonomy,
                    'include' => $term_ids
                ));

                $terms = rtrim(trim(str_replace('<br />', $separator, $terms)) , $separator);
            }
            $brojac = $brojac + 1;
            if ($brojac == 4)
            {
                $brojac = 1;
            }
            if ($brojac == 1)
            {
                echo '<div class="row">';
            }
            echo '<div class="col-lg-4 mb-3 d-flex align-items-stretch"><div class="card"><div class="cardimageholder">';
            the_post_thumbnail("thumbnail", array("class" => "cardimage"));
            echo '</div><div class="card-body d-flex flex-column"><h5 class="card-title">';
            the_title();
            echo '</h5><p class="card-text mb-4">';
            the_excerpt();
            echo '<a href="';
            the_permalink();
            echo '">Prikaži više</a></p>';
            if(get_post_meta( get_the_ID(), "kolicina_artikla", TRUE)){
                echo '<div class="mt-auto justify-content-between d-flex align-items-center"><a href="#" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</a><a class="">Cijena: ';
                echo get_post_meta( get_the_ID(), "cijena_artikla", TRUE);
                echo ' kn</a></div>';
            } else{
                echo '<div class="mt-auto justify-content-between d-flex align-items-center"><b>Nije raspoloživo!</b><a class="">Cijena: ';
                echo get_post_meta( get_the_ID(), "cijena_artikla", TRUE);
                echo ' kn</a></div>';
            }
            echo '</div></div></div>';
            if ($brojac == 3)
            {
                echo '</div>';
            }
        endwhile;
    else:
        echo '<div class="text-center bg-white mt-4">Ne postoji niti jedan artikl sa odabranim kriterijima!</div>';
    endif;

    
    wp_reset_postdata();

    die();
}
add_action('wp_ajax_nopriv_filter', 'filter_ajax'); // Kad je korisnik prijavljen
add_action('wp_ajax_filter', 'filter_ajax'); // Kad korisnik nije prijavljen
# Ucitavanje CSS datoteka
function UcitajCssTeme()
{
    wp_enqueue_style("bootstrap-css", get_template_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css"); # Bootstrap
    wp_enqueue_style("glavni-css", get_template_directory_uri() . "/style.css"); # Moj css
    
}
add_action("wp_enqueue_scripts", "UcitajCssTeme");

#Ucitavanje JS datoteka
function UcitajJsTeme()
{
    wp_enqueue_script("bootstrap-js", get_template_directory_uri() . "/vendor/bootstrap/js/bootstrap.min.js", ["jquery"], true); # Bootstrap JS
    wp_enqueue_script("bootstrap-js", get_template_directory_uri() . "/vendor/bootstrap/js/bootstrap.bundle.min.js", ["jquery"], true); # Bootstrap JS
    wp_enqueue_script("jquery-js", get_template_directory_uri() . "/vendor/jquery/jquery.min.js", ["jquery"], true); # jQuery JS
    

    
}
add_action("wp_enqueue_scripts", "UcitajJsTeme");

function admin_enqueue_scripts_callback()
{

    //Add the Select2 CSS file
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array() , '4.1.0-rc.0');

    //Add the Select2 JavaScript file
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'jquery', '4.1.0-rc.0');

}
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts_callback');

function load_scripts()
{

    wp_enqueue_script('ajax', get_template_directory_uri() . '/js/skripta.js', array(
        'jquery'
    ) , NULL, true);

    wp_localize_script('ajax', 'wpAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php')
    ));

}

add_action('wp_enqueue_scripts', 'load_scripts');

?>
