<?php

namespace Application\Controllers;

use MounirSoft\Controller;

class IndexController extends Controller {

    public function indexAction() {
        $this->getView()->frame_name = 'MounirSoft Framework';
        $this->getView()->setTitle('BENHAJJAJ Mounir');
        $this->getView()->setStyle(array('bootstrap.min.css', 'bootstrap-theme.min.css'));
        $this->getView()->setScript(array('jquery-2.1.4.js', 'bootstrap.min.js'));
    }

}