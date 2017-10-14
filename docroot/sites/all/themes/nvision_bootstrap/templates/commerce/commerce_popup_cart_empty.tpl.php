<?php
/**
 * @file
 * Shopping cart template.
 */
?>
<div class="hidden-xs">
  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
  <span class="badge"></span>
  <div id="cart-popup" style="display:none;">
    <?php print $empty_cart_message; ?>
    <div class="popup-arrow"></div></div>
</div>
