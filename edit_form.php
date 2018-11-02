<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();


class block_course_participation_report_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $DB;

        $categories = $DB->get_records_sql( 'SELECT id, name FROM {course_categories} WHERE parent = 0' );

        $cat_options = array();
        foreach ($categories as $c) {
            $cat_options[$c->id] = $c->name;
        }

        $mform->addElement( 'header',
          'configheader',
          get_string('blocksettings', 'block_course_participation_report') );

        $mform->addElement( 'date_selector',
          'config_from',
          get_string('start_date', 'block_course_participation_report') );

        $mform->addElement( 'date_selector',
          'config_to',
          get_string('end_date', 'block_course_participation_report') );

        $mform->addElement( 'select',
          'config_category',
          get_string('category', 'block_course_participation_report'),
          $cat_options );

    }
}