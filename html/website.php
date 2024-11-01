<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="motpr355_woo_new_product_info_div">
	<span class="motpr355_woo_new_product_info_span">
		<?php
		if ( $this->settings->{$this->settings_enum->text} === $this->text_enum->new1 ) {
			_e( 'New', 'woo-new-product-info' );
		} else {
			_e( 'New!', 'woo-new-product-info' );
		}
		?>
	</span>
</div>
