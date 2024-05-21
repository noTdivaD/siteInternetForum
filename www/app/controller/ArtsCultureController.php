<?php
class ArtsCultureController extends AssociationsController {
        public function __construct() {
            parent::__construct('ArtsCultureModel');
        }
    
        public function index($view = 'artsculture') {
            parent::index($view);
        }
    }
?>