<?php
/**
 * @file
 *
*/
?>
<div id="hero-carousel" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php foreach ($hero_images as $slide): ?>
      <div class="item<?php if (isset($slide->status)): ?> <?php print $slide->status; ?><?php endif; ?>">
        <?php print $slide->html; ?>
      </div>
    <?php endforeach; ?>
  </div><!-- /.carousel-inner -->

  <!-- Controls -->
  <a class="left carousel-control" href="#hero-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#hero-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div><!-- #hero-carousel -->
