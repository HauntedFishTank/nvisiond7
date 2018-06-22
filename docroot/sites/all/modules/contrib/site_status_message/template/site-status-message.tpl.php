<?php
/**
 * @file
 * This template handles the output of the Site Status Message.
 *
 * Variables available:
 * - $message: The message to display (run through filter_xss).
 * - $link: An optional link to a page with more information.
 */
?>
<div id="site-status" class="site-status-message">
  <strong><?php print $message; ?></strong><?php if ($link): ?> <?php print $link; ?><?php endif; ?>
</div>
