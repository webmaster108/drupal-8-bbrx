<?php

namespace Drupal\state_content\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class ProfitAndLossForm.
 */
class CustomtagForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'customtag_content_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $regions = state_content_get_all_regions();
    $regions[0] = 'N/A';
    ksort($regions);
    $form = [];
    $form['add_tag'] = [
      '#type' => 'fieldset',
      '#title' => t('Add Tag'),
      '#collapsible' => FALSE,
      '#description' => t('Create and manage custom tags for articles.'),
    ];
    $form['add_tag']['custom_tag'] = [
      '#type' => 'textfield',
      '#title' => t('Custom Tag'),
      '#description' => t('This will be the tag that gets replaced with content.'),
    ];
    $form['add_tag']['region'] = [
      '#type' => 'select',
      '#multiple' => TRUE,
      '#title' => t('Region'),
      '#options' => $regions,
      '#description' => t('Set region to N/A for fallback.'),
    ];
    $form['add_tag']['tag_default'] = [
      '#type' => 'checkbox',
      '#title' => t('Fallback for if a user selects a state not in a region.'),
    ];
    $form['add_tag']['tag_content'] = [
      '#type' => 'text_format',
      '#title' => t('Tag Content'),
      '#description' => t('This will be the content that replaces the tag.'),
    ];
    $form['add_tag']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save Tag'),
    ];

    $header = [
      'id' => ['data' => t('ID'),'field' => 'z.numeric'],
      'tag' => ['data' => t('Tag'), 'field' => 'z.alpha'],
      'content' => ['data' => t('Content')],
      'tag_default' => ['data' => t('Default')],
      'region' => ['data' => t('Region'), 'field' => 'z.alpha'],
      'edit' => ['data' => t('Edit')],
      'delete' => ['data' => t('Delete')],
    ];
    $dmod = FALSE;
    $selected_tag = \Drupal::request()->get('tag_id');
    if ($selected_tag == 'none' || empty($selected_tag)) {
      $sort = \Drupal::request()->get('sort');
      $order = \Drupal::request()->get('order');
      $database = \Drupal::database();
      $query = $database->select('state_content_custom_tags', 'z')
        ->fields('z', ['id', 'tag', 'content', 'tag_default', 'region']);
      if (!empty($sort)) {
        $query->orderBy($order, $sort);
      }
      $results = $query->execute()
        ->fetchAll();
      $rows = [];
      $tags = [];
      $tags['none'] = 'Please select a tag to filter by';
      foreach ($results as $result) {
        $tag_id = $result->id;

        $tags[$tag_id] = $result->tag;
        $edit_link = [
          'data' => new FormattableMarkup('<a href=":link">@name</a>',
         [
           ':link' => '/admin/state-content/tags/' . $result->id . '/edit',
           '@name' => 'Edit',
         ]),
        ];
        $delete_link = [
          'data' => new FormattableMarkup('<a href=":link">@name</a>',
         [
           ':link' => '/admin/state-content/tags/' . $result->id . '/delete',
           '@name' => 'Delete',
         ]),
        ];

        $regions = unserialize($result->region);
        $regionNames = [];
        // kint($regions);
        if (!empty($regions) || $regions != FALSE) {
          foreach ($regions as $region) {
            $convertID = state_content_get_region($region);
            $regionNames[] = $convertID['region'];
          }
          $regionFriendly = implode(', ', $regionNames);
        }
        else {
          $regionFriendly = '';
        }
        $rows[] = [
          $result->id,
          $result->tag,
          $result->content,
          $result->tag_default,
          $regionFriendly,
          $edit_link,
          $delete_link,
        ];

      }
    }
    else {
      $database = \Drupal::database();
      $query = $database->select('state_content_custom_tags', 'z')
        ->fields('z', ['id', 'tag', 'content', 'tag_default', 'region'])
        ->condition('id', $selected_tag);
      if (!empty($sort)) {
        $query->orderBy($order, $sort);
      }
      $results = $query->execute()
        ->fetchAll();
      $rows = [];
      $tags = [];
      $tags['none'] = 'Please select a tag to filter by';
      foreach ($results as $result) {
        $tag_id = $result->id;
        $tags[$tag_id] = $result->tag;
        $edit_link = [
          'data' => new FormattableMarkup('<a href=":link">@name</a>',
         [
           ':link' => '/admin/state-content/tags/' . $result->id . '/edit',
           '@name' => 'Edit',
         ]),
        ];
        $delete_link = [
          'data' => new FormattableMarkup('<a href=":link">@name</a>',
         [
           ':link' => '/admin/state-content/tags/' . $result->id . '/delete',
           '@name' => 'Delete',
         ]),
        ];

        $regions = unserialize($result->region);
        $regionNames = [];
        // kint($regions);
        if (!empty($regions) || $regions != FALSE) {
          foreach ($regions as $region) {
            $convertID = state_content_get_region($region);
            $regionNames[] = $convertID['region'];
          }
          $regionFriendly = implode(', ', $regionNames);
        }
        else {
          $regionFriendly = '';
        }
        $rows[] = [
          $result->id,
          $result->tag,
          $result->content,
          $regionFriendly,
          $result->tag_default,
          $edit_link,
          $delete_link,
        ];

      }
    }

    $form['filter_tag'] = [
      '#type' => 'fieldset',
      '#title' => t('Filter Tags'),
      '#collapsible' => FALSE,
    ];

    $form['filter_tag']['filter_result'] = [
      '#type' => 'select',
      '#title' => t('Tags'),
      '#options' => $tags,
      '#description' => t('Filter by available tags.'),
    ];

    $form['filter_tag']['submit1'] = [
      '#type' => 'submit',
      '#value' => 'Filter',
      '#submit' => ['::getFilterTag'],
    ];

    $form['table_urls'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No regions.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // parent::validateForm($form, $form_state);.
  }

  /**
   * Get custom tag.
   */
  public function getFilterTag(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('filter_result');
    $form_state->setRedirect('state_content.customtag_form', [
      'tag_id' => $value,
    ]);

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $serialize_regions = serialize($values['region']);
    // kint($form_state->getValue('tag_content'));exit;.
    $conn = Database::getConnection();
    $conn->insert('state_content_custom_tags')->fields([
      'tag' => $form_state->getValue('custom_tag'),
      'region' => $serialize_regions,
      'tag_default' => !empty($form_state->getValue('tag_default')) ? 1 : 0,
      'content' => $form_state->getValue('tag_content')['value'],
    ])->execute();
    drupal_set_message(t('New Custom Tag data has been saved.'));
  }

}
