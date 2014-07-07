<?php

class profile_field_cpf extends profile_field_base {
    /**
     * Overwrite the base class to display the data for this field
     */
    function display_data() {
        /// Default formatting
        $data = parent::display_data();
        $data = str_pad($data, 11, '0', STR_PAD_LEFT); // Prevent low digits formatting errors
        if ($data !== '') {
            $data = substr($data,0,3).'.'.substr($data,3,3).'.'.substr($data,6,3).'-'.substr($data,9,2);
        }
        return $data;
    }

    function edit_field_add($mform) {
        /// Create the form field
        $mform->addElement('text', $this->inputname, format_string($this->field->name), 'maxlength="11" size="11"');
        $mform->setType($this->inputname, PARAM_TEXT);
    }

    function edit_validate_field($usernew) {
        // Based on script by Moacir, in http://codigofonte.uol.com.br/codigos/validacao-de-cpf-com-php
        $errors = array();
        if (isset($usernew->{$this->inputname})) {
            $cpf = $usernew->{$this->inputname};
            if (ctype_digit($cpf)) {
                return array($this->inputname => get_string('cpf_digits', 'profilefield_cpf'));
            }
            if (strlen($cpf) != 11) {
                return array($this->inputname => get_string('cpf_size', 'profilefield_cpf'));
            }
            if (in_array($cpf, array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'))) {
                return array($this->inputname => get_string('cpf_invalid', 'profilefield_cpf'));
            }
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $v = substr($cpf,$c,1);
                    $d += $v * (($t + 1) - $c);
                }
                $v = substr($cpf,$c,1);
                $d = ((10 * $d) % 11) % 10;
                if ($v != $d) {
                    return array($this->inputname => get_string('cpf_invalid', 'profilefield_cpf'));
                }
            }
        }
        return $errors;
    }

}
