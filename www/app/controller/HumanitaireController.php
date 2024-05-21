<?php
class HumanitaireController extends AssociationsController {
        public function __construct() {
            parent::__construct('HumanitaireModel');
        }
    
        public function index($view = 'humanitaire') {
            parent::index($view);
        }
    }
?>