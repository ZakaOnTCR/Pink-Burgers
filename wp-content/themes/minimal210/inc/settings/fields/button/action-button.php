<?php

class acf_field_action_button extends acf_field{

    public function __construct() {

        $this->name = 'action_button';
        $this->label = __( 'Button', 'minimal210' );
        $this->category = 'layout';
        $this->defaults = array();
        $this->l10n = array(
            
            'error' => __( 'Error! Please enter a higher value', 'minimal210' ),
        );

        parent::__construct();
    }

    public function render_field_settings( $field ) {

        acf_render_field_setting( $field, array(

            'label'         => __( 'Action', 'minimal210'),
            'instructions'  => '',
            'type'          => 'text',
            'name'          => 'min_action',
            'required'      => true,
        ));

        acf_render_field_setting( $field, array(

            'label'         => __( 'Value', 'minimal210'),
            'instructions'  => '',
            'type'          => 'text',
            'name'          => 'min_value',
            'required'      => true,
        ));

        acf_render_field_setting( $field, array(

            'label'         => __( 'Button text', 'minimal210'),
            'instructions'  => '',
            'type'          => 'text',
            'name'          => 'min_buttontext',
        ));
    }

    public function render_field( $field ) {

        $form = '';

        $form .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';

            $action = $field['min_action'];
            $value = $field['min_value'];

            $form .= '<input type="hidden" name="'.$action.'" value="'.$value.'">';
            
            $button = $field['min_buttontext'];

            if( empty( $button ) ) {

                $button = 'Uitvoeren';
            }

            $form .= '<input type="submit" value="'.$button.'">';

        $form .= '</form>';

        echo $form;
    }
}
new acf_field_action_button();