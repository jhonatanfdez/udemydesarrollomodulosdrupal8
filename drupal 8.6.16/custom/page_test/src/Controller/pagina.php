<?php

namespace Drupal\page_test\Controller;

use Drupal\Core\Controller\ControllerBase;

class pagina extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */

  public function paginadesdeotrocontrolador() {
    return array(
      '#type' => 'markup',
      '#markup' => 'Pagina desde otro controlador',
    );
  }


  public function verpagina( $idpagina = null ) {
    return array(
      '#type' => 'markup',
      '#markup' => 'El parámetro recibido es: '. $idpagina ,
    );
  }


  public function verpaginacustom ( $custom_arg ) {
    return array(
      '#type' => 'markup',
      '#markup' => 'El parámetro recibido es: '. $custom_arg ,
    );
  }



  public function varias (  ) {

     $contenido=array();

     $contenido['linea1'] =  array(
       '#markup' => '<strong> Linea 1 </strong><br><br>' ,
     );

     $contenido['linea2'] =  array(
       '#markup' => '<i> Linea 2 </i><br><br>' ,
     );


    $contenido['linea3'] =  array(
      '#markup' => 'Linea 3<br><br>' ,
    );

    return $contenido;
  }






    public function form (  ) {

       $contenido=array();

       $contenido['linea1'] =  array(
         '#markup' => '<strong> Linea 1 </strong><br><br>' ,
       );

       $contenido['linea2'] =  array(
         '#markup' => '<i> Linea 2 </i><br><br>' ,
       );


      $contenido['linea3'] =  array(
        '#markup' => 'Linea 3<br><br>' ,
      );


      $form = \Drupal::formBuilder()->getForm('Drupal\form_example\Form\addform');

      $contenido['linea4'] = $form;

      return $contenido;
    }




    public function template() {

      $form = \Drupal::formBuilder()->getForm('Drupal\form_example\Form\addform');

        return [
          '#theme' => 'my_template',
          '#my_variable' => $this->t('Esta es la variable'),
          '#form' => $form,
        ];

      }




}
