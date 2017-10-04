<?php

namespace Drupal\myplanet_courses\Controller;

use Drupal\Core\Controller\ControllerBase;

class coursesController extends ControllerBase{

    public function content(){
        return array(

            '#type' => 'markup',
            '#markup'   => $this->t('Hello World!'),
        );
    }
}
