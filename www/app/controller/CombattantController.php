<?php
class CombattantController extends AssociationsController {
        public function __construct() {
            parent::__construct('CombattantModel');
        }
    
        public function index($view = 'associations_combattant') {
            parent::index($view);
        }
    }
?>