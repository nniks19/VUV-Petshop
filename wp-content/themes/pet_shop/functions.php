<?php

require_once "class-wp-bootstrap-navwalker.php"; # Funkcionalnost izbornika sa bootstrapom
#Inicijalizacija teme
if (!function_exists("inicijaliziraj_temu")) {
    function inicijaliziraj_temu()
    {
        # Inicijalizacija teme
        add_theme_support("post-thumbnails");
        add_theme_support("title-tag");
        add_theme_support("custom-logo", [
            "height" => 32,
            "width" => 32,
            "flex-width" => true,
            "flex-height" => true,
            "class" => "navlogo",
        ]);
        register_nav_menus([
            "glavni-menu" => "Glavni navigacijski izbornik", # Registracija glavnog izbornika (koji ima id glavni-menu), a naziva se: Glavni navigacijski izbornik
        ]);
        $args = [
            "default-color" => "#1a1a1a", # Promjena pozadinske boje na temi
            ## 'default-image' => get_template_directory_uri() . '', # Promjena početne pozadinske slike na temi (ako druga nije zadana)
            "default-position-x" => "right", # Pozicija slike po x osi
            "default-position-y" => "top", # Pozicija slike po y osi
            "default-repeat" => "no-repeat", # Da se slika ovisno o velicini ekrana ne ponavlja
            "default-attachment" => "scroll",
        ];
        add_theme_support("custom-background", $args); # Dodavanje temi da može podržavati prilagođenu pozadinu
        add_theme_support("customize-selective-refresh-widgets"); # Selektivno osvježavanje je hibridni mehanizam za pregled koji ima prednost u izvedbi jer ne mora osvježavati cijeli prozor za pregled. Ovo je prije bilo dostupno uz JS-primijenjene postMessage preglede.
    }
}
add_action("after_setup_theme", "inicijaliziraj_temu");

# Bootstrap 5 ->da radi navwalker (upgrade)

add_filter( 'nav_menu_link_attributes', 'prefix_bs5_dropdown_data_attribute', 20, 3 );
function prefix_bs5_dropdown_data_attribute( $atts, $item, $args ) {
    if ( is_a( $args->walker, 'WP_Bootstrap_Navwalker' ) ) {
        if ( array_key_exists( 'data-toggle', $atts ) ) {
            unset( $atts['data-toggle'] );
            $atts['data-bs-toggle'] = 'dropdown';
        }
    }
    return $atts;
}

#Includanje navwalkera

function prefix_modify_nav_menu_args( $args ) {
    return array_merge( $args, array(
        'walker' => new wp_bootstrap_navwalker(),
    ) );
}
add_filter( 'wp_nav_menu_args', 'prefix_modify_nav_menu_args' );

# Dodavanje logotipa
function theme_prefix_the_custom_logo()
{
    if (function_exists("the_custom_logo")) {
        the_custom_logo();
    }
}
add_filter("get_custom_logo", "change_logo_class");
function change_logo_class($html)
{
    $html = str_replace(
        "custom-logo-link",
        "replace-this-with-your-classes",
        $html
    );
    return $html;
}

// Register Custom Post Type
function registriraj_artikl_cpt()
{
    $labels = [
        "name" => _x("Artikli", "Post Type General Name", "text_domain"),
        "singular_name" => _x(
            "Artikl",
            "Post Type Singular Name",
            "text_domain"
        ),
        "menu_name" => __("Artikli", "text_domain"),
        "name_admin_bar" => __("Artikl", "text_domain"),
        "archives" => __("Arhiva artikala", "text_domain"),
        "attributes" => __("Atributi artikla", "text_domain"),
        "parent_item_colon" => __("Parent Item:", "text_domain"),
        "all_items" => __("Svi artikli", "text_domain"),
        "add_new_item" => __("Dodaj novi artikl", "text_domain"),
        "add_new" => __("Dodaj novi artikl", "text_domain"),
        "new_item" => __("Novi artikl", "text_domain"),
        "edit_item" => __("Uredi artikl", "text_domain"),
        "update_item" => __("Ažuriraj artikl", "text_domain"),
        "view_item" => __("Pregledaj artikl", "text_domain"),
        "view_items" => __("Pregledaj artikle", "text_domain"),
        "search_items" => __("Pretraži artikl", "text_domain"),
        "not_found" => __("Nije pronađen", "text_domain"),
        "not_found_in_trash" => __("Nije pronađen u smeću", "text_domain"),
        "featured_image" => __("Preporučena slika", "text_domain"),
        "set_featured_image" => __("Postavi preporučenu sliku", "text_domain"),
        "remove_featured_image" => __(
            "Obriši preporučenu sliku",
            "text_domain"
        ),
        "use_featured_image" => __(
            "Koristi kao preporučenu sliku",
            "text_domain"
        ),
        "insert_into_item" => __("Dodaj u artikl", "text_domain"),
        "uploaded_to_this_item" => __("Prenesi u artikl", "text_domain"),
        "items_list" => __("Lista artikala", "text_domain"),
        "items_list_navigation" => __(
            "Navigacijska lista artikala",
            "text_domain"
        ),
        "filter_items_list" => __("Filtrirana lista artikala", "text_domain"),
    ];
    $args = [
        "label" => __("Artikl", "text_domain"),
        "description" => __("artikl", "text_domain"),
        "labels" => $labels,
        "supports" => ["title", "editor", 'thumbnail'],
        "taxonomies" => ["category", "post_tag"],
        "hierarchical" => false,
        "public" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "menu_position" => 5,
        "show_in_admin_bar" => true,
        "show_in_nav_menus" => true,
        "can_export" => true,
        "has_archive" => true,
        "exclude_from_search" => false,
        "publicly_queryable" => true,
        "capability_type" => "page",
    ];
    register_post_type("artikl", $args);
}
add_action("init", "registriraj_artikl_cpt", 0);

# Dodavanje metabox-a

function add_meta_box_artikl()
{
    add_meta_box(
        "petshop_artikl",
        "O artiklu",
        "html_meta_box_artikl",
        "artikl"
    );
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
					<input type="number" id="kolicina_artikla" name="kolicina_artikla" value="' .$kolicina_artikla .'" /> kom
				</div><br/>
                <div>
                    <label for="cijena_artikla">Cijena artikla: </label>
                    <input type="number" min="0.1" step="any" id="cijena_artikla" required="true" name="cijena_artikla" value="' .$cijena_artikla .'" /> kn
                </div>
			</div>';
}
function spremi_podatke_artikla($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce_artikl_kolicina = ( isset( $_POST[ 'artikl_kolicina_nonce' ] ) && wp_verify_nonce(
		$_POST[ 'artikl_kolicina_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	$is_valid_nonce_artikl_cijena = ( isset( $_POST['artikl_cijena_nonce' ] ) && wp_verify_nonce(
        $_POST['artikl_cijena_nonce'], basename(__FILE__) ) ) ? 'true' : 'false';
    if ($is_autosave || $is_revision || !$is_valid_nonce_artikl_kolicina || !$is_valid_nonce_artikl_cijena) {
        return;
    }
    if (!empty($_POST["kolicina_artikla"])) {
        update_post_meta(
            $post_id,
            "kolicina_artikla",
            $_POST["kolicina_artikla"]
        );
    } else {
        delete_post_meta($post_id, "kolicina_artikla");
    }
    if (!empty($_POST["cijena_artikla"])) {
        update_post_meta(
            $post_id,
            "cijena_artikla",
            $_POST["cijena_artikla"]
        );
    } else {
        delete_post_meta($post_id, "cijena_artikla");
    }
}
add_action("add_meta_boxes", "add_meta_box_artikl");
add_action("save_post", "spremi_podatke_artikla");

# Ucitavanje CSS datoteka
function UcitajCssTeme()
{
    wp_enqueue_style(
        "bootstrap-css",
        get_template_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css"
    ); # Bootstrap
    wp_enqueue_style("glavni-css", get_template_directory_uri() . "/style.css"); # Moj css
}
add_action("wp_enqueue_scripts", "UcitajCssTeme");

#Ucitavanje JS datoteka
function UcitajJsTeme()
{
    wp_enqueue_script(
        "bootstrap-js",
        get_template_directory_uri() . "/vendor/bootstrap/js/bootstrap.min.js",
        ["jquery"],
        true
    ); # Bootstrap JS
    wp_enqueue_script(
        "bootstrap-js",
        get_template_directory_uri() .
            "/vendor/bootstrap/js/bootstrap.bundle.min.js",
        ["jquery"],
        true
    ); # Bootstrap JS
    wp_enqueue_script(
        "jquery-js",
        get_template_directory_uri() . "/vendor/jquery/jquery.min.js",
        ["jquery"],
        true
    ); # jQuery JS
    wp_enqueue_script(
        "glavni-js",
        get_template_directory_uri() . "/js/skripta.js",
        ["jquery"],
        true
    ); # Moj JS

}
add_action("wp_enqueue_scripts", "UcitajJsTeme");
 


?>

