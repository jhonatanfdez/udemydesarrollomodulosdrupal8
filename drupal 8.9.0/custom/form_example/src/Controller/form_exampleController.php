<?php

namespace Drupal\form_example\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\form_example\Form\editform;


class form_exampleController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */

   public function mostrarunregistro($arg) {

     global $base_url;

    \Drupal::service('page_cache_kill_switch')->trigger();


     $contenido=array();

     $contenido['linea1'] =  array(
      '#markup' => 'Esta información es confidencial.<br><br>' ,
     );

     $url = Url::fromUri($base_url.'/form_example/'.$arg.'/edit');
     $editar_link = \Drupal::l(t('Editar registro'), $url);
     $row['editar']=$editar_link;

     $contenido['linea2'] =  array(
      '#markup' => $editar_link.'<br><br>' ,
     );

     $registro=array();

     $temp=array();

     $temp = new editform;

     $registro = $temp->Listarunregistro($arg);

     //ksm($registro);
     //dsm($registro);

     $contenido[] = [
      '#theme' => 'form_example_template',
      '#test_var' => $registro,
    ];


     return $contenido;

   }


  public function mostrartodo() {

    \Drupal::service('page_cache_kill_switch')->trigger();

    $contenido=array();

    $contenido['linea1'] =  array(
     '#markup' => '<strong> En esta sección se administrarán los datos personales de los usuarios </strong><br><br>' ,
    );


    $url = Url::fromRoute('form_example.addform');
    $project_link = Link::fromTextAndUrl(t('Crear nuevo registro'), $url);
    $project_link = $project_link->toRenderable();
    // If you need some attributes.
    $project_link['#attributes'] = array('class' => array('button', 'button--primary', 'button--small'));


    $contenido['linea2'] =  array(
     '#markup' => '<i> Para crear nuevos registros, pulse clic en el siguiente botón '. render($project_link) . '</i><br><br>' ,
    );

    $rows=array();
    $rows=listar();
    //ksm(listar());
    // Build a render array which will be themed as a table with a pager.
     $contenido['table'] = [
       '#rows' => $rows,
       '#header' => [t('Id'), t('Nombre'), t('Apellido'), t('Email'), t('Celular'), t('Fecha'), t('Ver'), t('Editar'), t('Eliminar')],
       '#type' => 'table',
       '#empty' => t('No content available.'),
     ];
     $contenido['pager'] = [
       '#type' => 'pager',
       '#weight' => 10,
     ];




    return $contenido;
  }




}


function listar() {
$database= \Drupal::database();
  // Using the TableSort Extender is what tells  the query object that we
  // are sorting.
  $query = $database->select('datospersonales', 'dp')
    ->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(5);
  $query->fields('dp');

  // Don't forget to tell the query object how to find the header information.
  $result = $query
    //->orderByHeader($header)
    ->execute();

  $rows = [];

  global $base_url;
  foreach ($result as $row) {
    // Normally we would add some nice formatting to our rows
    // but for our purpose we are simply going to add our row
    // to the array.

    $row= (array) $row;


    // External Uri.
    //use Drupal\Core\Url;
    $url = Url::fromUri($base_url.'/form_example/'.$row['id']);
    $ver_link = \Drupal::l(t('Ver'), $url);
    $row['ver']=$ver_link;

    $url = Url::fromUri($base_url.'/form_example/'.$row['id'].'/edit');
    $editar_link = \Drupal::l(t('Editar'), $url);
    $row['editar']=$editar_link;

    $url = Url::fromUri($base_url.'/form_example/'.$row['id'].'/delete');
    $eliminar_link = \Drupal::l(t('Eliminar'), $url);
    $row['eliminar']=$eliminar_link;

    $rows[] =  $row;
  }

return $rows;

}
