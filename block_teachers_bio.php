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

/**
 * Form for editing HTML block instances.
 *
 * @package   block_teachers_bio
 * @copyright 2024 Thiago Ramos Cunha Pinheiro <thiagoramoscp@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//require(__DIR__ . '/config.php');
//require_once('../../config.php');

class block_teachers_bio extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    function init() {
        $this->title = get_string('pluginname', 'block_teachers_bio');
    }

    /**
     * Gets the block contents.
     *blockteateac
     * @return string The block HTML.
     */
    function get_content() {
        global $COURSE;
        global $USER;
        global $DB;
        global $OUTPUT;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;

        $roleassignments = $DB->get_records('role_assignments',['contextid' => $this->page->context->id, 'roleid' => '3']);
        $teachers = [];

        $a = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>/n<br><br><br>/n/n/n/n/n<br><br><br><br>';
        var_dump($a);

        for ($i = 0; $i < count($roleassignments); $i++) {
            var_dump($i);
            
        }
        var_dump($roleassignments);
        foreach ($roleassignments as $roleassignment) {

            //var_dump($roleassignment->contextid);
            var_dump(count($roleassignments));
            $teacherinfo = $DB->get_record('user',['id' => $roleassignment->userid]);
            var_dump($teacherinfo);
            
            $teacher = new stdClass;
            $teacher->contextid = $roleassignment->contextid;
            
            $teacher->id = $teacherinfo->id;
            $teacher->picture = $teacherinfo->picture;
            $teacher->imagealt = $teacherinfo->imagealt;
            $teacher->firstname = $teacherinfo->firstname;
            $teacher->firstnamephonetic = $teacherinfo->firstnamephonetic;
            $teacher->lastnamephonetic = $teacherinfo->lastnamephonetic;
            $teacher->middlename = $teacherinfo->middlename;
            $teacher->alternatename = $teacherinfo->alternatename;
            $teacher->lastname = $teacherinfo->lastname;
            $teacher->email = $teacherinfo->email;
            $teacher->profileimg = format_text($OUTPUT->user_picture($teacher), FORMAT_HTML);

            array_push($teachers, $teacher);
        }
        var_dump($teachers);
        
        $c = format_text($OUTPUT->user_picture($teachers[0]), FORMAT_HTML);
        var_dump($c);

        $this->content->footer = $COURSE->id . ' ' . $USER->id . ' ' . $this->page->context->id;

        


        //$this->content->text = '';

        $templatecontext = [
            'teachers' => $teachers,
        ];

        $this->content->text = $OUTPUT->render_from_template('block_teachers_bio/content', $templatecontext);
        
        return $this->content;
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return [
            'admin' => false,
            'site-index' => false,
            'course-view' => true,
            'mod' => false,
            'my' => false,
        ];
    }

}
