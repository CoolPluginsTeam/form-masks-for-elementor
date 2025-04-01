<?php
/**
 * Plugin Name: Form Input Masks for Elementor Form
 * Plugin URI: https://coolplugins.net/
 * Description: Form Input Masks for Elementor Form creates a custom control in the field advanced tab for customizing your fields with masks. This plugin requires Elementor Pro (Form Widget).
 * Author: Cool Plugins
 * Author URI: https://coolplugins.net/
 * Version: 2.4.4
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: form-masks-for-elementor
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires Plugins: elementor
 * Elementor tested up to: 3.28.3
 * Elementor Pro tested up to: 3.28.2
 */

 if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'FME_VERSION', '2.4.4' );
define( 'FME_PHP_MINIMUM_VERSION', '7.4' );
define( 'FME_WP_MINIMUM_VERSION', '5.5' );
define( 'FME_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, array( 'Form_Masks_For_Elementor', 'fme_activate' ) );
register_deactivation_hook( __FILE__, array( 'Form_Masks_For_Elementor', 'fme_deactivate' ) );

if ( ! function_exists( 'is_plugin_active' ) ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

class Form_Masks_For_Elementor {
    /**
     * Plugin instance.
     */
    private static $instance = null;

    /**
     * Constructor.
     */
    private function __construct() {
        if ( $this->check_requirements() ) {
            $this->initialize_plugin();
            add_action( 'init', array( $this, 'text_domain_path_set' ) );
			add_action( 'activated_plugin', array( $this, 'fme_plugin_redirection' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'fme_pro_plugin_demo_link' ) );
        }
    }

    /**
     * Singleton instance.
     *
     * @return self
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	public function fme_plugin_redirection($plugin){

		if ( is_plugin_active( 'cool-formkit-for-elementor-forms/cool-formkit-for-elementor-forms.php' ) ) {
			return false;
		}

		if ( $plugin == plugin_basename( __FILE__ ) ) {
			exit( wp_redirect( admin_url( 'admin.php?page=cool-formkit' ) ) );
		}	
	}

    public function text_domain_path_set(){
        load_plugin_textdomain( 'form-masks-for-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

	public function fme_pro_plugin_demo_link($link){
		$settings_link = '<a href="' . admin_url( 'admin.php?page=cool-formkit' ) . '">Cool FormKit</a>';
		array_unshift( $link, $settings_link );
		return $link;
	}

    /**
     * Check requirements for PHP and WordPress versions.
     *
     * @return bool
     */
    private function check_requirements() {
        if ( ! version_compare( PHP_VERSION, FME_PHP_MINIMUM_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_php_version_fail' ] );
            return false;
        }

        if ( ! version_compare( get_bloginfo( 'version' ), FME_WP_MINIMUM_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_wp_version_fail' ] );
            return false;
        }

		if ( is_plugin_active( 'cool-formkit-for-elementor-forms/cool-formkit-for-elementor-forms.php' ) ) {
			return false;
		}

        return true;
    }

    /**
     * Initialize the plugin.
     */
    private function initialize_plugin() {
        require_once FME_PLUGIN_PATH . 'includes/class-fme-plugin.php';
        FME\Includes\FME_Plugin::instance();

        if(!is_plugin_active( 'extensions-for-elementor-form/extensions-for-elementor-form.php' )){
            require_once FME_PLUGIN_PATH . '/includes/class-fme-elementor-page.php';
            new FME_Elementor_Page();
        }

		if ( is_admin() ) {
			require_once FME_PLUGIN_PATH . 'admin/feedback/admin-feedback-form.php';
		}
    }

    /**
     * Admin notice for PHP version failure.
     */
    public function admin_notice_php_version_fail() {
        $message = sprintf(
            esc_html__( '%1$s requires PHP version %2$s or greater.', 'form-masks-for-elementor' ),
            '<strong>Form Input Masks for Elementor Form</strong>',
            FME_PHP_MINIMUM_VERSION
        );

        $html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
        echo wp_kses_post( $html_message );
    }

    /**
     * Admin notice for WordPress version failure.
     */
    public function admin_notice_wp_version_fail() {
        $message = sprintf(
            esc_html__( '%1$s requires WordPress version %2$s or greater.', 'form-masks-for-elementor' ),
            '<strong>Form Input Masks for Elementor Form</strong>',
            FME_WP_MINIMUM_VERSION
        );

        $html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
        echo wp_kses_post( $html_message );
    }

	public static function fme_activate(){
		update_option( 'fme-v', FME_VERSION );
		update_option( 'fme-type', 'FREE' );
		update_option( 'fme-installDate', gmdate( 'Y-m-d h:i:s' ) );
	}

	public static function fme_deactivate(){
	}
}

// Initialize the plugin.
Form_Masks_For_Elementor::instance();
