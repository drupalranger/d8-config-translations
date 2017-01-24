<?php

namespace Drupal\sample_cfg\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form for homepage configuration.
 */
class sampleCfgHomepageForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sample_cfg_home_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sample_cfg.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('sample_cfg.config');
    $links = $config->get('homepage_links');

    $form['homepage_links'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Homepage links'),
    );

    $form['homepage_links']['table'] = array(
      '#type' => 'table',
      '#header' => array( $this->t('Link title'), $this->t('URL')),
      '#caption' => $this->t('Please fill up fields below to modify CTA links displayed on the homepage.')
    );

    // run through configured links and provide form widgets for each of em
    foreach($links as $i => $link){
      $form['homepage_links']['table'][$i]['title'] = array(
        '#type' => 'textfield',
        '#attributes' => array(
          'placeholder' => $this->t('Title')
        ),
        '#required' => TRUE,
        '#default_value' => $link['title']
      );

      $form['homepage_links']['table'][$i]['url'] = array(
        '#type' => 'url',
        '#attributes' => array(
          'placeholder' => $this->t('URL')
        ),
        '#required' => TRUE,
        '#default_value' => $link['url']
      );
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $language_manager = \Drupal::languageManager();
    $current_lang = $language_manager->getCurrentLanguage();

    // to save translated config object we, e.g. when user is using form on /nl page
    // w need to load editable object using language manager:
    // http://flocondetoile.fr/blog/translate-programmatically-drupal-8
    // it's also because by default we've got immutable configuration object:
    // https://www.drupal.org/node/2407153
    // saving configuration using default method ( e.g. https://www.drupal.org/docs/8/api/configuration-api/working-with-configuration-forms )
    // will throw and exception
    $config = $language_manager->getLanguageConfigOverride( $current_lang->getId(), 'sample_cfg.config');
    $config->set('homepage_links', $values['table'])->save();
  }
}
