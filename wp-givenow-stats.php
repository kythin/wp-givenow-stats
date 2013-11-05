<?php
/*
Plugin Name: wp-givenow-stats
Plugin URI: http://www.chrissamios.com/
Description: Show your current raised amount and/or the thermometer gauge from your GiveNow.com.au campaign. Use shortcodes in combination with the name of your page id on givenow.com.au. E.g. if your givenow link is http://www.givenow.com.au/abc123, the page id to use is abc123. So your shortcodes would be [givenow page="abc123"] for the gauge and the raised amount, or if you just want the amount or the gauge you can use [givenow-raised page="abc123"] or [givenow-gauge page="abc123"]

Version: 1.0
Author: http://www.github.com/kythin
Author Email: kythin@gmail.com
License:

  Copyright 2013 Chris Samios (kythin@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class GiveNowWidget {

    /*--------------------------------------------*
     * Constants
     *--------------------------------------------*/
    const name = 'GiveNow Widget';
    const slug = 'givenow_widget';

    /**
     * Constructor
     */
    function __construct() {
        //register an activation hook for the plugin
        register_activation_hook( __FILE__, array( &$this, 'install_givenow_widget' ) );

        //Hook up to the init action
        add_action( 'init', array( &$this, 'init_givenow_widget' ) );

        $path = plugin_dir_path( __FILE__ );
        require_once($path."/simple_html_dom.php");
        require_once($path."/givenow-connector.php");
    }

    /**
     * Runs when the plugin is activated
     */
    function install_givenow_widget() {
        // do not generate any output here
    }

    /**
     * Runs when the plugin is initialized
     */
    function init_givenow_widget() {
        // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();

        // Register the shortcode [givenow page="yourpageslug"]
        add_shortcode( 'givenow', array( &$this, 'render_shortcode' ) );
        add_shortcode( 'givenow-raised', array( &$this, 'render_shortcode_raised' ) );
        add_shortcode( 'givenow-gauge', array( &$this, 'render_shortcode_gauge' ) );
    }

    function render_shortcode($atts) {
        // Extract the attributes
        $page = "";
        extract(shortcode_atts(array(
            'page' => 'vulcanawomenscircus', //default
        ), $atts));

        //$page = "http://www.givenow.com.au/vulcanawomenscircus";
        $page = "http://www.givenow.com.au/".$page;
        ob_start(); ?>
        <div class="givenow">
            <a href="<?php echo $page; ?>"><img src="<?php echo GiveNow::gauge($page); ?>" class="gauge" /></a>
            <a href="<?php echo $page; ?>"><div class="raised">$<?php echo GiveNow::raised($page); ?></div></a>
        </div>
        <?php
        return ob_get_clean();

    }


    function render_shortcode_raised($atts) {
        // Extract the attributes
        $page = "";
        extract(shortcode_atts(array(
            'page' => 'vulcanawomenscircus', //default
        ), $atts));

        $page = "http://www.givenow.com.au/".$page;
        return '$'.GiveNow::raised($page);
    }

    function render_shortcode_gauge($atts) {
        // Extract the attributes
        $page = "";
        extract(shortcode_atts(array(
            'page' => 'vulcanawomenscircus', //default
        ), $atts));

        //$page = "http://www.givenow.com.au/vulcanawomenscircus";
        $page = "http://www.givenow.com.au/".$page;
        ob_start(); ?>
            <a href="<?php echo $page; ?>"><img src="<?php echo GiveNow::gauge($page); ?>" class="gauge" /></a>
        <?php
        return ob_get_clean();

    }




    /**
     * Registers and enqueues stylesheets for the administration panel and the
     * public facing site.
     */
    private function register_scripts_and_styles() {
        if ( is_admin() ) {

        } else {
            $this->load_file( self::slug . '-style', '/givenow.css' );
        } // end if/else
    } // end register_scripts_and_styles

    /**
     * Helper function for registering and enqueueing scripts and styles.
     *
     * @name	The 	ID to register with WordPress
     * @file_path		The path to the actual file
     * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
     */
    private function load_file( $name, $file_path, $is_script = false ) {

        $url = plugins_url($file_path, __FILE__);
        $file = plugin_dir_path(__FILE__) . $file_path;

        if( file_exists( $file ) ) {
            if( $is_script ) {
                wp_register_script( $name, $url, array('jquery') ); //depends on jquery
                wp_enqueue_script( $name );
            } else {
                wp_register_style( $name, $url );
                wp_enqueue_style( $name );
            } // end if
        } // end if

    } // end load_file

} // end class
new GiveNowWidget();

