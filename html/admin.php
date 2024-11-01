<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap" id="motpr355_woo_new_product_info">

	<h1>
		<?php _e( 'New product info', 'woo-new-product-info' ) ?>
	</h1>

	<h3><?php _e( 'Differentiate WooCommerce new products by displaying a customizable "New" tag.', 'woo-new-product-info' ) ?></h3>

	<noscript>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php _e( 'Please activate JavaScript to edit the configuration.', 'woo-new-product-info' ) ?>
			</p>
		</div>
	</noscript>

	<?php if ( $this->configuration_saved ) { ?>
	<div class="notice notice-success is-dismissible">
		<p>
			<?php _e( 'Configuration saved.', 'woo-new-product-info' ) ?>
		</p>
	</div>
	<?php } ?>

	<form autocomplete="off" method="POST" action="">
		<hr/>
		<p>
			<span>
				<?php _e( 'Activate functionality:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->activation ?>"
						   value="<?php echo $this->activation_enum->actived ?>">
					<span>
						<?php _e( 'Activate', 'woo-new-product-info' ) ?>
					</span>
					<span id="motpr355_woo_new_product_info_activate_arrow">
						<span></span>
						<span></span>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->activation ?>"
						   value="<?php echo $this->activation_enum->deactived ?>">
					<span>
						<?php _e( 'Deactivate', 'woo-new-product-info' ) ?>
					</span>
				</label>
			</span>
		</p>
		<hr/>
		<p>
			<span>
				<?php _e( 'Consider a product as new during:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<select name="<?php echo $this->settings_enum->duration ?>">
					<option value="1"><?php _e( '1 day', 'woo-new-product-info' ) ?></option>
					<?php for ( $i = 2; $i <= 60; $i++ ) { ?>
					<option value="<?php echo $i ?>"><?php printf( __( '%d days', 'woo-new-product-info' ), $i ) ?></option>
					<?php } ?>
				</select>
			</span>
		</p>
		<hr/>
		<p>
			<span>
				<?php _e( 'Text:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->text ?>"
						   value="<?php echo $this->text_enum->new1 ?>">
					<span><?php _e( 'New', 'woo-new-product-info' ) ?></span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->text ?>"
						   value="<?php echo $this->text_enum->new2 ?>">
					<span><?php _e( 'New!', 'woo-new-product-info' ) ?></span>
				</label>
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Background color:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<input type="text"
					   class="input_color"
					   name="<?php echo $this->settings_enum->background_color ?>">
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Color:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<input type="text"
					   class="input_color"
					   name="<?php echo $this->settings_enum->color ?>">
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Font weight:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->font_weight ?>"
						   value="<?php echo $this->font_weight_enum->normal ?>">
					<span><?php _e( 'Normal', 'woo-new-product-info' ) ?></span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->font_weight ?>"
						   value="<?php echo $this->font_weight_enum->bold ?>">
					<span><?php _e( 'Bold', 'woo-new-product-info' ) ?></span>
				</label>
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Text transform:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->text_transform ?>"
						   value="<?php echo $this->text_transform_enum->none ?>">
					<span><?php _e( 'None', 'woo-new-product-info' ) ?></span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->text_transform ?>"
						   value="<?php echo $this->text_transform_enum->lowercase ?>">
					<span><?php _e( 'Lowercase', 'woo-new-product-info' ) ?></span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->text_transform ?>"
						   value="<?php echo $this->text_transform_enum->uppercase ?>">
					<span><?php _e( 'Uppercase', 'woo-new-product-info' ) ?></span>
				</label>
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Position in product list:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->list_position ?>"
						   value="<?php echo $this->list_position_enum->before_name ?>">
					<span>
						<?php _e( 'Before the name product', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->list_position ?>"
						   value="<?php echo $this->list_position_enum->after_name ?>">
					<span>
						<?php _e( 'After the name product', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->list_position ?>"
						   value="<?php echo $this->list_position_enum->after_button ?>">
					<span>
						<?php _e( 'After the "Read more" button', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->list_position ?>"
						   value="<?php echo $this->list_position_enum->none ?>">
					<span>
						<?php _e( 'Don\'t display', 'woo-new-product-info' ) ?>
					</span>
				</label>
			</span>
		</p>
		<p>
			<span>
				<?php _e( 'Position in product page:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->product_position ?>"
						   value="<?php echo $this->product_position_enum->after_name ?>">
					<span>
						<?php _e( 'After the name product', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->product_position ?>"
						   value="<?php echo $this->product_position_enum->after_price ?>">
					<span>
						<?php _e( 'After the price', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->product_position ?>"
						   value="<?php echo $this->product_position_enum->after_button ?>">
					<span>
						<?php _e( 'After the "Add to cart" button', 'woo-new-product-info' ) ?>
					</span>
				</label>
				<label>
					<input type="radio"
						   name="<?php echo $this->settings_enum->product_position ?>"
						   value="<?php echo $this->product_position_enum->none ?>">
					<span>
						<?php _e( 'Don\'t display', 'woo-new-product-info' ) ?>
					</span>
				</label>
			</span>
		</p>
		<hr/>
		<p>
			<span>
				<?php _e( 'Preview:', 'woo-new-product-info' ) ?>
			</span>
			<span>
				<span class="motpr355_woo_new_product_info_classic" id="motpr355_woo_new_product_info_classic_new1">
					<?php _e( 'New', 'woo-new-product-info' ) ?>
				</span>
				<span class="motpr355_woo_new_product_info_classic" id="motpr355_woo_new_product_info_classic_new2">
					<?php _e( 'New!', 'woo-new-product-info' ) ?>
				</span>
			</span>
		</p>
		<hr/>
		<p>
			<?php wp_nonce_field( $this->settings->{$this->settings_enum->nonce}, 'nonce' ) ?>
			<input type="button"
				   class="button button-primary"
				   id="motpr355_woo_new_product_info_submit"
				   value="<?php esc_attr_e( 'Save configuration', 'woo-new-product-info' ) ?>">
		</p>
	</form>

</div>
