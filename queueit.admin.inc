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
  $form['config']['queueit_cookie_validity'] = array(
    '#type' => 'textfield',
    '#title' => t('Validity of the Queue-it session cookie.'),
    '#description' => t('Optional. Validity of the Queue-it session cookie. Default is 10 minutes.'),
    '#default_value' => variable_get('queueit_cookie_validity'),
    '#element_validate' => ['element_validate_integer_positive'],
  );
  $form['config']['queueit_extend_cookie_validity'] = array(
    '#type' => 'checkbox',
    '#title' => t('Extended validity of session cookie.'),
    '#description' => t('Should the Queue-it session cookie validity time be extended each time the validation runs? By default it is enabled.'),
    '#default_value' => variable_get('queueit_extend_cookie_validity', TRUE),
  );
  $form['config']['queueit_layout_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Name of the queue ticket layout.'),
    '#description' => t('Optional. E.g. "Default layout by Queue-it. Default is to take what is specified on the Event.'),
    '#default_value' => variable_get('queueit_layout_name'),
  );
  $form['config']['queueit_culture_of_layout'] = array(
    '#type' => 'textfield',
    '#title' => t('Culture of the queue ticket layout.'),
    '#description' => t('Culture of the queue ticket layout in the format specified <a href="!url">here</a>.',
      [ '!url' => 'https://msdn.microsoft.com/en-us/library/ee825488(v=cs.20).aspx' ]
      ),
    '#default_value' => variable_get('queueit_culture_of_layout'),
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
