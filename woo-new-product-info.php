<?php
/*
Plugin Name: WooCommerce new product info
Description: Differentiate WooCommerce new products by displaying a customizable "New" tag.
Version: 1.0.10
Author: Motpr355
Text Domain: woo-new-product-info
Domain Path: /languages/
License: GPLv2 or later
WC requires at least: 3.4.3
WC tested up to: 5.4.1
*/

class Motpr355_Woo_New_Product_Info {

	private $configuration_saved;
	private $settings;
	private $settings_enum;
	private $activation_enum;
	private $text_enum;
	private $font_weight_enum;
	private $text_transform_enum;
	private $list_position_enum;
	private $product_position_enum;
	private $display_info_content;

	public function __construct() {

		$this->init_data();

		register_activation_hook( __FILE__, array( 'Motpr355_Woo_New_Product_Info', 'install' ) );

		add_action( 'activated_plugin', array( $this, 'installed' ) );

		register_uninstall_hook( __FILE__, array( 'Motpr355_Woo_New_Product_Info', 'uninstall' ) );

		add_filter( 'auto_update_plugin', array( $this, 'update_plugin' ), 20, 2 );

		add_action( 'admin_menu', array( $this, 'get_admin_menu' ) );

		add_action( 'plugins_loaded', array( $this, 'get_languages' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'get_admin_scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'get_admin_styles' ) );

		if ( function_exists( 'plugin_basename' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_add_settings_link' ) );
		}

		$this->init_website_content();

	}

	public function plugin_add_settings_link( $links ) {
		$links[] = '<a href="edit.php?post_type=product&page=motpr355_woo_new_product_info" id="motpr355_woo_new_product_info">' . __( 'Settings' ) . '</a>';
		return $links;
	}

	private function init_data() {
		$this->settings_enum = ( object ) array(
			'nonce' => 'nonce',
			'activation' => 'activation',
			'duration' => 'duration',
			'text' => 'text',
			'background_color' => 'background_color',
			'color' => 'color',
			'font_weight' => 'font_weight',
			'text_transform' => 'text_transform',
			'list_position' => 'list_position',
			'product_position' => 'product_position'
		);
		$this->activation_enum = ( object ) array(
			'actived' => 'actived',
			'deactived' => 'deactived'
		);
		$this->text_enum = ( object ) array(
			'new1' => 'New',
			'new2' => 'New!'
		);
		$this->font_weight_enum = ( object ) array(
			'normal' => 'normal',
			'bold' => 'bold'
		);
		$this->text_transform_enum = ( object ) array(
			'none' => 'none',
			'lowercase' => 'lowercase',
			'uppercase' => 'uppercase'
		);
		$this->list_position_enum = ( object ) array(
			'before_name' => 'before_name',
			'after_name' => 'after_name',
			'after_button' => 'after_button',
			'none' => 'none'
		);
		$this->product_position_enum = ( object ) array(
			'after_name' => 'after_name',
			'after_price' => 'after_price',
			'after_button' => 'after_button',
			'none' => 'none'
		);

		$this->configuration_saved = false;
		$this->settings = $this->get_settings();
	}

	private function init_website_content() {
		if ( isset ( $this->settings->{$this->settings_enum->activation},
			$this->settings->{$this->settings_enum->list_position},
			$this->settings->{$this->settings_enum->product_position} ) ) {
			if ( $this->settings->{$this->settings_enum->activation} === $this->activation_enum->actived ) {
				add_action( 'wp_head', array( $this, 'display_website_style' ) );
				if ( $this->settings->{$this->settings_enum->list_position} === $this->list_position_enum->before_name ) {
					add_action( 'woocommerce_shop_loop_item_title', array( $this, 'display_website_info' ), 9 );
				} else if ( $this->settings->{$this->settings_enum->list_position} === $this->list_position_enum->after_name ) {
					add_action( 'woocommerce_shop_loop_item_title', array( $this, 'display_website_info' ), 11 );
				} else if ( $this->settings->{$this->settings_enum->list_position} === $this->list_position_enum->after_button ) {
					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'display_website_info' ), 11 );
				}
				if ( $this->settings->{$this->settings_enum->product_position} === $this->product_position_enum->after_name ) {
					add_action( 'woocommerce_single_product_summary', array( $this, 'display_website_info' ), 6 );
				} else if ( $this->settings->{$this->settings_enum->product_position} === $this->product_position_enum->after_price ) {
					add_action( 'woocommerce_single_product_summary', array( $this, 'display_website_info' ), 11 );
				} else if ( $this->settings->{$this->settings_enum->product_position} === $this->product_position_enum->after_button ) {
					add_action( 'woocommerce_single_product_summary', array( $this, 'display_website_info' ), 31 );
				}
			}
		}
	}

	public function display_website_info() {
		if ( function_exists( 'get_the_date' ) ) {
			$limit_time = time() - ( $this->settings->{$this->settings_enum->duration} * 60 * 60 * 24 );
			$published_time = strtotime( get_the_date( 'Y-m-d' ) );
			if ( $published_time - $limit_time > 0 ) {
				if ( isset ( $this->settings->{$this->settings_enum->text} ) ) {
					echo $this->get_display_info_content();
				}
			}
		}
	}

	public function display_website_style() {
		if ( isset ( $this->settings->{$this->settings_enum->background_color},
			$this->settings->{$this->settings_enum->color},
			$this->settings->{$this->settings_enum->font_weight},
			$this->settings->{$this->settings_enum->text_transform} ) ) {
			include plugin_dir_path( __FILE__ ) . 'css/website.php';
		}
	}

	private function get_display_info_content() {
		if ( isset ( $this->display_info_content ) ) {
			return $this->display_info_content;
		}
		if ( function_exists( 'ob_start' ) && function_exists( 'ob_get_clean' ) ) {
			ob_start();
			include plugin_dir_path( __FILE__ ) . 'html/website.php';
			$this->display_info_content = ob_get_clean();
			return $this->display_info_content;
		}
		return '';
	}

	public static function install() {
		$nonce = 'motpr355_woo_new_product_info';
		$chars = array_merge(
			range( 'A','Z' ),
			range( 'a','z' ),
			range( '0','9' )
		);
		$max = count( $chars ) - 1;
		for ( $i = 0; $i < 25; $i++ ) {
			$rand = mt_rand( 0, $max );
			$nonce .= $chars[ $rand ];
		}
		$settings = array(
			'nonce' => $nonce,
			'activation' => 'deactived',
			'duration' => '8',
			'text' => 'New',
			'background_color' => '#000000',
			'color' => '#ffffff',
			'font_weight' => 'bold',
			'text_transform' => 'none',
			'list_position' => 'after_name',
			'product_position' => 'after_name'
		);
		update_option( 'motpr355_woo_new_product_info_settings', $settings );
	}

	public function installed( $plugin ) {
	    if( $plugin === plugin_basename( __FILE__ ) && is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		    exit( wp_redirect( admin_url( 'edit.php?post_type=product&page=motpr355_woo_new_product_info' ) ) );
	    }
	}

	public static function uninstall() {
		delete_option( 'motpr355_woo_new_product_info_settings' );
	}

	public function update_plugin( $update, $item ) {
		$plugins = array(
			'woo-new-product-info/woo-new-product-info.php',
			'woo-new-product-info',
			'woo-new-product-info.php'
		);
		if ( isset( $item->slug ) && in_array( $item->slug, $plugins ) ) {
			return true;
		} else {
			return $update;
		}
	}

	public function get_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=product',
			__( 'New product info', 'woo-new-product-info' ),
			__( 'New product info', 'woo-new-product-info' ),
			'administrator',
			'motpr355_woo_new_product_info',
			array( $this, 'plugin_content' )
		);
	}

	public function get_languages() {
		load_plugin_textdomain(
			'woo-new-product-info',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	public function get_admin_scripts() {
		$is_on_admin_plugin_page = $this->is_on_admin_plugin_page();
		$is_on_admin_extensions_page = $this->is_on_admin_extensions_page();
		if ( $is_on_admin_plugin_page || $is_on_admin_extensions_page ) {
			if ( $is_on_admin_plugin_page ) {
				$this->save_configuration();
				wp_enqueue_style( 'wp-color-picker' );
				wp_register_script(
					'motpr355_woo_new_product_info_script',
					plugins_url( 'js/admin.js', __FILE__ ),
					array( 'wp-color-picker' ),
					'1.0.10',
					true
				);
				wp_localize_script(
					'motpr355_woo_new_product_info_script',
					'motpr355_woo_new_product_info_settings',
					( array ) $this->settings
				);
			} else {
				wp_register_script(
					'motpr355_woo_new_product_info_script',
					plugins_url( 'js/admin-extensions.js', __FILE__ ),
					array(),
					'1.0.10',
					true
				);
				wp_localize_script(
					'motpr355_woo_new_product_info_script',
					'motpr355_woo_new_product_info_translations',
					array(
						'woo_inactive' => __(
							'WooCommerce must be actived',
							'woo-new-product-info'
						),
						'woo_not_found' => __(
							'WooCommerce must be installed',
							'woo-new-product-info'
						)
					)
				);
			}
			wp_enqueue_script( 'motpr355_woo_new_product_info_script' );
		}
	}

	public function get_admin_styles() {
		if ( $this->is_on_admin_plugin_page() ) {
			wp_register_style(
				'motpr355_woo_new_product_info_style',
				plugins_url( 'css/admin.css', __FILE__ ),
				array(),
				'1.0.10'
			);
			wp_enqueue_style( 'motpr355_woo_new_product_info_style' );
		}
	}

	private function is_on_admin_plugin_page() {
		return $this->is_on_admin_page( 'product_page_motpr355_woo_new_product_info' );
	}

	private function is_on_admin_extensions_page() {
		return $this->is_on_admin_page( 'plugins' );
	}

	private function is_on_admin_page( $page ) {
		if ( function_exists( 'get_current_screen' ) ) {
			$current_screen = get_current_screen();
			if ( isset( $current_screen->base ) ) {
				return is_admin() && $current_screen->base === $page;
			}
		}
		return false;
	}

	private function save_configuration() {
		if ( isset ( $_POST[ 'nonce' ], $_POST[ 'activation' ], $_POST[ 'duration' ], $_POST[ 'text' ],
			$_POST[ 'background_color' ], $_POST[ 'color' ], $_POST[ 'font_weight' ],
			$_POST[ 'text_transform' ], $_POST[ 'list_position' ], $_POST[ 'product_position' ] ) ) {
			$nonce = $this->get_cleaned_posted_data( $_POST[ 'nonce' ] );
			$saved_nonce = $this->settings->{$this->settings_enum->nonce};
			if ( wp_verify_nonce( $nonce, $saved_nonce ) ) {
				$activation = $this->get_cleaned_activation( $_POST[ 'activation' ] );
				$duration = $this->get_cleaned_duration( $_POST[ 'duration' ] );
				$text = $this->get_cleaned_text( $_POST[ 'text' ] );
				$background_color = $this->get_cleaned_background_color( $_POST[ 'background_color' ] );
				$color = $this->get_cleaned_color( $_POST[ 'color' ] );
				$font_weight = $this->get_cleaned_font_weight( $_POST[ 'font_weight' ] );
				$text_transform = $this->get_cleaned_text_transform( $_POST[ 'text_transform' ] );
				$list_position = $this->get_cleaned_list_position( $_POST[ 'list_position' ] );
				$product_position = $this->get_cleaned_product_position( $_POST[ 'product_position' ] );
				if ( $activation !== false && $duration !== false && $text !== false
					&& $background_color !== false && $color !== false && $font_weight !== false
					&& $text_transform !== false && $list_position !== false && $product_position !== false ) {
					$settings = array(
						'nonce' => $saved_nonce,
						'activation' => $activation,
						'duration' => $duration,
						'text' => $text,
						'background_color' => $background_color,
						'color' => $color,
						'font_weight' => $font_weight,
						'text_transform' => $text_transform,
						'list_position' => $list_position,
						'product_position' => $product_position
					);
					update_option( 'motpr355_woo_new_product_info_settings', $settings );
					$this->configuration_saved = true;
					$this->settings = $this->get_settings();
				}
			}
		}
	}

	private function get_cleaned_activation( $activation ) {
		$activation = $this->get_cleaned_posted_data( $activation );
		return in_array( $activation, ( array ) $this->activation_enum ) ? $activation : false;
	}

	private function get_cleaned_duration( $duration ) {
		$duration = ( int ) $this->get_cleaned_posted_data( $duration );
		return $duration >= 1 && $duration <= 60 ? $duration : false;
	}

	private function get_cleaned_text( $text ) {
		$text = $this->get_cleaned_posted_data( $text );
		return in_array( $text, ( array ) $this->text_enum ) ? $text : false;
	}

	private function get_cleaned_background_color( $background_color ) {
		$background_color = $this->get_cleaned_posted_color_data( $background_color );
		return $this->check_color_format( $background_color ) ? $background_color : false;
	}

	private function get_cleaned_color( $color ) {
		$color = $this->get_cleaned_posted_color_data( $color );
		return $this->check_color_format( $color ) ? $color : false;
	}

	private function get_cleaned_font_weight( $font_weight ) {
		$font_weight = $this->get_cleaned_posted_data( $font_weight );
		return in_array( $font_weight, ( array ) $this->font_weight_enum ) ? $font_weight : false;
	}

	private function get_cleaned_text_transform( $text_transform ) {
		$text_transform = $this->get_cleaned_posted_data( $text_transform );
		return in_array( $text_transform, ( array ) $this->text_transform_enum ) ? $text_transform : false;
	}

	private function get_cleaned_list_position( $list_position ) {
		$list_position = $this->get_cleaned_posted_data( $list_position );
		return in_array( $list_position, ( array ) $this->list_position_enum ) ? $list_position : false;
	}

	private function get_cleaned_product_position( $product_position ) {
		$product_position = $this->get_cleaned_posted_data( $product_position );
		return in_array( $product_position, ( array ) $this->product_position_enum ) ? $product_position : false;
	}

	private function get_cleaned_posted_data( $data ) {
		return stripslashes_deep( sanitize_text_field( $data ) );
	}

	private function get_cleaned_posted_color_data( $data ) {
		return stripslashes_deep( sanitize_hex_color( $data ) );
	}


	private function check_color_format( $color ) {
		if ( ( strlen ( $color ) !== 4 && strlen ( $color ) !== 7 )
			|| substr( $color, 0, 1 ) !== '#' ) {
			return false;
		}
		return ctype_xdigit( substr( $color, 1 ) );
	}

	private function get_settings() {
		return ( object ) get_option( 'motpr355_woo_new_product_info_settings', array() );
	}

	public function plugin_content() {
		include_once plugin_dir_path( __FILE__ ) . 'html/admin.php';
	}

}

if ( defined( 'ABSPATH' ) ) {
	new Motpr355_Woo_New_Product_Info();
}
