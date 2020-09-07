<?php

class profile_field_br_cellphone extends profile_field_base {
    /**
     * Overwrite the base class to display the data for this field
     */
    function display_data() {
        /// Default formatting
        $data = parent::display_data();
        $data = str_pad($data, 11, '0', STR_PAD_LEFT); // Prevent low digits formatting errors
        if ($data !== '') {
            $data = '('.substr($data,0,2).')'.substr($data,2,5).'-'.substr($data,7,4);
        }
        return $data;
    }

    function edit_field_add($mform) {
        /// Create the form field
        $mform->addElement('text', $this->inputname, format_string($this->field->name), 'maxlength="11" size="11"');
        $mform->setType($this->inputname, PARAM_TEXT);
    }

    function edit_validate_field($usernew) {
        // Get default validation errors
        $errors = parent::edit_validate_field($usernew);
        if ($errors) {
            return $errors;
        }

        // Based on script by Moacir, in http://codigofonte.uol.com.br/codigos/validacao-de-cpf-com-php
        if (isset($usernew->{$this->inputname})) {
            $br_cellphone = $usernew->{$this->inputname};
            if (!ctype_digit($br_cellphone)) {
                return array($this->inputname => get_string('br_cellphone_digits', 'profilefield_br_cellphone'));
            }
            if (strlen($cpf) != 11) {
                return array($this->inputname => get_string('br_cellphone_size', 'profilefield_br_cellphone'));
            }
            // if (in_array($cpf, array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'))) {
            //     return array($this->inputname => get_string('cpf_invalid', 'profilefield_cpf'));
            // }
            // for ($t = 9; $t < 11; $t++) {
            //     for ($d = 0, $c = 0; $c < $t; $c++) {
            //         $v = substr($cpf,$c,1);
            //         $d += $v * (($t + 1) - $c);
            //     }
            //     $v = substr($cpf,$c,1);
            //     $d = ((10 * $d) % 11) % 10;
            //     if ($v != $d) {
            //         return array($this->inputname => get_string('cpf_invalid', 'profilefield_cpf'));
            //     }
            // }
        }
        return $errors;
    }

}
