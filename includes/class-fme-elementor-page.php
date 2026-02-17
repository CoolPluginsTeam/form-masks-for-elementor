<?php
/**
 * Class FME_Elementor_Page
 */
if ( ! defined( 'ABSPATH' ) ){
    exit;
} 

//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
class FME_Elementor_Page {

    protected $plugin_name;

    protected $version;

    private static $allowed_pages = array(
        'cool-formkit',
        'cfkef-entries',
    );


    public function __construct() {


        add_action('admin_print_scripts', [$this, 'hide_unrelated_notices']);

        $this->plugin_name = 'form-masks-for-elementor';

        $this->version = FME_VERSION;

        $this->load_dependencies();

    }

    public static function current_screen($slug)
    {
        $slug = sanitize_text_field($slug);
        return self::cfkef_current_page($slug);
    }


    public static function get_allowed_pages()
    {
        $allowed_pages = self::$allowed_pages;

        $allowed_pages = apply_filters('cfkef_dashboard_allowed_pages', $allowed_pages);

        return $allowed_pages;
    }

    private static function cfkef_current_page($slug)
    {
        //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended
        $current_page = isset($_GET['page']) ? esc_html( wp_unslash( $_GET['page'] ) ) :
                 //phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
                 ( isset($_POST['page']) ? esc_html( wp_unslash( $_POST['page'] ) ) :
                 //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended
                 ( isset($_GET['post_type']) ? esc_html( wp_unslash( $_GET['post_type'] ) ) :
                 //phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
                 ( isset($_POST['post_type']) ? esc_html( wp_unslash( $_POST['post_type'] ) ) : '' )));

        //phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $status=false;

        if (in_array($current_page, self::get_allowed_pages()) && $current_page === $slug) {
            $status=true;
        }

        if(function_exists('get_current_screen') && in_array($slug, self::get_allowed_pages())){
            $screen = get_current_screen();

            if($screen && property_exists($screen, 'id') && $screen->id && $screen->id === $slug){
                $status=true;
            }
        }

        return $status;
    }

    public function hide_unrelated_notices()
    { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.MaxExceeded, Generic.Metrics.NestingLevel.MaxExceeded
        $cfkef_pages = false;
        foreach (self::$allowed_pages as $page) {

            if (self::current_screen($page)) {
                $cfkef_pages = true;
                break;
            }
        }

        if ($cfkef_pages) {
            global $wp_filter;

            // Define rules to remove callbacks.
            $rules = [
                'user_admin_notices' => [], // remove all callbacks.
                'admin_notices'      => [],
                'all_admin_notices'  => [],
                'admin_footer'       => [
                    'render_delayed_admin_notices', // remove this particular callback.
                ],
            ];

            $notice_types = array_keys($rules);

            foreach ($notice_types as $notice_type) {
                if (empty($wp_filter[$notice_type]->callbacks) || ! is_array($wp_filter[$notice_type]->callbacks)) {
                    continue;
                }

                $remove_all_filters = empty($rules[$notice_type]);

                foreach ($wp_filter[$notice_type]->callbacks as $priority => $hooks) {
                    foreach ($hooks as $name => $arr) {
                        if (is_object($arr['function']) && is_callable($arr['function'])) {
                            if ($remove_all_filters) {
                                unset($wp_filter[$notice_type]->callbacks[$priority][$name]);
                            }
                            continue;
                        }

                        $class = ! empty($arr['function'][0]) && is_object($arr['function'][0]) ? strtolower(get_class($arr['function'][0])) : '';

                        // Remove all callbacks except WPForms notices.
                        if ($remove_all_filters && strpos($class, 'wpforms') === false) {
                            unset($wp_filter[$notice_type]->callbacks[$priority][$name]);
                            continue;
                        }

                        $cb = is_array($arr['function']) ? $arr['function'][1] : $arr['function'];

                        // Remove a specific callback.
                        if (! $remove_all_filters) {
                            if (in_array($cb, $rules[$notice_type], true)) {
                                unset($wp_filter[$notice_type]->callbacks[$priority][$name]);
                            }
                            continue;
                        }
                    }
                }
            }
        }

        add_action( 'admin_notices', [ $this, 'display_admin_notices' ], PHP_INT_MAX );
    }

    public function display_admin_notices() {
        do_action('cfkef_admin_notices');
    }


    private function load_dependencies() {

        if (!is_plugin_active( 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php' ) && !is_plugin_active( 'mask-form-elementor/index.php') && !is_plugin_active( 'conditional-fields-for-elementor-form-pro/class-conditional-fields-for-elementor-form-pro.php')) {

            
            require_once FME_PLUGIN_PATH . 'admin/class-cfef-admin.php';
            $plugin_admin = CFEF_Admin::get_instance($this->get_plugin_name(), $this->get_version());

        }

    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}