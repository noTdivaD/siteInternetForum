<?php
class EcologieController extends AssociationsController {
        public function __construct() {
            parent::__construct('EcologieModel');
        }
    
        public function index($view = 'ecologie_environnement') {
            parent::index($view);
        }
    }
?>