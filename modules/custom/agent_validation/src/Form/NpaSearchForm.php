<?php

namespace Drupal\agent_validation\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form;
use Drupal\Core\Database\Database;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\agent_validation\Ajax\AgentValidationInvoke;

/**
 * Class NpaSearchForm.
 */
class NpaSearchForm extends FormBase {
  /**
   * {@inheritdoc}
   */
	public function getFormId() {
		return 'npa_search_form';
	}
  /**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state){
		$form = array();
		//$form_state->unsetValue('npn-result');
		//$form_state->setValue('npn-result', TRUE);
		$values = $form_state->getValues();

		//$form['#tree'] = TRUE;
		//$form['#attached']['library'][] = 'agent_validation/agent_validation_assets';
		$form['step_1'] = array(
			'#type' => 'fieldset',
			'#title' => t('NPN Lookup'),
			'#collapsible' => FALSE,
			'#prefix' => '<div id="npn-search">',
			'#suffix' => '</div>'
		);
		$form['step_1']['npn'] = array(
			'#type' => 'textfield',
			'#title' => t('National Producer Number (NPN)'),
			'#maxlength' => 25
		);
		$form['step_1']['submit'] = array(
			'#type' => 'submit',
			'#value' => 'Search',
			'#name' => 'npn_submit',
			'#submit' => array([$this, 'agent_validation_npn_search']),
			'#ajax' => array(
				'callback' => '::npnSearchCallback',
				'wrapper' => 'agent-callback',
				'method' => 'replace',
				'effect' => 'fade',
				'event' => 'click'
			)
		);
		if(empty($values['npn-result'])){			
			$form['step_2'] = array(
				'#type' => 'markup',
				'#prefix' => '<div id="agent-callback">',
				'#suffix' => '</div>'
			);
		} else {
	    	if(!empty($values['npn_lookup'])){
				$form['step_2'] = array(
					'#type' => 'fieldset',
					'#title' => t('Verify your Information'),
					'#collapsible' => FALSE,
					'#prefix' => '<div id="agent-callback">',
					'#suffix' => '</div>'
				);
				$form['step_2']['npn_result_field'] = array(
					'#type' => 'textfield',
					'#title' => t('NPN'),
					'#disabled' => TRUE,
					'#default_value' => $values['npn_lookup']['npn']
				);
				$form['step_2']['agent_first'] = array(
					'#type' => 'textfield',
					'#title' => t('Agent First Name'),
					'#disabled' => TRUE,
					'#default_value' => $values['npn_lookup']['agentfirst']
				);
				$form['step_2']['agent_last'] = array(
					'#type' => 'textfield',
					'#title' => t('Agent Last Name'),
					'#disabled' => TRUE,
					'#default_value' => $values['npn_lookup']['agentlast']
				);
				$form['step_2']['agent_phone'] = array(
					'#type' => 'textfield',
					'#title' => t('Agent Phone'),
					'#disabled' => TRUE,
					'#default_value' => $values['npn_lookup']['agentphone']
				);
				$form['step_2']['correct'] = array(
					'#type' => 'radios',
					'#title' => t('Is this you?'),
					'#description' => t('For spelling and phone # corrections contact your participating Blue plan, general or managing agent.'),
					'#options' => array(
					  'no' => 'No',
					  'yes' => 'Yes'
					)
				);
				$form['step_2']['submit'] = array(
					'#type' => 'submit',
					'#value' => 'Continue',
					'#name' => 'npn_continue',
					'#submit' => array([$this, 'agent_validation_form_step_2_submit']),
					'#ajax' => array(
						'callback' => '::npnstepCallback',
						'wrapper' => 'agent-callback',
						//'method' => 'replace',
						//'effect' => 'fade',
						'event' => 'click'
					)
				);
			} else {
				$form['step_2'] = array(
					'#type' => 'fieldset',
					'#title' => t('NPN Not Found'),
					'#prefix' => '<div id="agent-callback">',
					'#suffix' => '</div>',
					'#collapsible' => FALSE
				);
		
				$form['step_2']['not_information'] = array(
					'#type' => 'container',
					'#markup' => '<ul><li>You must be appointed by MII Life and certified on Basic Blue Rx prior to enrolling a beneficiary into this plan.</li><li>Not finding your NPN?<ul><li>If you have completed certification today, your NPN may not be in our system yet.</li><li>You may <strong>retry search</strong> or click <strong>continue</strong>, return to the form, and directly enter your information.</li></ul><li>If you have questions contact your participating Blue plan, general or managing agent.</li></ul>',
					'#attributes' => array('class' => array('not-found-header')
					)
				);

				$form['step_2']['correct'] = array(
					'#type' => 'radios',
					'#title' => t('Would you like to retry the search or continue?'),
					'#options' => array(
					  'retry' => 'Retry Search?',
					  'continue' => 'Continue'
					)
				);

				$form['step_2']['submit'] = array(
					'#type' => 'submit',
					'#value' => 'Continue',
					'#name' => 'npn_continue2',
					'#submit' => array([$this, 'agent_validation_form_step_2_submit']),
					'#ajax' => array(
						'callback' => [$this, 'npnstepCallback'],
						'wrapper' => 'agent-callback',
						'method' => 'replace',
						'effect' => 'fade',
						'event' => 'click'
					)
				);
	    	}
	  	}
	    return $form;
    }

	/**
	* {@inheritdoc}
	*/
	public function validateForm(array &$form, FormStateInterface $form_state){
		// parent::validateForm($form, $form_state);
	}

	public function npnstepCallback(array &$form, FormStateInterface $form_state){
		$response = new AjaxResponse();
		$values = $form_state->getValues();

		// $debugOut = @Kint::dump($form_state);
		if($values['correct'] == 'yes'){
			$response->addCommand(new InvokeCommand('input[name="agencyid"]', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-agentfirst', 'val', array($values['agent_first'])));
		    $response->addCommand(new InvokeCommand('input#edit-agentlast', 'val', array($values['agent_last'])));
		    $response->addCommand(new InvokeCommand('input#edit-agentid', 'val', array($values['npn'])));
		    $response->addCommand(new InvokeCommand('input#edit-agentphone', 'val', array($values['agent_phone'])));
		    $response->addCommand(new AgentValidationInvoke());
		    // if(!empty($form_state['npn_lookup']['fmo'])){
		    //   $commands[] = ajax_command_invoke('input[name="submitted[fmo]"]', 'val', array('FMO'));
		    // }
		}else if ($values['correct'] == 'continue'){
		    $response->addCommand(new InvokeCommand('input[name="agencyid"]', 'val', array('UNKNOWN')));
		    $response->addCommand(new InvokeCommand('input#edit-agentfirst', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-agentlast', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-agentid', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-agentphone', 'val', array('')));
		    $response->addCommand(new AgentValidationInvoke());
		    
		}else if ($values['correct'] == 'no'){
		    //$form_state->setValue('npn-result', FALSE);
		    $response->addCommand(new InvokeCommand('input[name="agencyid"]', 'val', array('UNKNOWN')));
		    $response->addCommand(new InvokeCommand('input#edit-submitted-agentfirst', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-submitted-agentlast', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-submitted-agentid', 'val', array('')));
		    $response->addCommand(new InvokeCommand('input#edit-submitted-agentphone', 'val', array('')));
		    //$response->addCommand(new ReplaceCommand('#agent-callback', render($form['step_2'])));
		    $response->addCommand(new InvokeCommand('#agent-callback', array('slideDown')));
		    $response->addCommand(new ReplaceCommand('#agent-callback', $form['step_2']));

  		} else {
	    	$response->addCommand(new InvokeCommand('#npn-search', array('slideDown')));
	    	$response->addCommand(new InvokeCommand('#agent-callback', array('slideUp')));

    	}
		return $response;
	}

	public function npnSearchCallback(array &$form, FormStateInterface $form_state) {
		$response = new AjaxResponse();
		$response->addCommand(new InvokeCommand('#npn-search', array('slideUp')));
		$response->addCommand(new ReplaceCommand('#agent-callback', $form['step_2']));
		return $response;
	}


	public function agent_validation_form_step_2_submit(array &$form,FormStateInterface $form_state){
		
       $values = $form_state->getValues();
		//$form_state->setValue('npn-result', FALSE);
		$form_state->setValue('npn-result', TRUE);
		if(!empty($values['correct'])){
			if ($values['correct'] == 'no'){
				$form_state->setValue('npn_lookup', '');
				$form_state->setValue('npn-result', TRUE);
			}

			if ($values['correct'] == 'yes'){
				$form_state->setValue('npn_lookup', TRUE);
			}
		}
		// Rebuild Form
		$form_state->setRebuild();			
		return $form;
	}

	public function agent_validation_npn_search(array &$form, FormStateInterface $form_state){
		$values = $form_state->getValues();
		//$form_state->unsetValue('npn-result');
		$form_state->setValue('npn_lookup', '');

		if(!empty($values['npn'])){
			$findNPN = db_select('agent_validation', 'a')
				->fields('a')
				->condition('npn', $values['npn'])
				->execute()->fetchAssoc();
			$form_state->setValue('npn-result', TRUE);

			if($findNPN){
				$form_state->setValue('npn_lookup', $findNPN);
				} else {
				$form_state->setValue('npn_lookup', '');
			}
		}else{
			$form_state->setValue('npn-result', TRUE);
			$form_state->setValue('npn_lookup', '');
		}
		// Rebuild Form
		$form_state->setRebuild();
		$values = $form_state->getValues();		
		return $form;
	}

	/**
	* {@inheritdoc}
	*/
	public function submitForm(array &$form, FormStateInterface $form_state) {
		  //cache_clear_all(NULL, 'cache_page', '*');
		//exit('saa');
	}

}
