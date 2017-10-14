<?php
/**
 * @file
 * Shopping cart template.
 */
?>
<div class="hidden-xs">
  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
  <span class="badge"><?php print $product_count; ?></span>
  <div id="cart-popup" style="display:none;">
    <?php print theme('commerce_cart_block', $variables['variables']); ?>
    <div class="popup-arrow"></div></div>
</div>
