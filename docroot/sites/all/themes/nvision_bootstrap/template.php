<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/**
 * Returns HTML for status and/or error messages, grouped by type.
 *
 * An invisible heading identifies the messages for assistive technology.
 * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html
 * for info.
 *
 * @param array $variables
 *     An associative array containing:
 *     - display: (optional) Set to 'status' or 'error' to display only messages
 *     of that type.
 *
 * @return string
 *   The constructed HTML.
 *
 * @see     theme_status_messages()
 * @see     bootstrap_status_messages()
 *
 * @ingroup theme_functions
 */
function nvision_bootstrap_status_messages($variables) {
  global $user;
  $user_id = $user->uid;

  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status'  => t('Status message'),
    'error'   => t('Error message'),
    'warning' => t('Warning message'),
    'info'    => t('Informative message'),
  );

  // Map Drupal message types to their corresponding Bootstrap classes.
  // @see http://twitter.github.com/bootstrap/components.html#alerts
  $status_class = array(
    'status'  => 'success',
    'error'   => 'danger',
    'warning' => 'warning',
    // Not supported, but in theory a module could send any type of message.
    // @see drupal_set_message()
    // @see theme_status_messages()
    'info'    => 'info',
  );

  // Retrieve messages.
  $message_list = drupal_get_messages($display);

  // Allow the disabled_messages module to filter the messages, if enabled.
  if (module_exists('disable_messages') && variable_get('disable_messages_enable', '1')) {
    $message_list = disable_messages_apply_filters($message_list);
  }

  foreach ($message_list as $type => $messages) {
    $class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';
    $output .= "<div class=\"alert alert-block$class messages $type\">\n";
    $output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";

    if (!empty($status_heading[$type])) {
      if (module_exists('devel') && $user_id == 1) {
        $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
      }
      else {
        $output .= '<h4 class="element-invisible">' . _bootstrap_filter_xss($status_heading[$type]) . "</h4>\n";
      }
    }

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        if (module_exists('devel') && $user_id == 1) {
          $output .= '  <li>' . $message . "</li>\n";
        }
        else {
          $output .= '  <li>' . _bootstrap_filter_xss($message) . "</li>\n";
        }
      }
      $output .= " </ul>\n";
    }
    else {
      if (module_exists('devel') && $user_id == 1) {
        $output .= $messages[0];
      }
      else {
        $output .= _bootstrap_filter_xss($messages[0]);
      }
    }

    $output .= "</div>\n";
  }
  return $output;
}

/**
 * Implements template_preprocess_page().
 */
function nvision_bootstrap_preprocess_page(&$variables) {
  // Add custom template page for About page.
  if (isset($variables['node']->title) && ($variables['node']->title === t('About') || $variables['node']->title === t('Error!') || $variables['node']->title === t('Access Denied!'))) {
    $variables['theme_hook_suggestions'][] = 'page__about';
    drupal_set_title('');
  }

  // Force empty regions to show on the Contact Page.
  if (isset($variables['node']->title) && in_array($variables['node']->title, _nvision_bootstrap_narrow_pages())) {
    if (empty($variables['page']['sidebar_first']) && empty($variables['page']['sidebar_second'])) {
      $variables['page']['sidebar_first'] = array(
        '#region' => 'sidebar_first',
        '#markup' => '',
      );
      $variables['page']['sidebar_second'] = array(
        '#region' => 'sidebar_second',
        '#markup' => '',
      );
      $variables['content_column_class'] = ' class="col-sm-8"';
    }
  }

  // Remove the standard no front page content message from home page.
  if ($variables['is_front']) {
    //drupal_set_title(t('@site-name', array('@site-name' => variable_get('site_name', 'Nvision Athletics'))), PASS_THROUGH);
    drupal_set_title('');
    unset($variables['page']['content']['system_main']);
  }

  // Hacky way to get the product count on mobiles.
  $variables['product_count'] = _nvision_core_get_cart_quantity();
}

/**
 * Helper function for narrow Basic Pages.
 * @todo make configurable...?
 *
 * @return array
 */
function _nvision_bootstrap_narrow_pages() {
  return array(
    t('Contact Us'),
    t('Shipping and Delivery'),
    t('Returns and Exchanges'),
    t('Frequently Asked Questions'),
    t('Size Guide'),
    t('Website Privacy Policy'),
    t('Terms and Conditions for Use and Sales'),
  );
}

/**
 * Implements template_preprocess_node().
 */
function nvision_bootstrap_preprocess_node(&$variables) {
  if ($variables['type'] === 'product') {
    if (isset($variables['field_product_image'])) {
      $variables['num_images'] = count($variables['field_product_image']);
    }
    if ($variables['view_mode'] == 'full') {
      $variables['product_quicktabs'] = quicktabs_build_quicktabs('product_details');
    }
    if ($variables['view_mode'] == 'teaser') {
      $variables['title_attributes_array']['class'][] = 'product-teaser-title';
    }

  }
}

/**
 * Implements template_preprocess_entity().
 */
function nvision_bootstrap_preprocess_entity(&$variables) {
  switch ($variables['entity_type']) {
    case 'paragraphs_item':
      $paragraph = $variables['paragraphs_item'];
      $bundle = $paragraph->bundle;

      if ($bundle == 'full_width_image_with_text') {
        $field = field_get_items('paragraphs_item', $paragraph, 'field_paragraph_text_position');
        $first_field = reset($field);
        $variables['text_position'] = check_plain($first_field['value']);
      }

      break;
  }

}

/**
 * Implements template_bootstrap_iconize_text_alter().
 */
function nvision_bootstrap_bootstrap_iconize_text_alter(&$texts) {
  $texts['matches'][t('Add to cart')] = 'shopping-cart';
  $texts['matches'][t('Send')] = 'envelope';
}
