<?php



namespace Drupal\form_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Implements an example form.
 */
class deleteform extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_example_deleteform';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $arg=null) {
    $form['elemento_imagen'] = array(
      '#markup' => 'El registro a eliminar es '. $arg.'. <br><br><i>Esta acción no se podrá deshacer.</i> ' ,

    );

    $form['#attached']['library'][] = 'form_example/form_example_libraries';
    $form['#attached']['library'][] = 'seven/global-styling';

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Delete'),
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

  }

  /**
   * {@inheritdoc}
   */



  public function submitForm(array &$form, FormStateInterface $form_state) {


  $id = $form_state->getValue('idregistro');


  $connection = \Drupal::database();

  $connection->delete('datospersonales')
  ->condition('id', $id)
  ->execute();

  //drupal_set_message("Se ha eliminado el registro ". $id );

   \Drupal::messenger()->addStatus(t("Se ha eliminado el registro ". $id));





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
