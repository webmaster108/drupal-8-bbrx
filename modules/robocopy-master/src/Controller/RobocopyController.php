<?php
/**
 * @file
 * @author 
 * Contains \Drupal\robocopy\Controller\RobocopyController.
 * Please place this file under your robocopy(module_root_folder)/src/Controller/
 */
namespace Drupal\robocopy\Controller;
/**
 * Provides route responses for the Robocopy module.
 */
class RobocopyController {
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function mergePage() {
    $element = array(
      '#markup' => 'The Merge functionality executed.',
    ); 
    
    // STAGE TO PROD CODE SNIPPET

    \Drupal::logger('Robocopy')->alert('Merge started');

      //PATHS AND DBS
      $stage_db = 'basicbluerx_drupal_stage';
      $stage_path = 'c:\\home\\clea02admin\\stage\\db\\';
      $file_name = 'basicbluerx_merge.sql';
      $prod_db = 'basicbluerx_drupal';
      $backup_path = 'c:\\home\\clea02admin\\production_db_backups/';
      $databasePass = '';

      \Drupal::logger('Robocopy')->alert('Start production backup');

      //DUMP STAGE DB
      \Drupal::logger('Robocopy')->alert('Start stage dump file');
      $command = 'c:\mysql\bin\mysqldump -h100.66.9.10 -uclearstone -p'.$databasePass.' '.$stage_db.' 
    block_content block_content_field_data block_content__body file_managed file_usage history menu_link_content menu_link_content_data menu_tree node node_access node__comment node_revision search_dataset search_index search_total taxonomy_index taxonomy_term_data taxonomy_term_field_data taxonomy_term__parent url_alias > '.$stage_path.$file_name;
      
      $export = system($command);
      \Drupal::logger('Robocopy')->alert('End merge dump file');

      //BACKUP PRODUCTION DB
      $prodCommand = 'c:\mysql\bin\mysqldump -h100.66.9.10 -uclearstone -p'.$databasePass.' '.$prod_db.' > '.$backup_path.'basicbluerx_prod_bk_'.strtotime('now').'.sql';
      $prodExport = system($prodCommand);
      \Drupal::logger('Robocopy')->alert('End production backup');

      //IMPORT DB FROM STAGE
      \Drupal::logger('Robocopy')->alert('Start import of stage database to production');
      $import = 'c:\mysql\bin\mysql -h100.66.9.10 -uclearstone -p'.$databasePass.' '.$prod_db.' < '.$stage_path.$file_name;
      $production = system($import);
      \Drupal::logger('Robocopy')->alert('End import of stage database to production');

      //SYNC FILES FROM STAGE
      \Drupal::logger('Robocopy')->alert('Start synchronization of uploaded files');
      $files = 'robocopy /sites/bbrx_stage/sites/default/files/ /sites/bbrx_prod/sites/default/files/ /V /MIR /R:0 /W:0 /COPY:DAT /DCOPY:T';
      $sync = system($files);
      \Drupal::logger('Robocopy')->alert('End synchronization of uploaded files');

      \Drupal::logger('Robocopy')->alert('Merge ended.');

      return $element;
  }
}
?>
