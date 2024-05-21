<?php
class AnimationsLoisirsController extends AssociationsController {
        public function __construct() {
            parent::__construct('AnimationsLoisirsModel');
        }
    
        public function index($view = 'animationsloisirs') {
            parent::index($view);
        }
    }
?>