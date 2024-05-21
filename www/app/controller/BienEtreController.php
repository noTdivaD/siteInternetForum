<?php
class BienEtreController extends AssociationsController {
        public function __construct() {
            parent::__construct('BienEtreModel');
        }
    
        public function index($view = 'bienetre') {
            parent::index($view);
        }
    }
?>