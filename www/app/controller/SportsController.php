<?php
class SportsController extends AssociationsController {
        public function __construct() {
            parent::__construct('SportsModel');
        }
    
        public function index($view = 'sports') {
            parent::index($view);
        }
    }
?>