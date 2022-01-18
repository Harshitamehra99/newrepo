<?php
/**
 * @file
 * Contains \Drupal\custom_module\Controller\CustomController.
 */

namespace Drupal\custom_module\Controller;
use Drupal\Core\Database\Database;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class CustomController.
 *
 * @package Drupal\my_custom\Controller
 */
class CustomController extends ControllerBase {

  /**
   * showdata.
   *
   * @return string
   *   Return Table format data.
   */
  public function showdata() {
    $result = \Drupal::database()->select('employee', 'n')
            ->fields('n', array('id', 'fname', 'sname','age','marks'))
            ->execute()->fetchAllAssoc('id');
            $data=[];

          foreach ($result as $row) {
            $url_update = Url::fromRoute('custom_module.update_form', ['id' => $row->id], []);
            $url_delete = Url::fromRoute('custom_module.delete_form', ['id' => $row->id], []);
            $linkupdate = Link::fromTextAndUrl('update', $url_update);
            $linkdelete = Link::fromTextAndUrl('delete', $url_delete);
            $data[] = [
            'id' => $row->id,
            'fname' => $row->fname,
            'sname' => $row->sname,
            'age' => $row->age,
            'marks' => $row->marks,
            'update' => $linkupdate,
            'delete' => $linkdelete,
          ];
        }

// Create the header.
    $header = array('id', 'First Name', 'Second Name','Age','Marks', 'Update', 'Delete');
    // $output = array(
      $build['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $data,   
      ];
  return [
      $build,
      '#title'=>'Students Data'
    ];
  }
}