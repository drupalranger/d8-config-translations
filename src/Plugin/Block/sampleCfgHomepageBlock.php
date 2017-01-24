<?php

namespace Drupal\sample_cfg\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Provides a block with homepage CTA links
 *
 * @Block(
 *   id = "sample_cfg_homepage_block",
 *   admin_label = @Translation("sample Homepage - CTA links"),
 * )
 */
class sampleCfgHomepageBlock extends BlockBase {
  /**
   * {@inheritdoc
   * simple usage of block plugin
   * @see https://www.drupal.org/docs/8/creating-custom-modules/create-a-custom-block
   */
  public function build() {
    // load cfg by current language
    $language_manager = \Drupal::languageManager();
    $current_lang = $language_manager->getCurrentLanguage();
    $config = $language_manager->getLanguageConfigOverride( $current_lang->getId(), 'sample_cfg.config');
    $links = $config->get('homepage_links');

    // block skeleton
    $block = array();

    // container - https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Element%21Container.php/class/Container/8.2.x
    $block['wrapper'] = array(
      '#type' => 'container',
      '#attributes' => array(
        'class' => 'sample-homepage-links-wrapper'
      ),
      // item list - http://www.drupalcontrib.org/api/drupal/drupal!core!includes!theme.inc/function/theme_item_list/8
      '#children' => array(
        '#theme' => 'item_list',
        '#items' => array()
      )
    );

    foreach($links as $link){
      // l() is deprecated
      // let's use Drupal\Core\Link::fromTextAndUrl
      // https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Link.php/function/Link%3A%3AfromTextAndUrl/8.2.x
      $block['wrapper']['#children']['#items'][] =  Link::fromTextAndUrl($link['title'], Url::fromUri($link['url']));
    }
    return $block;
  }
}
