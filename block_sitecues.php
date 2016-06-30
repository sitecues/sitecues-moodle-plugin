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
 * sitecues block caps.
 *
 * @package    block_sitecues
 * @copyright  Keith Donaldson <kdonaldson@aisquared.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_sitecues extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_sitecues');
    }

    public function hide_header() {
        if ($this->config->badge_placement == 1) {
            return false;   // fixed toolbar
        } else {
            return true;    // inline
        }
    }

    public function html_attributes() {
        $attributes = parent::html_attributes(); // Get default values
        if ($this->config->badge_placement == 1) {
            $placement_string = '';
            $attributes['class'] .= ' sitecues_toolbar';
        } else {
            $attributes['class'] .= ' sitecues_inline';
        }
        return $attributes;
    }

    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();

        if ($this->config->badge_placement == 1) {
            $placement_string = '';
        } else {
            $placement_string = '<div id="sitecues-badge" style="display: inline-block; width: ' . $this->config->badge_height * 6.5 . 'px; height: ' . $this->config->badge_height . 'px;"></div>';
        }

        $this->content->text   = '
            <!-- START sitecues implementation code -->
            <!-- This code is for testing purposes only. Not authorized for production purposes -->
            <script data-provider="sitecues-config" type="application/javascript">
                var sitecues = window.sitecues = window.sitecues || {};
                sitecues.config = sitecues.config || {};
                sitecues.config.palette = \'' . $this->config->badge_color. '\';
                //sitecues.config.maxRewrapZoom = 1.3;
            </script>
            <script data-provider="sitecues" type="application/javascript">
                // DO NOT MODIFY THIS SCRIPT WITHOUT ASSISTANCE FROM SITECUES
                var sitecues = window.sitecues = window.sitecues || {};
                sitecues.config = sitecues.config || {};
                // THIS SITEID HAS A LIMITED LIFESPAN AND WILL EXPIRE
                sitecues.config.siteId = \'' . $CFG->sitecues_siteid . '\';
                sitecues.config.scriptUrl = \'https://js.sitecues.com/l/s;id=\'+sitecues.config.siteId+\'/js/sitecues.js\';
                (function () {
                    var script = document.createElement(\'script\'),
                        first  = document.getElementsByTagName(\'script\')[0];
                    script.type  = \'application/javascript\';
                    script.async = true;
                    script.src   = sitecues.config.scriptUrl;
                    first.parentNode.insertBefore(script, first);
                }());
            </script>
            <!-- END sitecues implementation code -->
            ' . $placement_string . '
            <style>
                body:not(.editing) div.sitecues_toolbar {
                    display: none;
                }
            </style>
        ';

        // user/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);

        return $this->content;
    }

    // Default case: the block can be used in courses and site index
    public function applicable_formats() {
        return array('all' => true);
    }

    public function instance_allow_multiple() {
          return true;
    }

    function has_config() {return true;}
}
