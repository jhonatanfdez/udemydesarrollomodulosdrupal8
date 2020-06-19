<?php



namespace Drupal\form_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Implements an example form.
 */
class editform extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_example_editform';
  }

  public function Listarunregistro($arg) {
    $connection = \Drupal::database();
    $query = $connection->query("SELECT * FROM {datospersonales} WHERE id = :id", [
      ':id' => $arg,
    ]);
    $result = $query->fetchAssoc();

    return $result;

  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $arg=null) {

    \Drupal::service('page_cache_kill_switch')->trigger();


    $form['elemento_imagen'] = array(
      '#markup' => '<img class="zoom" src="http://www.data.seduvi.cdmx.gob.mx/portal/images/datos_personales/Portada%20datos%20personales.gif" >',

    );

    $registro= array();
    $registro= $this->Listarunregistro($arg);
    //ksm($this->Listarunregistro($arg));





    $form['#attached']['library'][] = 'form_example/form_example_libraries';
    $form['#attached']['library'][] = 'seven/global-styling';



    $form['datos_personales'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Datos Personales'),
      '#attributes' => array(
        'class' => array('mi_clase')
      ),
    );

    $form['datos_personales']['nombre'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Digite el nombre'),
      '#default_value' => $registro['nombre'],
      '#size' => 60,
      '#maxlength' => 128,
    '#required' => TRUE,
    );



    $form['datos_personales']['apellido'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Digite apellido'),
      '#default_value' => $registro['apellido'],
      '#size' => 60,
      '#maxlength' => 128,
      //'#required' => TRUE,
    );


    $form['datos_personales']['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Digite el Email'),
      '#default_value' => $registro['email'],
    );


    $form['datos_institucionales'] = array(
      '#type' => 'details',
      '#title' => $this->t('Datos Institucionales'),
      '#open' => true,
    );


    $form['datos_institucionales']['phone_number'] = array(
      '#type' => 'tel',
      '#title' => $this->t('Digite su teléfono'),
      '#default_value' => $registro['celular'],
    );


    $form['datos_institucionales']['expiration'] = array(
      '#type' => 'date',
      '#title' => $this->t('Fecha de contratación'),
      '#default_value' => $registro['fecha'],

    );



    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
      '#attributes' => array(
        'class' => array('mibotonprincipal')
      ),
    );

    $form['actions']['cancelar'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Cancel'),
      '#submit' => array('form_example_cancelar'),
      '#limit_validation_errors' => array(),
      '#attributes' => array(
        'class' => array('mibotonprincipal')
      ),
    );



    $form['idregistro'] = array(
      '#type' => 'hidden',
      '#value' => $arg
    );



    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 3) {
      $form_state->setErrorByName('phone_number', $this->t('Este número telefónico es muy corto, por favor digite su número telefónico completo.'));
    }


    $mystring = $form_state->getValue('email');
    $findme   = '@';
    $pos = strpos($mystring, $findme);

    // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
    // porque la posición de 'a' está en el 1° (primer) caracter.
    if ($pos === false) {
      $form_state->setErrorByName('email', $this->t('Email no válido'));

    }






  }

  /**
   * {@inheritdoc}
   */



  public function submitForm(array &$form, FormStateInterface $form_state) {

  $campos= array(
    'nombre' => $form_state->getValue('nombre'),
    'apellido' => $form_state->getValue('apellido'),
    'email' => $form_state->getValue('email'),
    'celular' => $form_state->getValue('phone_number'),
    'fecha' => $form_state->getValue('expiration'),


  );

  $id = $form_state->getValue('idregistro');


  $connection = \Drupal::database();

  $connection->update('datospersonales')
  ->fields($campos )
  ->condition('id', $id)
  ->execute();

  //drupal_set_message("Datos guardados correctamente. Se ha actualizado el registro ". $id );

    \Drupal::messenger()->addStatus(t("Datos guardados correctamente. Se ha actualizado el registro ". $id ));



  $form_state->setRedirect('form_example.mostrartodo');


//ksm($campos);
    /*
    drupal_set_message($this->t('Su número telefónico es: @number', array('@number' => $form_state->getValue('phone_number'))));

    global $base_url;

    //dpm($base_url);

    $response = new RedirectResponse($base_url);
    $response->send();
    return;
*/
  }

}
