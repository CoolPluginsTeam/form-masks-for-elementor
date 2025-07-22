<?php
/**
 * Plugin Name: Form Input Masks for Elementor Form
 * Plugin URI: https://coolplugins.net/
 * Description: Form Input Masks for Elementor Form creates a custom control in the field advanced tab for customizing your fields with masks. This plugin requires Elementor Pro (Form Widget).
 * Author: Cool Plugins
 * Author URI: https://coolplugins.net/
 * Version: 2.4.5
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: form-masks-for-elementor
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires Plugins: elementor
 * Elementor tested up to: 3.29.0
 * Elementor Pro tested up to: 3.29.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'FME_VERSION', '2.4.5' );
define( 'FME_FILE', __FILE__ );
define( 'FME_PLUGIN_BASE', plugin_basename( FME_FILE ) );
define( 'FME_PHP_MINIMUM_VERSION', '7.4' );
define( 'FME_WP_MINIMUM_VERSION', '5.5' );
define( 'FME_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'FME_FEEDBACK_URL', 'http://ravi.com/' );




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

            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'fme_plugin_settings_link' ) );

			

			add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );

			add_action( 'plugins_loaded',array($this,'plugin_loads'));

            $this->includes();
        }
    }

    public function plugin_loads(){

		if(!class_exists('CPFM_Feedback_Notice')){
			require_once FME_PLUGIN_PATH . 'admin/feedback/cpfm-common-notice.php';
		}

        add_action('cpfm_register_notice', function () {
            
            if (!class_exists('\CPFM_Feedback_Notice') || !current_user_can('manage_options')) {
                return;
            }

            $notice = [

                'title' => __('Elementor Form Addons by Cool Plugins', 'cool-formkit-for-elementor-forms'),
                'message' => __('Help us make this plugin more compatible with your site by sharing non-sensitive site data.', 'cool-plugins-feedback'),
                'pages' => ['cool-formkit','cfkef-entries','cool-formkit&tab=recaptcha-settings'],
                'always_show_on' => ['cool-formkit','cfkef-entries','cool-formkit&tab=recaptcha-settings'], // This enables auto-show
                'plugin_name'=>'fme'
            ];

            \CPFM_Feedback_Notice::cpfm_register_notice('cool_forms', $notice);

                if (!isset($GLOBALS['cool_plugins_feedback'])) {
                    $GLOBALS['cool_plugins_feedback'] = [];
                }
                
                $GLOBALS['cool_plugins_feedback']['cool_forms'][] = $notice;
           
            });
        
        add_action('cpfm_after_opt_in_fme', function($category) {

                

                if ($category === 'cool_forms') {

                    require_once FME_PLUGIN_PATH . 'admin/feedback/cron/fme-class-cron.php';

                    fme_cronjob::fme_send_data();
                    update_option( 'cfef_usage_share_data','on' );   
                } 
        });
	}

    private function includes() {

		require_once FME_PLUGIN_PATH . 'admin/feedback/cron/fme-class-cron.php';
		
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

	public function fme_pro_plugin_demo_link($links){
		$get_pro_link = '<a href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=ccfef_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard#pricing" style="font-weight: bold; color: green;" target="_blank">Get Pro</a>';
		array_unshift( $links, $get_pro_link );
		return $links;
	}

    public function fme_plugin_settings_link($links){

        $settings_link = '<a href="' . admin_url( 'admin.php?page=cool-formkit' ) . '">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;

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

        if(get_option('form_input_mask', true)){

            require_once FME_PLUGIN_PATH . 'includes/class-fme-plugin.php';
            FME\Includes\FME_Plugin::instance();
        }


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


        if(!get_option( 'fme-install-date' ) ) {
				add_option( 'fme-install-date', gmdate('Y-m-d h:i:s') );
        	}


			$settings       = get_option('cfef_usage_share_data');

			
			if (!empty($settings) || $settings === 'on'){
				
				static::fme_cron_job_init();
			}
	}

    public static function fme_cron_job_init()
		{
			if (!wp_next_scheduled('fme_extra_data_update')) {
				wp_schedule_event(time(), 'every_30_days', 'fme_extra_data_update');
			}
		}

	public static function fme_deactivate(){

        if (wp_next_scheduled('fme_extra_data_update')) {
            	wp_clear_scheduled_hook('fme_extra_data_update');
        }
	}


    public function plugin_row_meta( $plugin_meta, $plugin_file ) {
			if ( FME_PLUGIN_BASE === $plugin_file ) {
				$row_meta = [
					'docs' => '<a href="https://coolplugins.net/add-input-masks-elementor-form/?utm_source=fme_plugin&utm_medium=inside&utm_campaign=demo&utm_content=plugins-dashboard/" aria-label="' . esc_attr( esc_html__( 'Country Code Documentation', '' ) ) . '" target="_blank">' . esc_html__( 'Docs & FAQs', 'cfef' ) . '</a>'
				];

				$plugin_meta = array_merge( $plugin_meta, $row_meta );
			}

			return $plugin_meta;

		}
}

// Initialize the plugin.
Form_Masks_For_Elementor::instance();
