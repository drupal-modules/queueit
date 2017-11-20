<?php

/**
 * @file
 * Configuration of the Queue-it module.
 */

/**
 * Form builder.
 */
function queueit_settings_form($form, &$form_state) {
  $form['queueit_api_key'] = array(
    '#type' => 'textfield',
    '#title' => t('API Key'),
    '#description' => t('Specify the Api-key which can be supplied through the query string parameter. The key can be found in the GO Queue-it Platform.'),
    '#default_value' => variable_get('queueit_api_key'),
    '#required' => TRUE,
  );

  return system_settings_form($form);
}
