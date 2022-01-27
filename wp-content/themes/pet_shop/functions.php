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

add_filter('show_admin_bar', '__return_false');


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

function registriraj_ljubimca_cpt()
{
    $labels = ["name" => _x("Ljubimci", "Post Type General Name", "text_domain") ,
    "singular_name" => _x("ljubimac", "Post Type Singular Name", "text_domain") ,
    "menu_name" => __("Ljubimci", "text_domain") ,
    "name_admin_bar" => __("Ljubimac", "text_domain") , 
    "archives" => __("Arhiva ljubimaca", "text_domain") , 
    "attributes" => __("Atributi ljubimaca", "text_domain") , 
    "parent_item_colon" => __("Parent Item:", "text_domain") , 
    "all_items" => __("Svi ljubimci", "text_domain") , 
    "add_new_item" => __("Dodaj novog ljubimca", "text_domain") , 
    "add_new" => __("Dodaj novog ljubimca", "text_domain") , 
    "new_item" => __("Novi ljubimac", "text_domain") , 
    "edit_item" => __("Uredi ljubimca", "text_domain") , 
    "update_item" => __("Ažuriraj ljubimca", "text_domain") , 
    "view_item" => __("Pregledaj ljubimca", "text_domain") , 
    "view_items" => __("Pregledaj ljubimce", "text_domain") , 
    "search_items" => __("Pretraži ljubimca", "text_domain") , 
    "not_found" => __("Nije pronađen", "text_domain") , 
    "not_found_in_trash" => __("Nije pronađen u smeću", "text_domain") , 
    "featured_image" => __("Preporučena slika", "text_domain") , 
    "set_featured_image" => __("Postavi preporučenu sliku", "text_domain") , 
    "remove_featured_image" => __("Obriši preporučenu sliku", "text_domain") , 
    "use_featured_image" => __("Koristi kao preporučenu sliku", "text_domain") , 
    "insert_into_item" => __("Dodaj u ljubimca", "text_domain") , 
    "uploaded_to_this_item" => __("Prenesi u ljubimca", "text_domain") , 
    "items_list" => __("Lista ljubimaca", "text_domain") , 
    "items_list_navigation" => __("Navigacijska lista ljubimaca", "text_domain") , 
    "filter_items_list" => __("Filtrirana lista ljubimaca", "text_domain") , ];
    $args = ["label" => __("ljubimac", "text_domain") , 
    "description" => __("ljubimac", "text_domain") , 
    "labels" => $labels, 
    "supports" => ["title", "editor", 'thumbnail'], 
    "taxonomies" => ["category"], 
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
    "capability_type" => 
    "page", ];
    register_post_type("ljubimac", $args);
}
add_action("init", "registriraj_ljubimca_cpt", 0);

function registriraj_narudzba_cpt() {

	/**
	 * Post Type: Narudžbe.
	 */

	$labels = [
		"name" => __( "Narudžbe", "VUV" ),
		"singular_name" => __( "Narudžba", "VUV" ),
		"menu_name" => __( "Narudžbe", "VUV" ),
		"all_items" => __( "Sve narudžbe", "VUV" ),
		"add_new" => __( "Dodaj novu narudžbu", "VUV" ),
		"add_new_item" => __( "Dodaj novu narudžbu", "VUV" ),
		"edit_item" => __( "Uredi narudžbu", "VUV" ),
		"new_item" => __( "Nova narudžba", "VUV" ),
		"view_item" => __( "Pregledaj narudžbu", "VUV" ),
		"view_items" => __( "Pregledaj narudžbe", "VUV" ),
		"search_items" => __( "Pretraži narudžbe", "VUV" ),
		"not_found" => __( "Nije pronađena narudžba", "VUV" ),
		"not_found_in_trash" => __( "Nema narudžbi u smeću", "VUV" ),
		"parent" => __( "Roditelj narudžba:", "VUV" ),
		"featured_image" => __( "Preporučena slika za narudžbu", "VUV" ),
		"set_featured_image" => __( "Postavi preporučenu sliku za narudžbu", "VUV" ),
		"remove_featured_image" => __( "Obriši preporučenu sliku za narudžbu", "VUV" ),
		"use_featured_image" => __( "Koristi preporučenu sliku za narudžbu", "VUV" ),
		"archives" => __( "Arhiva narudžbi", "VUV" ),
		"insert_into_item" => __( "Dodaj u narudžbu", "VUV" ),
		"uploaded_to_this_item" => __( "Prenesi na ovu narudžbu", "VUV" ),
		"filter_items_list" => __( "Filtriraj narudžbe", "VUV" ),
		"items_list_navigation" => __( "Navigacijska lista narudžbi", "VUV" ),
		"items_list" => __( "Lista narudžbi", "VUV" ),
		"attributes" => __( "Atributi narudžbi", "VUV" ),
		"name_admin_bar" => __( "Narudžba", "VUV" ),
		"item_published" => __( "Narudžba objavljena", "VUV" ),
		"item_published_privately" => __( "Narudžba objavljena privatno.", "VUV" ),
		"item_reverted_to_draft" => __( "Narudžba prebačena u skicu", "VUV" ),
		"item_scheduled" => __( "Narudžba zakazana", "VUV" ),
		"item_updated" => __( "Narudžba ažurirana", "VUV" ),
		"parent_item_colon" => __( "Roditelj narudžba:", "VUV" ),

	];

	$args = [
		"label" => __( "Narudžbe", "VUV" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "narudzba", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title" ],
		"show_in_graphql" => false,
	];

	register_post_type( "narudzba", $args );
}
add_action( 'init', 'registriraj_narudzba_cpt' );
/*
        'capabilities' => array(
            'create_posts' => 'do_not_allow'
        ),
*/

// Register Custom Taxonomy
function customertype_taxonomy_narudzba() {

	$labels = array(
		'name'                       => _x( 'Tip kupca', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Tip kupca', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Tip kupca', 'text_domain' ),
		'all_items'                  => __( 'Svi tipovi kupaca', 'text_domain' ),
		'parent_item'                => __( 'Roditeljska stavka', 'text_domain' ),
		'parent_item_colon'          => __( 'Roditeljska stavka:', 'text_domain' ),
		'new_item_name'              => __( 'Novi tip kupca', 'text_domain' ),
		'add_new_item'               => __( 'Dodaj novi tip kupca', 'text_domain' ),
		'edit_item'                  => __( 'Uredi tip kupca', 'text_domain' ),
		'update_item'                => __( 'Ažuriraj tip kupca', 'text_domain' ),
		'view_item'                  => __( 'Pregledaj tip kupca', 'text_domain' ),
		'separate_items_with_commas' => __( 'Odvoji tipove kupaca zarezom', 'text_domain' ),
		'add_or_remove_items'        => __( 'Dodaj ili ukloni tipove kupaca', 'text_domain' ),
		'choose_from_most_used'      => __( 'Odaberi od najčešće korištenih tipova kupaca', 'text_domain' ),
		'popular_items'              => __( 'Popularni tipovi kupaca', 'text_domain' ),
		'search_items'               => __( 'Pretraži tipove kupaca', 'text_domain' ),
		'not_found'                  => __( 'Nije pronađen', 'text_domain' ),
		'no_terms'                   => __( 'Nema tipova kupaca', 'text_domain' ),
		'items_list'                 => __( 'Lista tipova kupaca', 'text_domain' ),
		'items_list_navigation'      => __( 'Navigacijska lista tipova kupaca', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'customertype', array( 'narudzba' ), $args );

}
add_action( 'init', 'customertype_taxonomy_narudzba', 0 );

// Register Custom Taxonomy
function country_taxonomy_narudzba() {

	$labels = array(
		'name'                       => _x( 'Država', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Država', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Država', 'text_domain' ),
		'all_items'                  => __( 'Sve države', 'text_domain' ),
		'parent_item'                => __( 'Roditeljska stavka', 'text_domain' ),
		'parent_item_colon'          => __( 'Roditeljska stavka:', 'text_domain' ),
		'new_item_name'              => __( 'Nova država', 'text_domain' ),
		'add_new_item'               => __( 'Dodaj novu državu', 'text_domain' ),
		'edit_item'                  => __( 'Uredi državu', 'text_domain' ),
		'update_item'                => __( 'Ažuriraj državu', 'text_domain' ),
		'view_item'                  => __( 'Pregledaj državu', 'text_domain' ),
		'separate_items_with_commas' => __( 'Odvoji državu zarezom', 'text_domain' ),
		'add_or_remove_items'        => __( 'Dodaj ili ukloni države', 'text_domain' ),
		'choose_from_most_used'      => __( 'Odaberi od najčešće korištenih država', 'text_domain' ),
		'popular_items'              => __( 'Popularne države', 'text_domain' ),
		'search_items'               => __( 'Pretraži države', 'text_domain' ),
		'not_found'                  => __( 'Nije pronađena', 'text_domain' ),
		'no_terms'                   => __( 'Nema država', 'text_domain' ),
		'items_list'                 => __( 'Lista država', 'text_domain' ),
		'items_list_navigation'      => __( 'Navigacijska lista država', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'country', array( 'narudzba' ), $args );

}
add_action( 'init', 'country_taxonomy_narudzba', 0 );

// Register Custom Taxonomy
function status_taxonomy_narudzba() {

	$labels = array(
		'name'                       => _x( 'Status', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Status', 'text_domain' ),
		'all_items'                  => __( 'Svi statusi', 'text_domain' ),
		'parent_item'                => __( 'Roditeljska stavka', 'text_domain' ),
		'parent_item_colon'          => __( 'Roditeljska stavka:', 'text_domain' ),
		'new_item_name'              => __( 'Novi status', 'text_domain' ),
		'add_new_item'               => __( 'Dodaj novi status', 'text_domain' ),
		'edit_item'                  => __( 'Uredi status', 'text_domain' ),
		'update_item'                => __( 'Ažuriraj status', 'text_domain' ),
		'view_item'                  => __( 'Pregledaj status', 'text_domain' ),
		'separate_items_with_commas' => __( 'Odvoji status zarezom', 'text_domain' ),
		'add_or_remove_items'        => __( 'Dodaj ili ukloni status', 'text_domain' ),
		'choose_from_most_used'      => __( 'Odaberi od najčešće korištenih statusa', 'text_domain' ),
		'popular_items'              => __( 'Popularni statusi', 'text_domain' ),
		'search_items'               => __( 'Pretraži statuse', 'text_domain' ),
		'not_found'                  => __( 'Nije pronađen', 'text_domain' ),
		'no_terms'                   => __( 'Nema statusa', 'text_domain' ),
		'items_list'                 => __( 'Lista statusa', 'text_domain' ),
		'items_list_navigation'      => __( 'Navigacijska lista statusa', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'status', array( 'narudzba' ), $args );

}
add_action( 'init', 'status_taxonomy_narudzba', 0 );

# Dodavanje metabox-a
function add_meta_box_order_info()
{
    add_meta_box("petshop_order", "Detalji narudžbe", "html_meta_box_order_info", "narudzba");
}
function html_meta_box_order_info($post)
{
    //wp_nonce_field("spremi_podatke_narudzbe", "artikl_kolicina_nonce");
    //wp_nonce_field("spremi_podatke_", "artikl_cijena_nonce");
    //dohvaćanje meta vrijednosti
    //$kolicina_artikla = get_post_meta($post->ID, "kolicina_artikla", true);
    //$cijena_artikla = get_post_meta($post->ID, "cijena_artikla", true);
   
    echo '
			
    <label for="fname">Ime:</label>
    <input type="text" id="fname" name="fname" disabled><br><br>
    <label for="lname">Prezime:</label>
    <input type="text" id="lname" name="lname" disabled><br><br>
    <label for="city">Grad:</label>
    <input type="text" id="city" name="city" disabled><br><br>
    <label for="street">Ulica:</label>
    <input type="text" id="street" name="street" disabled><br><br>
    <label for="streetnum">Kućni broj:</label>
    <input type="text" id="streetnumber" name="streetnumber" disabled><br><br>
    <label for="zipcode">Poštanski broj:</label>
    <input type="text" id="zipcode" name="zipcode" disabled><br><br>
    <label for="oib">OIB:</label>
    <input type="text" id="oib" name="oib" disabled><br><br>
    <label for="phonenumber">Broj mobitela:</label>
    <input type="text" id="phonenumber" name="phonenumber" disabled><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" disabled><br><br>
    ';

}
add_action("add_meta_boxes", "add_meta_box_order_info");

# Dodavanje metabox-a
function add_meta_box_order_artikl()
{
    add_meta_box("petshop_order_artikl", "Odabrani artikli", "html_meta_box_order_artikl", "narudzba");
}
function html_meta_box_order_artikl($post)
{
    //wp_nonce_field("spremi_podatke_narudzbe", "artikl_kolicina_nonce");
    //wp_nonce_field("spremi_podatke_", "artikl_cijena_nonce");
    //dohvaćanje meta vrijednosti
    //$kolicina_artikla = get_post_meta($post->ID, "kolicina_artikla", true);
    //$cijena_artikla = get_post_meta($post->ID, "cijena_artikla", true);
    $artikli = new WP_QUERY(array('post_type' => 'artikl'));
    echo '<div>';
    echo '<table style="border: 1px solid black; border-collapse: collapse;">
    <tbody >
    <tr>
    <th style="border: 1px solid black; border-collapse: collapse;">ID artikla</th>
    <th style="border: 1px solid black; border-collapse: collapse;">Naziv artikla</th>
    <th style="border: 1px solid black; border-collapse: collapse;">Količina artikla</th>
    <th style="border: 1px solid black; border-collapse: collapse;">Cijena artikla</th>
    </tr>';
    if ($artikli->have_posts()) :
        while($artikli->have_posts()): $artikli->the_post();
        echo '
        <tr>
        <td style="border: 1px solid black; border-collapse: collapse;">'. get_the_ID() . '</td>
        <td style="border: 1px solid black; border-collapse: collapse;">'. get_the_title() . '</td>
        <td style="border: 1px solid black; border-collapse: collapse;">'. 0 . '</td>
        <td style="border: 1px solid black; border-collapse: collapse;">'. 0 . '</td>

        </tr>';
        endwhile;
    endif;
    echo '<tr>
    <td style="border: 1px solid black; border-collapse: collapse;">Ukupno:</td>
    <td style="border: 1px solid black; border-collapse: collapse;"></td>
    <td style="border: 1px solid black; border-collapse: collapse;"></td>
    <td style="border: 1px solid black; border-collapse: collapse;"></td>
    </tr></tbody></table></div>';
}
add_action("add_meta_boxes", "add_meta_box_order_artikl");

// The shortcode function
function wp_shortcode_cart() { 
 
    $string ='<div class="container bg-white"> 
    <p class="text-center text-dark">Košarica</p>
    
    ';


    $artikli = new WP_QUERY(array('post_type' => 'artikl'));
    if ($artikli->have_posts()) :
        while($artikli->have_posts()): $artikli->the_post();
        //get_the_ID()
        //get_the_title()
        endwhile;
    endif;
    $string .= '</div>';
    return $string; 
     
    }
    // Register shortcode
    add_shortcode('vuv_cart', 'wp_shortcode_cart'); 


//Define AJAX URL
function myplugin_ajaxurl() {
        echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}
add_action('wp_head', 'myplugin_ajaxurl');
 
 //The Javascript
 function add_this_script_footer(){ ?>
 <script> jQuery(document).ready(function($) {
     $(document).ready(function(){
        var artikli = localStorage.getItem('artikli');
        if(artikli){
            $.ajax({
                url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                data: {
                    'action':'example_ajax_request', // This is our PHP function below
                    'artikli' : localStorage.getItem('artikli') // This is the variable we are sending via AJAX
                },
                success:function(data) {
                    $(".articles").html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        } else{
            $(".articles").html('<div class="container text-center bg-white"><h1>Vaša košarica je prazna</h1></div>');
        }
     });
 });
 </script>
 <?php }
 add_action('wp_footer', 'add_this_script_footer');
 
 //The PHP
 function example_ajax_request() {
     if ( isset($_REQUEST['artikli']) ) {
         # Dohvaćanje sa requesta
         $artikli = $_REQUEST['artikli'];
         # Pretvaranje stringa u array
         $arrayArtikala = explode(',',$artikli);
         # Argumenti za query
         $args = array( 'post__in' => $arrayArtikala, 'post_type' =>  'artikl', 'post_status' => 'publish', 'post_per_page' => -1); 
         # Izvršavanje querya
         $postslist = new WP_QUERY( $args );
        #nacin testiranja: echo '<script>console.log('.json_encode($countries).');</script>';
         echo '
         <div class="container bg-white">
         <main>
           <div class="py-5 text-center">
             <img class="d-block mx-auto mb-4" src="https://localhost/petshop/wp-content/uploads/2022/01/shopping-cart-clip-art-cart-removebg-preview.png" alt="" width="200" height="150">
             <h2>Košarica</h2>
             <p class="lead">U košarici se nalaze proizvodi koje ste prethodno dodali. Nakon narudžbe ukoliko ste dobro popunili sve podatke bi vam trebao stići email sa potvrdom narudžbe.</p>
           </div>
       
           <div class="g-5">
             <div class="col-md-5 col-lg-12 order-md-last">
               <h4 class="d-flex justify-content-between align-items-center mb-3">
                 <span class="text-primary">Artikli u košarici</span>
                 <span class="badge bg-primary rounded-pill" id="cart_count">'.count($postslist->posts).'</span>
               </h4>
               <ul class="list-group mb-3"
                
               >';
            # Prolazak kroz dobivene rezultate iz Query-a
            $total_price = 0;
                    while($postslist->have_posts()): $postslist->the_post();
                    $rowpostid = get_the_ID();
                    $rowpostprice = get_post_meta( $rowpostid, 'cijena_artikla', TRUE);
                    $total_price += floatval($rowpostprice);
                    echo ' <li class="list-group-item d-flex lh-sm" id="item_'.$rowpostid.'">
                    <div class="me-auto p-2 bd-highlight align-self-center">
                    '; echo the_post_thumbnail('thumbnail', array('style' => 'width:100px!important; height:100px!important;')); echo '
                    <h6 class="">'.get_the_title().'</h6>
                    </div>
                    <div class="text-center bd-highlight d-flex flex-row-reverse bd-highlight align-self-center">
                    <div class="ms-2">
                    <button type="button" class="btn btn-danger rounded-circle" onclick="removeitemfromcart('.$rowpostid.')">X</button>
                    </div>
                    <div>
                    <input type="number" class="form-control" style="width:75px;" id="amount" id="amount" placeholder="" onInput="myFunction(this, _'.$rowpostid.','.$rowpostprice.' )" onKeyDown="return false" value="1" min="1" max="'.get_post_meta( $rowpostid, 'kolicina_artikla', TRUE).'" required=""></input>
                    <span class="text-muted" id="_'.$rowpostid.'">'.$rowpostprice.' kn</span>
                    </div>
                    </div>
                    </li>';
                    endwhile;
               echo '<li>
               <p id="totalprice">Cijena: '.$total_price.' kn</p>
               </li>
               </ul>
             </div>
             <div>
               <h4 class="mb-3">Podaci za dostavu</h4>
               <form class="needs-validation cartform" data-toggle="validator" data-js-form="getcartdata" novalidate="">
               <div class="col-md-4">
                 <label for="buyer_type" class="form-label">Vrsta kupca <span class="text-muted">*</span></label>
                 <select class="form-select" id="buyer_type" required="">
                   <option value="">Odaberi...</option>';
                   $customertypes = get_terms(['taxonomy' => 'customertype', 'hide_empty' => false]);
                   foreach ($customertypes as $customertype){
                       echo '<option value='.$customertype->term_id.'>'.$customertype->name.'</option>';
                   }
                 echo '</select>
                 <div class="invalid-feedback">
                   Please provide a valid state.
                 </div>
               </div>
                 <div class="row g-3">

                   <div class="col-sm-6">
                     <label for="firstName" class="form-label">Vaše ime <span class="text-muted">*</span></label>
                     <input type="text" class="form-control" id="firstName" placeholder="John" value="" required="">
                     <div class="invalid-feedback">
                       Valid first name is required.
                     </div>
                   </div>
       
                   <div class="col-sm-6">
                     <label for="lastName" class="form-label">Vaše prezime <span class="text-muted">*</span></label>
                     <input type="text" class="form-control" id="lastName" placeholder="Wick" value="" required="">
                     <div class="invalid-feedback">
                       Valid last name is required.
                     </div>
                   </div>
       
                   <div class="col-12">
                     <label for="city" class="form-label">Grad <span class="text-muted">*</span></label>
                     <input type="emcity" class="form-control" id="city" placeholder="Virovitica" required>
                     <div class="invalid-feedback">
                       Please enter a valid email address for shipping updates.
                     </div>
                   </div>
       
                   <div class="col-12">
                     <label for="address" class="form-label">Ulica <span class="text-muted">*</span></label>
                     <input type="text" class="form-control" id="address" placeholder="Zagrebačka ulica" required="">
                     <div class="invalid-feedback">
                       Please enter your shipping address.
                     </div>
                   </div>
       
                   <div class="col-12">
                     <label for="homenumber" class="form-label">Kučni broj <span class="text-muted">*</span></label>
                     <input type="text" class="form-control" id="homenumber" placeholder="9" required="">
                     <div class="invalid-feedback">
                       Please enter your shipping address.
                     </div>
                   </div>
       
                   <div class="col-md-5">
                     <label for="country" class="form-label">Država <span class="text-muted">*</span></label>
                     <select class="form-select" id="country" required="">
                       <option value="">Odaberi...</option>';
                       $countries = get_terms(['taxonomy' => 'country', 'hide_empty' => false]);
                        foreach ($countries as $country){
                            echo '<option value='.$country->term_id.'>'.$country->name.'</option>';
                        }
                       echo '</select>
                     <div class="invalid-feedback">
                       Odaberite državu.
                     </div>
                   </div>
       
                   <div class="col-md-3">
                     <label for="zip" class="form-label">Poštanski broj <span class="text-muted">*</span></label>
                     <input type="text" class="form-control" id="zip" placeholder="" required="">
                     <div class="invalid-feedback">
                       Zip code required.
                     </div>
                   </div>
                 </div>
                 <div class="col-12">
                 <label for="email" class="form-label">Email <span class="text-muted">*</span></label>
                 <input type="email" class="form-control" id="email" name="email" placeholder="ime@domena.hr" required>
                 <div class="invalid-feedback">
                   Please enter a valid email address for shipping updates.
                 </div>
               </div>
                 <hr class="my-4">
       
                 <h4 class="mb-3">Odabir načina plaćanja</h4>
       
                 <div class="my-3">
                   <div class="form-check">
                     <input id="onpickup" name="paymentMethod" type="radio" class="form-check-input" checked="" required="">
                     <label class="form-check-label" for="credit">Prilikom preuzimanja</label>
                   </div>
                 </div>
       
                 <button class="w-100 btn btn-primary btn-lg" name="action" value="getcartdata">Naruči</button>
               </form>
             </div>
           </div>
         </main>
       </div>'; // Kod buttna dodat type submit
     }
     // Always die in functions echoing AJAX content
    die();
 }
 // This bit is a special action hook that works with the WordPress AJAX functionality.
 add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
 add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' ); 



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
                echo '<div class="mt-auto justify-content-between d-flex align-items-center"><button id="'.get_the_ID().'" onclick="alertMe(this, \'';
                echo the_title();
                echo '\')" class="btn btn-primary btn-sm"><i class="fas fa-cart-plus"></i> Dodaj u košaricu</button>'.'<a class="">Cijena: ';
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
