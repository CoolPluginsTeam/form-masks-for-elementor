<?php
//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound	
namespace FME\Includes\AtomicForm\Input;

use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control;
use Elementor\Modules\AtomicWidgets\Controls\Types\Text_Control;
use Elementor\Modules\AtomicWidgets\PropDependencies\Manager as Dependency_Manager;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type;
use Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Input mask props and controls for the atomic Input widget (text type only).
 */
final class Mask_Input_Definition {

	public static function text_only_dependencies(): ?array {
		return Dependency_Manager::make()
			->where(
				[
					'operator' => 'eq',
					'path' => [ 'type' ],
					'value' => 'text',
					'effect' => 'hide',
				]
			)
			->get();
	}

	/**
	 * @return array<string, mixed>|null
	 */
	private static function text_and_mask_dependencies( string $mask_value ): ?array {
		return Dependency_Manager::make( Dependency_Manager::RELATION_AND )
			->where(
				[
					'operator' => 'eq',
					'path' => [ 'type' ],
					'value' => 'text',
					'effect' => 'hide',
				]
			)
			->where(
				[
					'operator' => 'eq',
					'path' => [ 'fme_mask_control' ],
					'value' => $mask_value,
					'effect' => 'hide',
				]
			)
			->get();
	}

	/**
	 * @return array<string, mixed>|null
	 */
	private static function mask_placeholder_dependencies(): ?array {
		$mask_terms = [];
		foreach ( [ 'ev-phone', 'ev-time', 'ev-money', 'ev-ccard', 'ev-ip-address', 'ev-br_fr' ] as $m ) {
			$mask_terms[] = [
				'operator' => 'eq',
				'path' => [ 'fme_mask_control' ],
				'value' => $m,
			];
		}

		return Dependency_Manager::make( Dependency_Manager::RELATION_AND )
			->where(
				[
					'operator' => 'eq',
					'path' => [ 'type' ],
					'value' => 'text',
					'effect' => 'hide',
				]
			)
			->where(
				[
					'terms' => $mask_terms,
					'relation' => Dependency_Manager::RELATION_OR,
					'effect' => 'hide',
				]
			)
			->get();
	}

	/**
	 * @return array<string, mixed>
	 */
	public static function props_schema(): array {
		$text_only = self::text_only_dependencies();

		return [
			'fme_mask_control' => String_Prop_Type::make()
				->set_dependencies( $text_only )
				->default( 'mask' )
				->enum(
					[
						'mask',
						'ev-phone',
						'ev-time',
						'ev-money',
						'ev-ccard',
						'ev-br_fr',
						'ev-ip-address',
					]
				),
			'fme_mask_auto_placeholders' => Boolean_Prop_Type::make()
				->set_dependencies( self::mask_placeholder_dependencies() )
				->default( false ),
			'fme_money_mask_format' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-money' ) )
				->default( 'dot' )
				->enum( [ 'dot', 'comma' ] ),
			'fme_money_mask_prefix' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-money' ) )
				->default( '' ),
			'fme_money_mask_decimal_places' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-money' ) )
				->default( '2' ),
			'fme_time_mask_format' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-time' ) )
				->default( 'one' )
				->enum( [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven' ] ),
			'fme_brazilian_formats' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-br_fr' ) )
				->default( 'fme_cpf' )
				->enum( [ 'fme_cpf', 'fme_cnpj', 'fme_cep' ] ),
			'fme_credit_card_options' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-ccard' ) )
				->default( 'hyphen' )
				->enum( [ 'space', 'hyphen', 'credit_card_date', 'credit_card_expiry_date' ] ),
			'fme_phone_format' => String_Prop_Type::make()
				->set_dependencies( self::text_and_mask_dependencies( 'ev-phone' ) )
				->default( 'phone_usa' )
				->enum( [ 'phone_usa', 'phone_d8', 'phone_ddd8', 'phone_ddd9' ] ),
		];
	}

	/**
	 * @return array<int, mixed>
	 */
	public static function content_controls(): array {
		$mask_options = [
			[
				'label' => esc_html__( 'Select Mask', 'form-masks-for-elementor' ),
				'value' => 'mask',
			],
			[
				'label' => esc_html__( 'Phone', 'form-masks-for-elementor' ),
				'value' => 'ev-phone',
			],
			[
				'label' => __( 'Date & Time', 'form-masks-for-elementor' ),
				'value' => 'ev-time',
			],
			[
				'label' => esc_html__( 'Money', 'form-masks-for-elementor' ),
				'value' => 'ev-money',
			],
			[
				'label' => esc_html__( 'Credit Card', 'form-masks-for-elementor' ),
				'value' => 'ev-ccard',
			],
			[
				'label' => esc_html__( 'Brazilian Formats', 'form-masks-for-elementor' ),
				'value' => 'ev-br_fr',
			],
			[
				'label' => esc_html__( 'IP Address', 'form-masks-for-elementor' ),
				'value' => 'ev-ip-address',
			],
		];

		/**
		 * Extend mask type options (e.g. pro add-ons).
		 *
		 * @param array<int, array{label: string, value: string}> $mask_options
		 */
		//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$mask_options = apply_filters( 'fme_atomic_mask_control_options', $mask_options );

		return [
			Select_Control::bind_to( 'fme_mask_control' )
				->set_label( esc_html__( 'Mask Control', 'form-masks-for-elementor' ) )
				->set_options( $mask_options ),
			Switch_Control::bind_to( 'fme_mask_auto_placeholders' )
				->set_label( esc_html__( 'Mask Placeholders', 'form-masks-for-elementor' ) ),
			Select_Control::bind_to( 'fme_money_mask_format' )
				->set_label( esc_html__( 'Thousand separator', 'form-masks-for-elementor' ) )
				->set_options(
					[
						[
							'label' => esc_html__( 'Dot (.)', 'form-masks-for-elementor' ),
							'value' => 'dot',
						],
						[
							'label' => esc_html__( 'Comma (,)', 'form-masks-for-elementor' ),
							'value' => 'comma',
						],
					]
				),
			Text_Control::bind_to( 'fme_money_mask_prefix' )
				->set_label( esc_html__( 'Mask Prefix', 'form-masks-for-elementor' ) ),
			Text_Control::bind_to( 'fme_money_mask_decimal_places' )
				->set_label( esc_html__( 'Mask Decimal Places', 'form-masks-for-elementor' ) ),
			Select_Control::bind_to( 'fme_time_mask_format' )
				->set_label( esc_html__( 'Date Format', 'form-masks-for-elementor' ) )
				->set_options(
					[
						[
							'label' => esc_html__( 'Date (dd/mm/yyyy)', 'form-masks-for-elementor' ),
							'value' => 'three',
						],
						[
							'label' => esc_html__( 'Date (mm/dd/yyyy)', 'form-masks-for-elementor' ),
							'value' => 'four',
						],
						[
							'label' => esc_html__( 'DateTime (dd/mm/yyyy hh:mm)', 'form-masks-for-elementor' ),
							'value' => 'five',
						],
						[
							'label' => esc_html__( 'DateTime (mm/dd/yyyy hh:mm)', 'form-masks-for-elementor' ),
							'value' => 'six',
						],
						[
							'label' => esc_html__( 'Time (hh:mm)', 'form-masks-for-elementor' ),
							'value' => 'one',
						],
						[
							'label' => esc_html__( 'Time (hh:mm:ss)', 'form-masks-for-elementor' ),
							'value' => 'two',
						],
						[
							'label' => esc_html__( 'Month/Year (mm/yyyy)', 'form-masks-for-elementor' ),
							'value' => 'seven',
						],
					]
				),
			Select_Control::bind_to( 'fme_brazilian_formats' )
				->set_label( esc_html__( 'Select Format', 'form-masks-for-elementor' ) )
				->set_options(
					[
						[
							'label' => esc_html__( 'CPF', 'form-masks-for-elementor' ),
							'value' => 'fme_cpf',
						],
						[
							'label' => esc_html__( 'CNPJ', 'form-masks-for-elementor' ),
							'value' => 'fme_cnpj',
						],
						[
							'label' => esc_html__( 'CEP', 'form-masks-for-elementor' ),
							'value' => 'fme_cep',
						],
					]
				),
			Select_Control::bind_to( 'fme_credit_card_options' )
				->set_label( esc_html__( 'Credit Card Options', 'form-masks-for-elementor' ) )
				->set_options(
					[
						[
							'label' => esc_html__( 'Credit card with space', 'form-masks-for-elementor' ),
							'value' => 'space',
						],
						[
							'label' => esc_html__( 'Credit card with hyphen', 'form-masks-for-elementor' ),
							'value' => 'hyphen',
						],
						[
							'label' => esc_html__( 'Expiry Date (MM/YY)', 'form-masks-for-elementor' ),
							'value' => 'credit_card_date',
						],
						[
							'label' => esc_html__( 'Expiry Date (MM/YYYY)', 'form-masks-for-elementor' ),
							'value' => 'credit_card_expiry_date',
						],
					]
				),
			Select_Control::bind_to( 'fme_phone_format' )
				->set_label( esc_html__( 'Phone Format', 'form-masks-for-elementor' ) )
				->set_options(
					[
						[
							'label' => esc_html__( 'Phone (USA)', 'form-masks-for-elementor' ),
							'value' => 'phone_usa',
						],
						[
							'label' => esc_html__( 'Phone (8-digit)', 'form-masks-for-elementor' ),
							'value' => 'phone_d8',
						],
						[
							'label' => esc_html__( 'Phone (DDD + 8-digit)', 'form-masks-for-elementor' ),
							'value' => 'phone_ddd8',
						],
						[
							'label' => esc_html__( 'Phone (DDD + 9-digit)', 'form-masks-for-elementor' ),
							'value' => 'phone_ddd9',
						],
					]
				),
		];
	}
}
