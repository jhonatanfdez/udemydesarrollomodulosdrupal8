<?php

namespace Drupal\page_test\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    );
  }

  public function pagina() {
    return array(
      '#type' => 'markup',
      '#markup' => 'Esta es mi nueva pagina',
    );
  }

  public function pagina1() {
    return array(
      '#type' => 'markup',
      '#markup' => 'Esta es la pagina 1',
    );
  }


}
