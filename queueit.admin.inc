<?php

/**
 * @file
 * Configuration of the Queue-it module.
 */

/**
 * Form builder.
 */
function queueit_settings_form($form, &$form_state) {
  $form['config'] = array(
    '#title' => 'Queue-it Configuration',
    '#type' => 'fieldset',
  );
  $form['config']['queueit_event_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Event ID'),
    '#description' => t('Specify ID of the queue to use.'),
    '#default_value' => variable_get('queueit_event_id'),
  );
  $form['config']['queueit_queue_domain'] = array(
    '#type' => 'textfield',
    '#title' => t('Domain name of the queue - usually in the format [CustomerId].queue-it.net.'),
    '#description' => t('Specify ID of the queue to use.'),
    '#default_value' => variable_get('queueit_queue_domain'),
  );
  $form['config']['queueit_cookie_validity_minute'] = array(
    '#type' => 'integer',
    '#title' => t('Validity of the Queue-it session cookie. Default is 10 minutes.'),
    '#description' => t('Specify ID of the queue to use.'),
    '#default_value' => variable_get('queueit_cookie_validity_minute'),
  );
  $form['config']['queueit_extend_cookie_validity'] = array(
    '#type' => 'checkbox',
    '#title' => t('Extended validity of session cookie.'),
    '#description' => t('Should the Queue-it session cookie validity time be extended each time the validation runs? By default it is enabled.'),
    '#default_value' => variable_get('queueit_extend_cookie_validity', TRUE),
  );
  $form['creds'] = array(
    '#title' => 'Queue-it Credentials',
    '#type' => 'fieldset',
  );
  $form['creds']['queueit_api_key'] = array(
    '#type' => 'textfield',
    '#title' => t('API Key'),
    '#description' => t('Specify the Api-key which can be supplied through the query string parameter. The key can be found in the GO Queue-it Platform.'),
    '#default_value' => variable_get('queueit_api_key'),
  );
  $form['creds']['queueit_customer_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Customer ID'),
    '#description' => t('Your Queue-it customer ID.'),
    '#default_value' => variable_get('queueit_customer_id'),
  );
  $form['creds']['queueit_secret_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Secret key'),
    '#description' => t('Your 72 char secret key as specified in Go Queue-it self-service platform.'),
    '#default_value' => variable_get('queueit_secret_key'),
  );

  return system_settings_form($form);
}
