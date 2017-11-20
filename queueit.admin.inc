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
  );
  $form['queueit_customer_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Customer ID'),
    '#description' => t('Your Queue-it customer ID.'),
    '#default_value' => variable_get('queueit_customer_id'),
  );
  $form['queueit_secret_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Secret key'),
    '#description' => t('Your 72 char secret key as specified in Go Queue-it self-service platform.'),
    '#default_value' => variable_get('queueit_secret_key'),
  );

  return system_settings_form($form);
}
