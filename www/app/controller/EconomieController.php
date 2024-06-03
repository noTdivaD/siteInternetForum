<?php
class EconomieController extends AssociationsController {
        public function __construct() {
            parent::__construct('EconomieModel');
        }
    
        public function index($view = 'economie_developpement') {
            parent::index($view);
        }
    }
?>