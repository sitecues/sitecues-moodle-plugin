<?php

class block_sitecues_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // sitecues badge color
        $badge_color_types = array(
            'normal' => get_string('normal_type_description', 'block_sitecues'),
            'reverse-blue' => get_string('reverse-blue_type_description', 'block_sitecues'),
            'reverse-yellow' => get_string('reverse-yellow_type_description', 'block_sitecues'),
            'adaptive' => get_string('adaptive_type_description', 'block_sitecues')
        );
        $badge_color_select = $mform->addElement('select', 'config_badge_color', get_string('badge_color_label', 'block_sitecues'), $badge_color_types);
        $badge_color_select->setSelected('normal');

        // sitecues badge placement
        // value 1 for yes and 0 for no
        $mform->addElement('selectyesno', 'config_badge_placement', get_string('default_badge_placement', 'block_sitecues')); // Add elements to your form
        $mform->setDefault('config_badge_placement', 1);        //Default value

        // Disable my control unless a checkbox is checked.
        $mform->disabledIf('config_badge_height', 'config_badge_placement', 'neq', 0);

        // sitecues badge size
        // The badge should be styled with a height of at least 19px.
        // The width will be set automatically so that the badge retains its aspect ratio.
        // You can set a custom width, but it MUST be 6.5 times the height.
        $mform->addElement('text', 'config_badge_height', get_string('badge_height_label', 'block_sitecues')); // Add elements to your form
        $mform->setType('config_badge_height', PARAM_INT);                   //Set type of element
        $mform->setDefault('config_badge_height', 19, 'block_sitecues');        //Default value
        $mform->addRule('config_badge_height', get_string('badge_size_error', 'block_sitecues'), 'callback', 'validate_height', 'client', true, false);
    }
}
