<?php
/**
 * Plugin Name: Thrinacia Reach CrowdFunding
 * Plugin URI: https://www.thrinacia.com/reach
 * Description: This plugin allows you to easily manage Thrinacia Reach crowdfunding campaigns
 * Version: 1.0.0
 * Author: Thrinacia Inc.
 */

 // Add scripts in admin
 add_action("admin_enqueue_scripts", "thrinacia_reach_add_script");
 function thrinacia_reach_add_script() {
   wp_enqueue_style("semantic_dropdown_css", plugin_dir_url( __FILE__ ) . "style/dropdown.min.css", false);
   wp_enqueue_style("semantic_grid_css", plugin_dir_url( __FILE__ ) . "style/grid.min.css", false);
   wp_enqueue_style("semantic_header_css", plugin_dir_url( __FILE__ ) . "style/header.min.css", false);
   wp_enqueue_style("semantic_icon_css", plugin_dir_url( __FILE__ ) . "style/icon.min.css", false);
   wp_enqueue_style("semantic_input_css", plugin_dir_url( __FILE__ ) . "style/input.min.css", false);
   wp_enqueue_style("semantic_item_css", plugin_dir_url( __FILE__ ) . "style/item.min.css", false);
   wp_enqueue_style("semantic_list_css", plugin_dir_url( __FILE__ ) . "style/list.min.css", false);
   wp_enqueue_style("semantic_search_css", plugin_dir_url( __FILE__ ) . "style/search.min.css", false);
   wp_enqueue_style("semantic_transition_css", plugin_dir_url( __FILE__ ) . "style/transition.min.css", false);
   wp_enqueue_script("jquery");
   wp_enqueue_script("semantic_dropdown_js", plugin_dir_url( __FILE__ ) . "script/dropdown.min.js", false);
   wp_enqueue_script("semantic_search_js", plugin_dir_url( __FILE__ ) . "script/search.min.js", false);
   wp_enqueue_script("semantic_transition_js", plugin_dir_url( __FILE__ ) . "script/transition.min.js", false);
 }

 // Define short code
 add_shortcode( "thrinacia-widget", "thrinacia_reach_add_widget_code" );
 function thrinacia_reach_add_widget_code($attr) {
   $id = $attr["id"];
   $themecolor = $attr["themecolor"];
   $fontcolor = $attr["fontcolor"];
   if (isset($id)) {
     $widget = '<div class="reach-campaign-widget">';
     $widget .= '<reach-widget campaignid="' . $id . '" themecolor="' . $themecolor . '" fontcolor="' . $fontcolor . '" fontfamily="Helvetica"></reach-widget>';
     $widget .= '<script type="text/javascript" src="https://reach.thrinacia.com/widget.js"></script>';
     $widget .= '</div>';
     return $widget;
   }
   return null;
 }

 // Define settings menu
 add_action("admin_menu", "thrinacia_reach_add_plugin_menu");
 function thrinacia_reach_add_plugin_menu() {
   add_menu_page( "Thrinacia Reach", "Thrinacia Reach Settings", "administrator", "reach-settings", "thrinacia_reach_set_settings_content");
 }

 function thrinacia_reach_set_settings_content() {
   ?>
    <h2>Thrinacia Reach Account Information</h2>
    <form class="" action="options.php" method="post">
      <?php settings_fields("thrinacia-settings-api") ?>
      <?php do_settings_sections("thrinacia-settings-api") ?>
      <table class="form-table">
        <tr valign="top">
        <th scope="row">Email</th>
        <td><input type="email" name="reach_login_email" value="<?php echo esc_attr( get_option('reach_login_email') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Password</th>
        <td><input type="password" name="reach_login_password" value="<?php echo esc_attr( get_option('reach_login_password') ); ?>" /></td>
        </tr>
      </table>

      <?php
        submit_button();
      ?>
    </form>
   <?php
 }

 // Define settings
 add_action("admin_init", "thrinacia_reach_plugins_settings");

 function thrinacia_reach_plugins_settings() {
    register_setting( 'thrinacia-settings-api', 'reach_login_email' );
    register_setting( 'thrinacia-settings-api', 'reach_login_password' );
 }

 add_action("edit_form_after_editor", "thrinacia_reach_add_campaign_dropdown");

 function thrinacia_reach_add_campaign_dropdown() {
   $userArray = wp_get_current_user();
   if (in_array("administrator", $userArray -> roles)) {
     include("reach-search.html");
   }
 }

?>
