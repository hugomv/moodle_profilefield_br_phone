<?php

class profile_define_br_cellphone extends profile_define_base {

    function define_form_specific($form) {
        /// Default data
        $form->addElement('text', 'defaultdata', get_string('profiledefaultdata', 'admin'), 'size="50"');
        $form->setType('defaultdata', PARAM_TEXT);

    }

}


