<?php


if (!defined('ABSPATH')) {
    exit();
}
if (!class_exists('fme_cronjob')) {
    class fme_cronjob
    {

        public function __construct()
        {
            //initialize Cron Jobs
            add_filter('cron_schedules', array($this, 'fme_cron_schedules'));
            add_action('fme_extra_data_update', array($this, 'fme_cron_extra_data_autoupdater'));
        }

        /*
        |--------------------------------------------------------------------------
        |  cron custom schedules
        |--------------------------------------------------------------------------
         */

        public function fme_cron_schedules($schedules)
        {

            if (!isset($schedules['every_30_days'])) {

                $schedules['every_30_days'] = array(
                    'interval' => 30 * 24 * 60 * 60, // 2,592,000 seconds
                    'display'  => __('Once every 30 days', 'form-masks-for-elementor'),
                );
            }

            return $schedules;
        }

         /*
        |--------------------------------------------------------------------------
        |  cron extra data autoupdater
        |--------------------------------------------------------------------------
         */

        function fme_cron_extra_data_autoupdater() {

            $settings  = get_option('cfef_usage_share_data');
            
            if (!empty($settings) || $settings === 'on') {
                    fme_cronjob::fme_send_data();
            }
            
        }

        /*
        |--------------------------------------------------------------------------
        |  cron send data
        |--------------------------------------------------------------------------
         */ 

         public static function cpfm_get_user_info() {
                global $wpdb;
                // Server and WP environment details
                $server_info = [
                    'server_software'        => isset($_SERVER['SERVER_SOFTWARE']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])) : 'N/A',
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    'mysql_version'          => $wpdb ? sanitize_text_field($wpdb->get_var("SELECT VERSION()")) : 'N/A',
                    'php_version'            => sanitize_text_field(phpversion() ?: 'N/A'),
                    'wp_version'             => sanitize_text_field(get_bloginfo('version') ?: 'N/A'),
                    'wp_debug'               => (defined('WP_DEBUG') && WP_DEBUG) ? 'Enabled' : 'Disabled',
                    'wp_memory_limit'        => sanitize_text_field(ini_get('memory_limit') ?: 'N/A'),
                    'wp_max_upload_size'     => sanitize_text_field(ini_get('upload_max_filesize') ?: 'N/A'),
                    'wp_permalink_structure' => sanitize_text_field(get_option('permalink_structure') ?: 'Default'),
                    'wp_multisite'           => is_multisite() ? 'Enabled' : 'Disabled',
                    'wp_language'            => sanitize_text_field(get_option('WPLANG') ?: get_locale()),
                    'wp_prefix'              => isset($wpdb->prefix) ? sanitize_key($wpdb->prefix) : 'N/A',
                ];
                // Theme details
                $theme = wp_get_theme();
                $theme_data = [
                    'name'      => sanitize_text_field($theme->get('Name')),
                    'version'   => sanitize_text_field($theme->get('Version')),
                    'theme_uri' => esc_url($theme->get('ThemeURI')),
                ];
                // Ensure plugin functions are loaded
                if ( ! function_exists('get_plugins') ) {
                    require_once ABSPATH . 'wp-admin/includes/plugin.php';
                }
                // Active plugins details
                $active_plugins = get_option('active_plugins', []);
                $plugin_data = [];
                foreach ( $active_plugins as $plugin_path ) {
                    $plugin_info = get_plugin_data(WP_PLUGIN_DIR . '/' . sanitize_text_field($plugin_path));
                    $plugin_data[] = [
                        'name'       => sanitize_text_field($plugin_info['Name']),
                        'version'    => sanitize_text_field($plugin_info['Version']),
                    'plugin_uri' => esc_url( !empty($plugin_info['PluginURI']) ? $plugin_info['PluginURI'] : $plugin_info['AuthorURI'] ),
                    ];
                }
                return [
                    'server_info'   => $server_info,
                    'extra_details' => [
                        'wp_theme'       => $theme_data,
                        'active_plugins' => $plugin_data,
                    ],
                ];
            }


         static public function fme_send_data() {
 
                 $feedback_url = FME_FEEDBACK_URL.'wp-json/coolplugins-feedback/v1/site';
                    
                 $extra_data_details = static::cpfm_get_user_info();

                  $server_info        = $extra_data_details['server_info'];
                  $extra_details      = $extra_data_details['extra_details'];
                  $site_url           = get_site_url();
                  $install_date       = get_option('fme-install-date');
                  $uni_id      		  = '14';
			      $site_id            = $site_url . '-' . $install_date . '-' .$uni_id;
                 
                  $initial_version = get_option('fme-v');
                  $initial_version = is_string($initial_version) ? sanitize_text_field($initial_version) : 'N/A';
                  $plugin_version = defined('FME_VERSION') ? FME_VERSION : 'N/A';
                  $admin_email = sanitize_email(get_option('admin_email') ?: 'N/A');
              
                  $post_data = array(
                      'site_id'           => md5($site_id),
                      'plugin_version'    => $plugin_version,
                      'plugin_name'       => "Form Input Masks for Elementor Form",
                      'plugin_initial'    => $initial_version,
                      'email'             => $admin_email,
                      'site_url'          => esc_url_raw($site_url),
                      'server_info'       => $server_info,
                      'extra_details'     => $extra_details,
                  );
              
                  $response = wp_remote_post(esc_url($feedback_url), array(
                      'method'    => 'POST',
                      'timeout'   => 30,
                      'headers'   => array(
                          'Content-Type' => 'application/json',
                      ),
                      'body'      => wp_json_encode($post_data),
                  ));
              
                  if (is_wp_error($response)) {
                    //   error_log('fme Feedback Send Failed: ' . $response->get_error_message());
                      return;
                  }
              
                  $response_body = wp_remote_retrieve_body($response);
                  $decoded = json_decode($response_body, true);
                
                  if (!wp_next_scheduled('fme_extra_data_update')) {
                    wp_schedule_event(time(), 'every_30_days', 'fme_extra_data_update');
                }
             
        }

    }

    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $cron_init = new fme_cronjob();
}
