<?php
/**
 * Class FME_Elementor_Page
 */
if ( ! defined( 'ABSPATH' ) ){
    exit;
} 

class FME_Elementor_Page {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'),9999);
    }

    // Add the settings page to Elementor's menu
    public function add_settings_page() {
        if (!is_plugin_active( 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php' ) && !is_plugin_active( 'conditional-fields-for-elementor-form-pro/class-conditional-fields-for-elementor-form-pro.php' ) && !is_plugin_active( 'country-code-field-for-elementor-form/country-code-field-for-elementor-form.php' )) {
            add_submenu_page(
                'elementor',
                __('Cool Formkit', 'form-masks-for-elementor'),
                __('Cool Formkit', 'form-masks-for-elementor'),
                'manage_options',
                'cool-formkit',
                array($this, 'settings_page_content')
            );
        }
    }

    // Output the content of the settings page
    public function settings_page_content() {
        $plugin_list = get_plugins();

        $form_mask_installed_date = get_option( 'fme-installDate' );
        $conditional_fields_installed_date = get_option( 'cfef-installDate' );
        $conditional_fields_pro_installed_date = get_option( 'cfefp-installDate' );
        $country_code_installed_date = get_option( 'ccfef-installDate' );

        $plugins_dates = [
            'fim_plugin'  => $form_mask_installed_date,
            'cfef_plugin' => $conditional_fields_installed_date,
            'cfefp_plugin' => $conditional_fields_pro_installed_date,
            'ccfef_plugin' => $country_code_installed_date,
        ];

        $plugins_dates = array_filter($plugins_dates);

        if (!empty($plugins_dates)) {
            asort($plugins_dates);
            $first_plugin = key($plugins_dates);
        } else {
            $first_plugin = 'fim_plugin';
        }

        ?>
        <div class="cfk-wrapper">
            <div class="cfk-header">
                <div class="cfk-logo">
                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/cool-formkit-plugin-logo.png'; ?>" alt="Cool FormKit">
                </div>
                <div class="cfk-buttons">
                    <p>Upgrade your form with advanced features and maximum possibilities.</p>
                    <a href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=get-cfkef#pricing" class="button" target="_blank">Get Cool FormKit</a>
                </div>
            </div>
    
            <div class="cfk-content">
                <div class="cfk-plugins">
                    <div class="cfk-box cfk-left">
                        <div class="cfk-p-info">
                            <picture>
                                    <source srcset="<?php //echo FME_PLUGIN_URL . 'assets/images/placeholder.avif'; ?>">
                                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/form-input-mask-icon.png'; ?>">
                            </picture>
                            <div class="cfk-p-name">
                                <h2>Form Input Masks for Elementor Form</h2>
                                <p>Extend Elementor Pro forms with input masks for phone, date, credit card and more.</p>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <a target="_blank" class="button" href="https://coolplugins.net/video/form-input-masks/">
                                Video Tutorial
                            </a>
                            <a target="_blank" class="button button-secondary" href="https://coolplugins.net/add-input-masks-elementor-form/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=blog&utm_content=setting-page-fim-docs">
                                Check Documentation
                            </a>
                        </div>
                        <div class="cfk-p-features">
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Phone Masking</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>US Phone Formatting</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>CPF & CNPJ Masking</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Currency Formatting</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Credit Card Masking</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>CEP (Postal Code)</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Date and Time Masking</span>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <p>You will get more advanced fields inside:</p>
                            <a class="button button-secondary" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=get-cfkef" target="_blank">Cool FormKit</a>
                        </div>
                    </div>

                    <div class="cfk-box cfk-middle">
                        <div class="cfk-p-info">
                            <picture>
                                    <source srcset="<?php echo FME_PLUGIN_URL . 'assets/images/conditional-fields.avif'; ?>">
                                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/conditional-fields.png'; ?>">
                            </picture>
                            <div class="cfk-p-name">
                                <h2>Conditional Fields For Elementor Form</h2>
                                <p>Show or hide Elementor form fields based on other fields values selected by user.</p>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <a target="_blank" class="button" href="<?php 
                                if(!empty($plugin_list['conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php'])){
                                    if (!is_plugin_active( 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php' ) ){
                                                ?>
                                                plugin-install.php?s=Conditional%2520Fields%2520for%2520Elementor%2520Form%2520by%2520coolplugins&tab=search&type=term
                                                <?php
                                            }else{
                                                ?>
                                                https://coolplugins.net/cool-formkit-for-elementor-forms/
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            plugin-install.php?s=Conditional%2520Fields%2520for%2520Elementor%2520Form%2520by%2520coolplugins&tab=search&type=term
                                            <?php
                                        }
                                        ?>">
                                        <?php
                                        if(!empty($plugin_list['conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php'])){
                                            if (!is_plugin_active( 'conditional-fields-for-elementor-form/class-conditional-fields-for-elementor-form.php' ) ){
                                                ?>
                                                Activate
                                                <?php
                                            }else{
                                                ?>
                                                Check CoolFormkit
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            Install
                                            <?php
                                    }
                            ?></a>
                            <a target="_blank" class="button button-secondary" href="https://coolplugins.net/conditional-fields-for-elementor-form/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=blog&utm_content=setting-page-cfef-docs">
                                Check Documentation
                            </a>
                        </div>
                        <div class="cfk-p-features">
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Simple Operators (==, !=, >, <)</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Conditions for All Fields (Text, Radio, HTML ...)</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Contains, Starts-with & More Operators</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Multiple Conditions (AND Logic)</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Multiple Conditions (OR Logic)</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Conditionally Send Emails</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Redirect Form Conditionally</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Add Conditions on Submit Button</span>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <p>You will get pro features inside.</p>
                            <a class="button" href="https://coolplugins.net/product/conditional-fields-for-elementor-form/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=get-cfefp" target="_blank">Conditional Fields Pro</a>
                            <span>or</span>
                            <a class="button button-secondary" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=get-cfkef" target="_blank">Cool FormKit</a>
                        </div>
                    </div>

                    <div class="cfk-box cfk-right">
                        <div class="cfk-p-info">
                            <picture>
                                    <source srcset="<?php echo FME_PLUGIN_URL . 'assets/images/country-code-field.avif'; ?>">
                                    <img src="<?php echo FME_PLUGIN_URL . 'assets/images/country-code-field.png'; ?>">
                            </picture>
                            <div class="cfk-p-name">
                                <h2>Country Code For Tel Field</h2>
                                <p>Easily display country codes and flags inside the Elementor form phone field.</p>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <a target="_blank" class="button" href="<?php 
                                if (!empty($plugin_list['country-code-field-for-elementor-form/country-code-field-for-elementor-form.php'])) {
                                        if (!is_plugin_active('country-code-field-for-elementor-form/country-code-field-for-elementor-form.php')) {
                                                // If plugin is not active, provide the install link
                                                echo esc_url(admin_url('plugin-install.php?s=Country%2520Code%2520For%2520Elementor%2520Form%2520Telephone%2520Field%2520by%2520coolplugins&tab=search&type=term'));
                                            } else {
                                                // If plugin is active, provide the tutorial video link
                                                echo esc_url('https://coolplugins.net/video/country-code-free/');
                                            }
                                        } else {
                                            // If plugin is not found, provide the install link
                                            echo esc_url(admin_url('plugin-install.php?s=Country%2520Code%2520For%2520Elementor%2520Form%2520Telephone%2520Field%2520by%2520coolplugins&tab=search&type=term'));
                                        }
                                        ?>">
                                        <?php
                                        if (!empty($plugin_list['country-code-field-for-elementor-form/country-code-field-for-elementor-form.php'])) {
                                            if (!is_plugin_active('country-code-field-for-elementor-form/country-code-field-for-elementor-form.php')) {
                                                // If plugin is not active, display 'Activate'
                                                echo esc_html__('Activate', 'cfef');
                                            } else {
                                                // If plugin is active, display 'Watch Video Tutorial'
                                                echo esc_html__('Watch Video Tutorial', 'cfef');
                                            }
                                        } else {
                                            // If plugin is not found, display 'Install'
                                            echo esc_html__('Install', 'cfef');
                                        }
                                ?>
                            </a>
                            <a target="_blank" class="button button-secondary" href="https://docs.coolplugins.net/docs/cool-formkit/add-country-code-dropdown-to-tel-field-in-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=docs&utm_content=setting-page-ccfef-docs">
                                Check Documentation
                            </a>
                        </div>
                        <div class="cfk-p-features">
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Set A Default Country</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Show Only Specific Countries List</span>
                            </div>
                            <div class="cfk-p-feature">
                                <div class="icon-check">&#10003;</div>
                                <span>Exclude Some Countries</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Show Preferred Countries At Top</span>
                            </div>
                            <div class="cfk-p-feature pro">
                                <div class="icon-cross">&#10005;</div>
                                <span>Auto Detect Country via IP</span>
                            </div>
                        </div>
                        <div class="cfk-buttons">
                            <p>You will get pro features inside.</p>
                            <br>
                            <a class="button button-secondary" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=setting-page-ccfef-get-coolformkit" target="_blank"> Cool FormKit</a>
                        </div>
                    </div>
                </div>
                
                <div class="cfk-promo">
                    <div class="cfk-box cfk-left">
                        <div class="cfk-info">
                            <h2>What is Cool FormKit?</h2>
                            <p>All-in-one plugin, An addon for Elementor Pro forms that provides many extra features and advanced fields to extend your form-building experience using Elementor form widget.</p>
                        </div>
                        <div class="cfk-features">
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#conditional-fields" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/conditional-fields.png'; ?>" alt="Conditional Logic Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Conditional Logic for Fields</h4>
                                    <p>Apply conditional logic on form fields to show or hide fields based on other fields' values.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#country-code" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/country-code-field.png'; ?>" alt="Country Code Field Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Country Code for Tel Field</h4>
                                    <p>Add a country code dropdown selector inside your form's telephone field using Cool FormKit.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#range-field" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/range-slider-field.png'; ?>" alt="Range Slider Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Range Slider Field</h4>
                                    <p>Add a cool range slider field in your form so that your users can easily select from a range of numbers.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#rating-field" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/rating-field.png'; ?>" alt="Rating / Review Field Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Rating / Review Field</h4>
                                    <p>Show a star rating field inside your form to easily get reviews and feedback from your users.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#signature-field" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/signature-field.png'; ?>" alt="Signature Field Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Signature Field</h4>
                                    <p>Let your website users add their signature while submitting a form on your website using signature field.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#calculator-field" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/calculator-field.png'; ?>" alt="Calculator Field Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Calculator Field</h4>
                                    <p>Using Cool FormKit, you can add a calculator field that will show calculations based on form entries.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#image-radio-checkbox" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/image-radio-checkbox.png'; ?>" alt="Image Radio & Checkbox Styles Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Image Radio & Checkbox Styles</h4>
                                    <p>Customize your forms by adding images and icons into your options, making selections more visually engaging.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#button-radio-checkbox" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/checkbox-radio-styles.png'; ?>" alt="Checkbox & Radio Button Styler Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Checkbox & Radio Styles</h4>
                                    <p>Style your checkbox and radio button fields in your Elementor form using the Cool FormKit addon.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#label-styler" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/form-label-styles.png'; ?>" alt="Form Labels Styles Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Form Labels Styles</h4>
                                    <p>Make your form cool by adding styles to the labels' visibility inside your Elementor form using the Cool FormKit addon for Elementor.</p>
                                </div>
                            </a>
                            <a class="cfk-feature coming-soon" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#plugin-features" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/fields-divider.png'; ?>" alt="Fields Divider or Spacer Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Fields Divider or Spacer</h4>
                                    <p>Divide your form fields with lines or spacers. It is helpful to create multi-section forms inside Elementor.</p>
                                </div>
                            </a>
                            <a class="cfk-feature available" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=cfkef-feature&utm_content=feature-list#plugin-features" target="_blank">
                                <img src="<?php echo FME_PLUGIN_URL . 'assets/images/select2-field.png'; ?>" alt="Select2 Field Feature Icon">
                                <div class="cfk-f-info">
                                    <h4>Select2 Field</h4>
                                    <p>Turn your dropdown selector into a SELECT2 field that will help your users easily select from a large list in dropdown select option field.</p>
                                </div>
                            </a>
                        </div>
                        <div class="cfk-buttons">
                            <a class="button" href="https://coolplugins.net/cool-formkit-for-elementor-forms/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=get-pro&utm_content=setting-page-footer#pricing" target="_blank">Get Cool FormKit (Lifetime License)</a>
                            <p>More features & fields coming in regular upcoming updates...</p>
                        </div> 
                    </div>

                    <div class="cfk-right">
                        <a href="https://wordpress.org/support/plugin/form-masks-for-elementor/reviews/#new-post" target="_blank" class="cfk-box review">
                            Are you enjoying using our addon to upgrade features inside your Elementor form? Please submit your review as it boosts our energy to work on future updates.
                            <span>Submit Review ★★★★★</span>
                        </a>
                        <div class="cfk-box">
                            <h3>Links</h3>
                            <div class="cfk-buttons">
                                <a href="https://my.coolplugins.net/account/support-tickets/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=support&utm_content=important-links" class="button button-secondary" target="_blank">Contact Support</a>
                                <a href="https://coolplugins.net/about-us/?utm_source=<?php echo $first_plugin; ?>&utm_medium=inside&utm_campaign=about-us&utm_content=important-links" class="button" target="_blank">Meet Cool Plugins Developers</a>
                                <a href="https://x.com/cool_plugins" class="button" target="_blank">Follow On X</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div>
    
        <style>
            .elementor_page_cool-formkit .e-admin-top-bar--active, .elementor_page_cool-formkit #e-admin-top-bar-root, .elementor_page_cool-formkit #wpfooter {
                display: none !important;
            }
            .elementor_page_cool-formkit #wpbody #wpbody-content {
                margin-top: 80px !important;
                margin-block-start: 80px !important;
            }
            .cfk-wrapper {
                margin: 0;
                padding: 0 20px 0 0;
                box-sizing: border-box;
            }
            .cfk-wrapper * {
                box-sizing: border-box;
                font-family: Inter, Roboto, Helvetica, Arial, sans-serif;
            }
            .cfk-wrapper h1, .cfk-wrapper h2, .cfk-wrapper h3, .cfk-wrapper h4 {
                padding: 0px;
                margin: 0 0 10px 0;
                line-height: 1.4em;
            }
            .cfk-header {
                position: absolute;
                top: 0px;
                left: 0px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #ffffff;
                padding: 10px 20px;
                border-bottom: 1px solid #ddd;
                height: 60px;
                width: calc(100% + 20px);
                margin: 0 0 0 -20px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, .03);
            }
            .cfk-logo {
                display: flex;
                align-items: center;
            }
            .cfk-logo img {
                max-height: 40px;
            }
            .cfk-buttons {
                display: flex;
                gap: 15px;
                align-items: center;
                flex-wrap: wrap;
            }
            .cfk-buttons p{
                font-weight:bold;
            }
            .cfk-wrapper .button {
                padding: 10px 14px;
                background-color: #f16564;
                border: 1px solid #d2504f;
                box-shadow: 1px 2px 6px -4px rgb(169 63 63 / 60%);
                color: #ffffff;
                font-weight: 500;
                text-decoration: none;
                border-radius: 5px;
                font-size: 14px;
                line-height: 14px;
                align-self: center;
                text-shadow: 1px 1px 1px #da6868;
            }
            .cfk-wrapper .button-secondary {
                background: #f9f9f9;
                border: 1px solid #ccc;
                color: #595959;
                box-shadow: 1px 3px 4px -5px rgb(55 55 55 / 42%);
                text-shadow: 1px 1px 1px #ffffff;
            }
            .cfk-wrapper .button:hover {
                box-shadow: 1px 2px 6px -4px rgb(57 32 32 / 50%);
                border: 1px solid #cb3535;
                background: #db4e4d;
                color: #fff;
                text-shadow: none;
            }
            .cfk-wrapper .button:focus {
                background: #fff0f0;
                text-shadow: none;
                border-color: #c87070;
                color: #883434;
                box-shadow: 0 0 0 1px #e98080;
                outline: 2px solid transparent;
                outline-offset: 0;
            }
            .cfk-wrapper .button-secondary:hover {
                box-shadow: 1px 2px 6px -4px rgb(55 55 55 / 42%);
                background: #f1f1f1;
                border-color: #ccc;
                color: #222;
            }
            .cfk-box {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0px 2px 2px rgb(150 150 150 / 12%);
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .cfk-content {
                display: flex;
                gap: 25px;
                max-width: 1200px;
                margin: 10px auto;
                flex-direction: column;
            }
            .cfk-plugins {
                display: flex;
                gap: 25px;
            }
            .cfk-plugins .cfk-left {
                width: calc(33.33% - 16px);
            }
            .cfk-plugins .cfk-right {
                width: calc(33.33% - 16px);
            }
            .cfk-plugins .cfk-middle {
                width: calc(33.33% - 16px);
            }
            .cfk-p-info {
                display: flex;
                gap: 20px;
            }
            .cfk-p-info img {
                width: 120px;
                height: auto;
            }
            .cfk-p-feature {
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
                margin-bottom: 10px;
                display: flex;
                gap: 10px;
                align-items: center;
            }
            .cfk-p-feature:last-child {
                border-bottom: 0;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .icon-check, .icon-cross {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                color: white;
            }
            .icon-check {
                background-color: #4caf50;
            }
            .icon-cross {
                background-color: #f44336;
            }
            .cfk-p-feature.pro span:after {
                content: "PRO";
                background-color: #c9f3cf;
                color: #005e00;
                padding: 2px 5px;
                border-radius: 3px;
                font-size: 0.9em;
                margin-left: 5px;
            }
            .cfk-promo {
                display: flex;
                gap: 24px;
            }
            .cfk-promo .cfk-left {
                width: calc(67% - 12px);
            }
            .cfk-promo .cfk-right {
                width: calc(33% - 12px);
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .cfk-f-info p {
                margin: 0;
                padding: 0;
            }
            .cfk-features {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }
            a.cfk-feature {
                width: calc(50% - 10px);
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                text-decoration: none;
                color: #333;
                display: flex;
                gap: 15px;
                align-items: flex-start;
                transition: 0.4s;
                position: relative;
            }
            a.cfk-feature:hover {
                border-color: #838383;
                transform: scale(1.025);
                color: #333;
            }
            a.cfk-feature img {
                width: 100px;
                height: auto;
            }
            a.cfk-feature.coming-soon:after,
            a.cfk-feature.available:after {
                padding: 1px 4px;
                border-radius: 0 10px;
                position: absolute; 
                top: 1px;
                right: 1px;
            }
            a.cfk-feature.coming-soon:after {
                content: "Coming Soon...";
                background-color: #e1e1e1;
                color: #4d544d;
                font-size: 0.9em;
            }
            a.cfk-feature.available:after {
                content: "✓";
                background-color: #c9f3cf;
                color: #005e00;
                font-size: 1.2em;
            }
            a.cfk-box.review {
                text-decoration: none;
                background-image: linear-gradient(45deg, #e4f9ff, transparent);
                color: #444;
                gap: 12px;
                font-size: 16px;
                line-height: 1.6em;
                font-style: italic;
                border-color: #cee5ec;
                position: relative;
                transition: 0.4s;
            }
            a.cfk-box.review:hover {
                color: #444;
                transform: scale(1.025);
                border-color: #80d1ea;
            }
            a.cfk-box.review span {
                font-size: 1.2em;
                color: #f16564;
            }
            a.cfk-box.review:before {
                content: "\"";
                font-size: 112px;
                position: absolute;
                top: 15px;
                left: -10px;
            }
        </style>

        <?php
    }  
}