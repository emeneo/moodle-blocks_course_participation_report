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

class block_course_participation_report extends block_base {

    function init() {
        $this->title = get_string( 'course_participation_report', 'block_course_participation_report' );
    }

    function applicable_formats() {
        return array('site' => true);
    }
    // end function init()

    function get_content() {
        global $CFG;
        if ( $this->content !== null ) {
            return $this->content;
        }

        $form_attr = array(
        'action'    => $CFG->wwwroot.'/blocks/course_participation_report/generate_report.php',
        'method'    => 'POST' );

        $from = array(
          'type'    => 'hidden',
          'name'    => 'from',
          'value'    => @$this->config->from );

        $to = array(
          'type'    => 'hidden',
          'name'    => 'to',
          'value'    => $this->config->to );

        $category = array(
           'type'    => 'hidden',
           'name'    => 'category',
           'value'    => $this->config->category );

        $submit_attr = array( 'type' => 'submit',
             'class' => 'btn btn-success' );

        $this->content            = new stdClass();
        $this->content->text    = html_writer::start_tag( 'form', $form_attr );
        $this->content->text    .= html_writer::empty_tag( 'input', $from );
        $this->content->text    .= html_writer::empty_tag( 'input', $to );
        $this->content->text    .= html_writer::empty_tag( 'input', $category );
        $this->content->text    .= html_writer::tag( 'button', get_string( 'getreport', 'block_course_participation_report' ), $submit_attr );
        $this->content->text    .= html_writer::end_tag( 'form' );

        return $this->content;
    }
}