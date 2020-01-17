<?php

namespace Drupal\agent_validation\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form;
use Drupal\Core\Database\Database;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class AgentValidationForm.
 */
class AgentValidationForm extends FormBase {
  /**
   * {@inheritdoc}
   */
	public function getFormId() {
		return 'agent_admin_form';
	}
  /**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form = array();
		$form['agent_validation'] = array(
			'#type' => 'fieldset',
			'#title' => t('Agent Validation Settings'),
			'#description' => t('Settings for the cron to import the CSV at each night at midnight.'),
			'#collapsible' => FALSE
		);
		$form['agent_validation']['agent_validation_from_email'] = array(
			'#type' => 'textfield',
			'#title' => t('From Email Address'),
			'#default_value' => \Drupal::state()->get('agent_validation_from_email'),
			'#description' => t('ex: Test &lt;no-reply@yourmedicaresolutions.com&gt;')
		);
		$form['agent_validation']['agent_validation_email_adds'] = array(
			'#type' => 'textfield',
			'#title' => t('Email Address for Cron'),
			'#default_value' => \Drupal::state()->get('agent_validation_email_adds'),
			'#description' => t('Email addresses to send status email to for cron. Comma separate multiple email addresses.')
		);
		$form['agent_validation']['agent_validation_file_directory'] = array(
			'#type' => 'textfield',
			'#title' => t('File Directory Folder'),
			'#default_value' => \Drupal::state()->get('agent_validation_file_directory'),
			'#description' => t('Directory where the cron should look for the new file. Include trailing slash.')
		);
		$form['agent_validation']['agent_validation_failed_directory'] = array(
			'#type' => 'textfield',
			'#title' => t('Failed Directory Folder'),
			'#default_value' => \Drupal::state()->get('agent_validation_failed_directory'),
			'#description' => t('Directory where the cron should move a failed file in the event of an error. Include trailing slash.')
		);
		$form['agent_validation']['submit'] = array(
			'#type' => 'submit',
			'#value' => t('Save')
 		);
 		return $form;
    }

	/**
	* {@inheritdoc}
	*/
	public function validateForm(array &$form, FormStateInterface $form_state) {
		// parent::validateForm($form, $form_state);
	}

	/**
	* {@inheritdoc}
	*/
	public function submitForm(array &$form, FormStateInterface $form_state) {
	    $values = $form_state->getValues();
	    foreach($values as $k => $v){
		      	\Drupal::state()->set($k, $v);
		    }
		//\Drupal::cache('bin')->invalidateAll();
		drupal_set_message(t('Your Configurations have been saved successfully.'));
	}

}
