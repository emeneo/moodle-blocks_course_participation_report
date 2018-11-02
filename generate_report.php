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
require_once('../../config.php');
require_login();

$postdata = data_submitted();
$postdata = (array)$postdata;

user_download_csv($postdata);

function user_download_csv($post) {
    global $DB;
    require_once('csvlib.class.php');

    $fields = array(
            'course_name'           => get_string( 'coursename', 'block_course_participation_report' ),
            'category'                => get_string( 'category', 'block_course_participation_report' ),
            'participants_total'    => get_string( 'participants_total', 'block_course_participation_report' ),
            'participants_esb'      => get_string( 'participants_esb', 'block_course_participation_report' ),
            'participants_inf'      => get_string( 'participants_inf', 'block_course_participation_report' ),
            'participants_tec'      => get_string( 'participants_tec', 'block_course_participation_report' ),
            'participants_ac'       => get_string( 'participants_ac', 'block_course_participation_report' ),
            'participants_td'       => get_string( 'participants_td', 'block_course_participation_report' ),
            'participants_bsc_sem1' => get_string( 'participants_bsc_sem1', 'block_course_participation_report' ),
            'participants_bsc_sem2' => get_string( 'participants_bsc_sem2', 'block_course_participation_report' ),
            'participants_bsc_sem3' => get_string( 'participants_bsc_sem3', 'block_course_participation_report' ),
            'participants_bsc_sem4' => get_string( 'participants_bsc_sem4', 'block_course_participation_report' ),
            'participants_bsc_sem5' => get_string( 'participants_bsc_sem5', 'block_course_participation_report' ),
            'participants_bsc_sem6' => get_string( 'participants_bsc_sem6', 'block_course_participation_report' ),
            'participants_bsc_sem7' => get_string( 'participants_bsc_sem7', 'block_course_participation_report' ),
            'participants_bsc_sem8' => get_string( 'participants_bsc_sem8', 'block_course_participation_report' ),
            'participants_m_sem1'   => get_string( 'participants_m_sem1', 'block_course_participation_report' ),
            'participants_m_sem2'   => get_string( 'participants_m_sem2', 'block_course_participation_report' ),
            'participants_m_sem3'   => get_string( 'participants_m_sem3', 'block_course_participation_report' ),
            'participants_m_sem4'   => get_string( 'participants_m_sem4', 'block_course_participation_report' )
            );

    @ob_end_clean();
    $filename = clean_filename('Course-Participation-Report');
    $csvexport = new csv_export_writer();
    $csvexport->set_filename($filename);
    $csvexport->add_data($fields);

    $sql = 'SELECT {course}.fullname AS course_name, {course_categories}.name AS category,
            COUNT({user_enrolments}.enrolid) AS participants_total,
            COUNT(users_esb.id) AS participants_esb,
            COUNT(users_inf.id) AS participants_inf,
            COUNT(users_tec.id) AS participants_tec,
            COUNT(users_ac.id) AS participants_ac,
            COUNT(users_td.id) AS participants_td,
            COUNT(users_bsc_sem1.id) AS participants_bsc_sem1,
            COUNT(users_bsc_sem2.id) AS participants_bsc_sem2,
            COUNT(users_bsc_sem3.id) AS participants_bsc_sem3,
            COUNT(users_bsc_sem4.id) AS participants_bsc_sem4,
            COUNT(users_bsc_sem5.id) AS participants_bsc_sem5,
            COUNT(users_bsc_sem6.id) AS participants_bsc_sem6,
            COUNT(users_bsc_sem7.id) AS participants_bsc_sem7,
            COUNT(users_bsc_sem8.id) AS participants_bsc_sem8,
            COUNT(users_m_sem1.id) AS participants_m_sem1,
            COUNT(users_m_sem2.id) AS participants_m_sem2,
            COUNT(users_m_sem3.id) AS participants_m_sem3,
            COUNT(users_m_sem4.id) AS participants_m_sem4
            FROM {course}
            INNER JOIN {enrol} ON {course}.id = {enrol}.courseid
            LEFT JOIN {user_enrolments} ON {enrol}.id = {user_enrolments}.enrolid
            LEFT JOIN {user} AS users_esb ON ({user_enrolments}.userid = users_esb.id AND users_esb.phone2 = "ESB")
            LEFT JOIN {user} AS users_inf ON ({user_enrolments}.userid = users_inf.id AND users_inf.phone2 = "INF")
            LEFT JOIN {user} AS users_tec ON ({user_enrolments}.userid = users_tec.id AND users_tec.phone2 = "TEC")
            LEFT JOIN {user} AS users_ac ON ({user_enrolments}.userid = users_ac.id AND users_ac.phone2 = "AC")
            LEFT JOIN {user} AS users_td ON ({user_enrolments}.userid = users_td.id AND users_td.phone2 = "TD")
            LEFT JOIN {user} AS users_bsc_sem1 ON ({user_enrolments}.userid = users_bsc_sem1.id AND users_bsc_sem1.department LIKE "1%B")
            LEFT JOIN {user} AS users_bsc_sem2 ON ({user_enrolments}.userid = users_bsc_sem2.id AND users_bsc_sem2.department LIKE "2%B")
            LEFT JOIN {user} AS users_bsc_sem3 ON ({user_enrolments}.userid = users_bsc_sem3.id AND users_bsc_sem3.department LIKE "3%B")
            LEFT JOIN {user} AS users_bsc_sem4 ON ({user_enrolments}.userid = users_bsc_sem4.id AND users_bsc_sem4.department LIKE "4%B")
            LEFT JOIN {user} AS users_bsc_sem5 ON ({user_enrolments}.userid = users_bsc_sem5.id AND users_bsc_sem5.department LIKE "5%B")
            LEFT JOIN {user} AS users_bsc_sem6 ON ({user_enrolments}.userid = users_bsc_sem6.id AND users_bsc_sem6.department LIKE "6%B")
            LEFT JOIN {user} AS users_bsc_sem7 ON ({user_enrolments}.userid = users_bsc_sem7.id AND users_bsc_sem7.department LIKE "7%B")
            LEFT JOIN {user} AS users_bsc_sem8 ON ({user_enrolments}.userid = users_bsc_sem8.id AND users_bsc_sem8.department LIKE "8%B")
            LEFT JOIN {user} AS users_m_sem1 ON ({user_enrolments}.userid = users_m_sem1.id AND users_m_sem1.department LIKE "1%M")
            LEFT JOIN {user} AS users_m_sem2 ON ({user_enrolments}.userid = users_m_sem2.id AND users_m_sem2.department LIKE "2%M")
            LEFT JOIN {user} AS users_m_sem3 ON ({user_enrolments}.userid = users_m_sem3.id AND users_m_sem3.department LIKE "3%M")
            LEFT JOIN {user} AS users_m_sem4 ON ({user_enrolments}.userid = users_m_sem4.id AND users_m_sem4.department LIKE "4%M")
            INNER JOIN {course_categories} ON {course}.category = {course_categories}.id
            WHERE {course_categories}.path LIKE ?
            AND FROM_UNIXTIME({course}.startdate) BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?)
            GROUP BY {course}.id
            ORDER BY {course}.startdate';

    $categories = array($post['category']);
    $participants = $DB->get_records_sql( $sql,
                        array( '/' . $post['category'] . '%',
                                $post['from'],
                                $post['to'] ) );

    foreach ($participants as $data) {
        if ( !$data ) {
            continue;
        }

        $participants_data = array();
        foreach ($fields as $field => $unused) {
            if (is_array($data->$field)) {
                $participants_data[] = reset($data->$field);
            } else {
                $participants_data[] = $data->$field;
            }
        }

        $csvexport->add_data($participants_data);
    }

    $csvexport->download_file();
    die;
}