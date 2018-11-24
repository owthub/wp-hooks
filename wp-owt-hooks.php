<?php
/*
 * Plugin Name: OWT WP Hooks
 * Description: This plugin is for demonstration of WP Hooks
 * Author: Online Web Tutor
 * Author URI: http://onlinewebtutorhub.blogspot.in/
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

define("OWT_HOOK_PLUGIN_BASENAME", plugin_basename(__FILE__));

function owt_wp_init() {

    $args = array(
        'public' => true,
        'label' => 'OWT Hooks'
    );
    register_post_type('owt_hook', $args);
}

//add_action("init", "owt_wp_init");

function owt_register_sidebar() {

    register_sidebar(array(
        'name' => __('OWT sidebar'),
        'id' => 'owt-sidebar-1',
        'description' => __('This is online web tutor widgets_init action hook study'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

//add_action("widgets_init", "owt_register_sidebar");

function owt_custom_menu() {

    add_menu_page("OWT Playlist", "OWT Playlist", "manage_options", "owt-playlist", "owt_plylist_fn");
    add_submenu_page("owt-playlist", "Submenu 1", "Submenu 1", "manage_options", "submenu-1", "owt_submenu_1_fn");
}

function owt_submenu_1_fn() {

    echo "This is our first submenu page";
}

function owt_plylist_fn() {

    echo "This is our Admin menu page";
}

//add_action("admin_menu", "owt_custom_menu");

function owt_attach_assets_to_admin_screen() {

    wp_enqueue_style("owt-css", plugin_dir_url(__FILE__) . "assets/css/owt-admin.css");
    wp_enqueue_script("owt-js", plugin_dir_url(__FILE__) . "assets/js/owt-admin.js");
}

add_action("admin_enqueue_scripts", "owt_attach_assets_to_admin_screen");

function owt_attach_assets_to_front() {

    wp_enqueue_style("owt-css", plugin_dir_url(__FILE__) . "assets/css/owt-front.css");
    wp_enqueue_script("owt-js", plugin_dir_url(__FILE__) . "assets/js/owt-front.js");
}

//add_action("wp_enqueue_scripts", "owt_attach_assets_to_front");

function owt_custom_bar_menu($wp_admin_bar) {

    $args = array(
        "id" => "owt-blog",
        "title" => "Online Web Tutor",
        "href" => "http://onlinewebtutorhub.blogspot.in/",
        "meta" => array(
            "class" => "owt-custom-blog",
            "target" => "_blank"
        )
    );

    $wp_admin_bar->add_node($args);

    $submenu1 = array(
        "id" => "owt-submenu1",
        "title" => "Google",
        "href" => "https://www.google.com",
        "parent" => "owt-blog"
    );

    $wp_admin_bar->add_node($submenu1);

    $submenu2 = array(
        "id" => "owt-submenu2",
        "title" => "Youtube",
        "href" => "https://www.youtube.com",
        "parent" => "owt-blog"
    );

    $wp_admin_bar->add_node($submenu2);
}

//add_action("admin_bar_menu", "owt_custom_bar_menu", 999);

function owt_admin_notice() {
    ?>
    <div class="notice notice-info is-dismissible">
        <p>This is success message of Admin panel</p>
    </div>
    <?php
}

//add_action("admin_notices", "owt_admin_notice");


function owt_make_mbx() {

    add_meta_box(
            'owt-mbx', 'OWT Custom Box', 'owt_mbx_fn', 'post', 'side', 'high'
    );
}

function owt_mbx_fn($post) {
    echo 'This is box for WP hooks Tutorial';
    ?>
    <div>
        <label>Name</label>
        <input type="text" value="<?php echo get_post_meta($post->ID, "owt_mx_value", true); ?>" name="owt_mbx_name" placeholder="Enter Name"/>
    </div>
    <?php
}

add_action("add_meta_boxes", "owt_make_mbx");

add_action("save_post", "owt_save_mbx_value");

function owt_save_mbx_value($post_id) {

    $owt_mbx_name = isset($_REQUEST['owt_mbx_name']) ? trim($_REQUEST['owt_mbx_name']) : "";

    if (!empty($owt_mbx_name)) {

        update_post_meta($post_id, "owt_mx_value", $owt_mbx_name);
    }
}

function owt_attach_assets_to_login_page() {

    wp_enqueue_style("owt-css1", plugin_dir_url(__FILE__) . "assets/css/owt-admin1.css");
    wp_enqueue_script("owt-js1", plugin_dir_url(__FILE__) . "assets/js/owt-admin1.js");
}

add_action("login_enqueue_scripts", "owt_attach_assets_to_login_page");

function owt_head_file_css() {

    echo '<link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'assets/css/header_owt.css"/>';
}

add_action("wp_head", "owt_head_file_css");

function owt_footer_file_js() {

    echo '<script src="' . plugin_dir_url(__FILE__) . 'assets/js/footer_owt.js"></script>';
}

add_action("wp_footer", "owt_footer_file_js");

function owt_login_input_form() {

    $txtname = isset($_POST['txtName']) ? $_POST['txtName'] : "";
    $txtphone = isset($_POST['txtPhone']) ? $_POST['txtPhone'] : "";
    ?>
    <p>
        <label for="txtName">Name</label>
        <input type="text" name="txtName" class="input" size="25" value="<?php echo $txtname; ?>"/>
    </p>
    <p>
        <label for="textPhone">Phone No</label>
        <input type="text" name="txtPhone" class="input" size="25" value="<?php echo $txtphone; ?>"/>
    </p>
    <?php
}

//add_action("login_form", "owt_login_input_form");

function owt_extra_fields_error_messages() {

    global $error;

    if (empty($_POST['txtName'])) {

        $error = "Name should not be empty";
    }

    if (empty($_POST['txtPhone'])) {

        $error .= "<br/>Phone no should not be empty";
    }
}

//add_action("login_head", "owt_extra_fields_error_messages");

function owt_fetch_all_login_data() {
    //print_r($_REQUEST);
    //die;
}

//add_action("wp_login", "owt_fetch_all_login_data");
//add_filter("the_title", "owt_filter_title");

function owt_filter_title($title) {

    return "owt-updated-" . $title;
}

//add_filter("the_content", "owt_filter_content");

add_filter("login_headerurl", "owt_update_login_logo_url");

function owt_update_login_logo_url($url) {

    return "https://www.google.com";
}

add_filter("login_headertitle", "owt_update_login_logo_title");

function owt_update_login_logo_title() {

    return "Online Web Tutor Blog";
}

//add_filter("login_url", "owt_update_login_url", 10, 2);

function owt_update_login_url($login_url, $redirect) {

    return home_url("/custom-login-page/?redirect_to=" . $redirect);
}

//echo wp_login_url();
//add_filter("logout_url", "owt_update_logout_url", 10, 2);

function owt_update_logout_url($logout_url, $redirect) {

    return home_url("/custom-logout-page/?redirect_to=" . $redirect);
}

//add_filter("lostpassword_url", "owt_update_lost_url", 10, 2);

function owt_update_lost_url($lostpassword_url, $redirect) {

    return home_url("/custom-lostpassword_url/?redirect_to=" . $redirect);
}

function owt_get_links() {

    echo '<a href="' . wp_logout_url(get_permalink()) . '">Logout URL</a>';
    echo "<br/>";
    echo '<a href="' . wp_lostpassword_url() . '">Lost Password URL</a>';
}

//add_action("init", "owt_get_links");

function codex_custom_init() {
    $args = array(
        'public' => true,
        'label' => 'Books'
    );
    register_post_type('book', $args);
}

add_action('init', 'codex_custom_init');


add_filter("manage_book_posts_columns", "owt_add_custom_clmns_book");

function owt_add_custom_clmns_book($columns) {

    // add custom columns to book custom post type

    $columns = array(
        "cb" => "<input type='checkbox'/>",
        "title" => "Book Title",
        "author" => "Book author",
        "amount" => "Book amount",
        "book_email" => "Book email",
        "date" => "Created date"
    );

    return $columns;
}

add_action("manage_book_posts_custom_column", "owt_cpt_book_data", 10, 2);

function owt_cpt_book_data($column_name, $post_id) {

    // supply data for custom post type book
    switch ($column_name) {

        case 'amount':
            echo 40;
            break;
        case 'book_email':
            echo 'onlinewebtutorhub@gmail.com';
            break;
    }
}

add_filter("plugin_action_links_" . OWT_HOOK_PLUGIN_BASENAME, "owt_add_other_plugin_links");

function owt_add_other_plugin_links($links) {

    //$list_table_plugin_url = admin_url("admin.php?page=owt-list-table");
    //$first_link = '<a href="' . $list_table_plugin_url . '">List Table Plugin</a>';

    $settings_link = admin_url("options-general.php?page=hook-settings-panel");

    $settings_anchor = '<a href="' . $settings_link . '">Settings</a>';

    array_push($links, $settings_anchor);

    return $links;
}

function owt_register_settings_panel() {

    add_submenu_page(
            "options-general.php", "Hook Settings", "Hook Settings", "manage_options", "hook-settings-panel", "owt_hook_settings_panel_fn"
    );
}

add_action("admin_menu", "owt_register_settings_panel");

function owt_hook_settings_panel_fn() {

    echo "<h1>This is settings page of OWT hook plugin</h1>";
}

add_filter("template_include", "owt_include_portfolio_page", 99);

function owt_include_portfolio_page($template) {

    if (is_page("portfolio")) {

        $new_template = locate_template(array("portfolio-page-template.php"));

        if (!empty($new_template)) {
            return $new_template;
        }
    }

    if (is_page("services")) {

        $new_template = locate_template(array("service-page-template.php"));
        
        if(!empty($new_template)){
            
            return $new_template;
        }
    }

    return $template;
}
