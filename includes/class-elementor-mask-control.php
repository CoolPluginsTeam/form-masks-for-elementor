<?php
// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound
namespace FME\Includes;

use \Elementor\Plugin as ElementorPlugin;
use \Elementor\Controls_Manager as ElementorControls;
use \Elementor\Repeater as ElementorRepeater;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FME_Elementor_Forms_Mask {

	public $allowed_fields = [
		'text',
	];

	public function __construct() {
		add_action( 'elementor/element/form/section_form_fields/before_section_end', [ $this, 'add_mask_control' ], 100, 2 );
		add_filter( 'elementor_pro/forms/render/item', [ $this, 'add_mask_atributes' ], 10, 3 );
	}

	/**
	 * Add mask control
	 *
	 * @since 1.0
	 * @param $element
	 * @param $args
	 */
	public function add_mask_control( $element, $args ) {
		$elementor = ElementorPlugin::instance();
		$control_data = $elementor->controls_manager->get_control_from_stack( $element->get_name(), 'form_fields' );
		$pro_tag = ' <a class="fme-pro-feature" href="https://codecanyon.net/item/form-masks-for-elementor/25872641" target="_blank">' . esc_html__( 'PRO', 'form-masks-for-elementor' ) . '</a>';

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$controls_to_register = [
			'fme_mask_control' => [
				'label' => esc_html__( 'Mask Control', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'mask',
				'options' => [
					'mask' => esc_html__( 'Select Mask', 'form-masks-for-elementor' ),
					'ev-phone' => esc_html__( 'Phone', 'form-masks-for-elementor' ),
					'ev-time' => esc_html__( 'Date & Time', 'form-masks-for-elementor' ),
					'ev-money' => esc_html__( 'Money', 'form-masks-for-elementor' ),
					'ev-ccard' => esc_html__( 'Credit Card', 'form-masks-for-elementor' ),
					'ev-br_fr' => esc_html__( 'Brazilian Formats', 'form-masks-for-elementor' ),
					'ev-ip-address' => esc_html__( 'IP Address', 'form-masks-for-elementor' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_mask_auto_placeholders' => [
				'label' => esc_html__( 'Mask Placeholders', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SWITCHER,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => '',
				'label_on' => esc_html__( 'On', 'form-masks-for-elementor' ),
				'label_off' => esc_html__( 'Off', 'form-masks-for-elementor' ),
				'conditions' => [
					'terms' => [
						[
							'name' => 'fme_mask_control',
							'operator' => 'in',
							'value' => ['ev-phone','ev-cpf','ev-cnpj','ev-money','ev-ccard','ev-cep','ev-time','ev-ip-address','ev-br_fr'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_money_mask_format' => [
				'label' => esc_html__( 'Thousand separator', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'dot',
				'options' => [
					'dot' => esc_html__( 'Dot (.)', 'form-masks-for-elementor' ),
					'comma' => esc_html__( 'Comma (,)', 'form-masks-for-elementor' )
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-money'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_money_mask_prefix' => [
				'label' => esc_html__( 'Mask Prefix', 'form-masks-for-elementor' ),
				'type' => ElementorControls::TEXT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => '',
				'ai'  => [
					'active' => false,
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-money'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_money_mask_decimal_places' => [
				'label' => esc_html__( 'Mask Decimal Places', 'form-masks-for-elementor' ),
				'type' => ElementorControls::TEXT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => '2',
				'ai'  => [
					'active' => false,
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-money'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_time_mask_format' => [
				'label' => esc_html__( 'Date Format', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'one',
				'options' => [
					'three' => esc_html__( 'Date (dd/mm/yyyy)', 'form-masks-for-elementor' ),
					'four' => esc_html__( 'Date (mm/dd/yyyy)', 'form-masks-for-elementor' ),
					'five' => esc_html__( 'DateTime (dd/mm/yyyy hh:mm)', 'form-masks-for-elementor' ),
					'six' => esc_html__( 'DateTime (mm/dd/yyyy hh:mm)', 'form-masks-for-elementor' ),
					'one' => esc_html__( 'Time (hh:mm)', 'form-masks-for-elementor' ),
					'two' => esc_html__( 'Time (hh:mm:ss)', 'form-masks-for-elementor' ),
					'seven' => esc_html__( 'Month/Year (mm/yyyy)', 'form-masks-for-elementor' ),
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-time'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_brazilian_formats' => [
				'label' => esc_html__( 'Select Format', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'fme_cpf',
				'options' => [
					'fme_cpf' => esc_html__( 'CPF', 'form-masks-for-elementor' ),
					'fme_cnpj' => esc_html__( 'CNPJ', 'form-masks-for-elementor' ),
					'fme_cep' => esc_html__( 'CEP', 'form-masks-for-elementor' ),
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-br_fr'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_credit_card_options' => [
				'label' => esc_html__( 'Credit Card Options', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'hyphen',
				'options' => [
					'space' => esc_html__( 'Credit card with space', 'form-masks-for-elementor' ),
					'hyphen' => esc_html__( 'Credit card with hyphen', 'form-masks-for-elementor' ),
					'credit_card_date' => esc_html__( 'Expiry Date (MM/YY)', 'form-masks-for-elementor' ),
					'credit_card_expiry_date' => esc_html__( 'Expiry Date (MM/YYYY)', 'form-masks-for-elementor' ),
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-ccard'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_phone_format' => [
				'label' => esc_html__( 'Phone Format', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'phone_usa',
				'options' => [
					'phone_usa' => esc_html__( 'Phone (USA)', 'form-masks-for-elementor' ),
					'phone_d8' => esc_html__( 'Phone (8-digit)', 'form-masks-for-elementor' ),
					'phone_ddd8' => esc_html__( 'Phone (DDD + 8-digit)', 'form-masks-for-elementor' ),
					'phone_ddd9' => esc_html__( 'Phone (DDD + 9-digit)', 'form-masks-for-elementor' ),
				],
				'conditions' => [
						'terms' => [
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-phone'],
						],
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_mask_alert_pro_version' => [
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'info',
				'content' => esc_html__( '🚀 ', 'form-masks-for-elementor' ) . ' <a href="https://coolformkit.com/?utm_source=fim_plugin&utm_medium=inside&utm_campaign=get_pro&utm_content=get_cool_formkit" target="_blank">' . 'Get Cool FormKit For Advanced Fields.'. '</a>',
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
						[
							'name' => 'fme_mask_control',
							'operator' => 'in',
							'value' => ['ev-phone','ev-cpf','ev-cnpj','ev-money','ev-ccard','ev-cep','ev-time','ev-ip-address','ev-br_fr'],
						],
					],
				],
			],
		];

		if ( ! get_option( 'fme_elementor_notice_dismiss' ) ) {
			$install_date = get_option( 'fme-installDate' ); // Get stored install date
			$current_date = gmdate( 'Y-m-d h:i:s' ); // Get current date
			$date_diff = strtotime( $current_date ) - strtotime( $install_date ); // Calculate difference in seconds
			$days_passed = $date_diff / (60 * 60 * 24); // Convert to days

			if ( $days_passed >= 3 ) {
				$review_nonce = wp_create_nonce( 'cfef_elementor_review' );
				$url          = admin_url( 'admin-ajax.php' );
				$html         = '<div class="cfef_elementor_review_wrapper">';
				$html        .= '<div id="cfef_elementor_review_dismiss" data-url="' . esc_url( $url ) . '" data-nonce="' . esc_attr( $review_nonce ) . '">Close Notice X</div>
								<div class="cfef_elementor_review_msg">' . __( 'Hope this addon solved your problem!', 'form-masks-for-elementor' ) . '<br><a href="https://wordpress.org/support/plugin/form-masks-for-elementor/reviews/#new-post" target="_blank"">Share the love with a ⭐⭐⭐⭐⭐ rating.</a><br><br></div>
								<div class="cfef_elementor_demo_btn"><a href="https://wordpress.org/support/plugin/form-masks-for-elementor/reviews/#new-post" target="_blank">Submit Review</a></div>
								</div>';

				$controls_to_register['fme_pro_image'] = array(
					'name'            => 'fme_pro_image',
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => $html,
					'content_classes' => 'cfef_elementor_review_notice',
					'tab'             => 'content',
					'conditions' => [
						'terms' => [
							[
								'name' => 'field_type',
								'operator' => 'in',
								'value' => $this->allowed_fields,
							],
							[
								'name' => 'fme_mask_control',
								'operator' => 'in',
								'value' => ['ev-phone','ev-cpf','ev-cnpj','ev-money','ev-ccard','ev-cep','ev-time','ev-ip-address','ev-br_fr'],
							],
						],
					],
					'tabs_wrapper' => 'form_fields_tabs',
					'inner_tab' => 'form_fields_advanced_tab',
				);
			}
		}

		

		/**
		 * Filter to pro version change control.
		 *
		 * @since 1.5
		 */
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$controls_to_register = apply_filters( 'fme_after_mask_control_created', $controls_to_register );

		$controls_repeater = new ElementorRepeater();
		foreach ( $controls_to_register as $key => $control ) {
			$controls_repeater->add_control( $key, $control );
		}

		$pattern_field = $controls_repeater->get_controls();

		/**
		 * Register control in form advanced tab.
		 *
		 * @since 1.5.2
		 */
		$this->register_control_in_form_advanced_tab( $element, $control_data, $pattern_field );
	}

	/**
	 * Register control in form advanced tab
	 *
	 * @param object $element
	 * @param array $control_data
	 * @param array $pattern_field
	 * @return void
	 *
	 * @since 1.5.2
	 */
	public function register_control_in_form_advanced_tab( $element, $control_data, $pattern_field ) {
		foreach( $pattern_field as $key => $control ) {

			if( $key !== '_id' ) {

				$new_order = [];
				foreach ( $control_data['fields'] as $field_key => $field ) {

					if ( 'field_value' === $field['name'] ) {
						$new_order[$key] = $control;
					}
					$new_order[ $field_key ] = $field;
				}

				$control_data['fields'] = $new_order;
			}
		}

		return $element->update_control( 'form_fields', $control_data );
	}

	/**
	 * Render/add new mask atributes on input field.
	 *
	 * @since 1.0
	 * @param array $field
	 * @param string $field_index
	 * @return void
	 */
	public function add_mask_atributes( $field, $field_index, $form_widget ) {
		if ( 
			! empty( $field['fme_mask_control'] ) && 
			in_array( $field['field_type'], $this->allowed_fields ) && 
			$field['fme_mask_control'] !== 'mask' 
		) {			

			$form_widget->add_render_attribute( 
				'input' . $field_index, 
				'data-mask', 
				$field['fme_mask_control'] 
			);
	
			$form_widget->add_render_attribute(
				'input' . $field_index,
				'class',
				'fme-mask-input ' .
				'mask_control_@' . $field['fme_mask_control'] . ' ' .
				'money_mask_format_@' . $field['fme_money_mask_format'] . ' ' .
				'mask_prefix_@' . $field['fme_money_mask_prefix'] . ' ' .
				'mask_decimal_places_@' . $field['fme_money_mask_decimal_places'] . ' ' .
				'mask_time_mask_format_@' . $field['fme_time_mask_format'] . ' ' .
				'fme_phone_format_@' . $field['fme_phone_format'] . ' ' .
				'credit_card_options_@' . $field['fme_credit_card_options'] . ' ' . 
				'mask_auto_placeholder_@' . $field['fme_mask_auto_placeholders'] . ' ' .
				'fme_brazilian_formats_@' . $field['fme_brazilian_formats'] 
			);
		}
	
		/**
		 * After mask attribute added
		 *
		 * Action fired to allow pro version to add custom attributes.
		 *
		 * @since 1.5.2
		 */
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound	
		do_action( 'fme_after_mask_attribute_added', $field, $field_index, $form_widget );
	
		return $field;
	}	
}
