<?php
/*
Plugin Name: Octo Press
Plugin URI: https://github.com/SharpenedSpoon/Octo-Press
Description: Embed Octo programs within a post or page using a simple [octo] shortcode wrapper.
Version: 1.0.0
Author: Ian Douglas
Author URI: http://subfacet.com/
License: GPL2


Copyright 2014  Ian Fox Douglas  (email : iandouglas@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class OctoPress {

	function __construct() {
		add_shortcode('octo', array(&$this, 'render_shortcode'));
	}

	function render_shortcode($atts, $content = null) {
		$defaults = array(
			'fill' => '#FFCC00',
			'background' => '#996600',
			'buzz' => '#FFAA00',
			'quiet' => '#000000',
		);
		$atts = shortcode_atts($defaults, $atts);


		// Load all the octo script files. Loading them in
		// the shortcode instead of wp_enqueue_scripts ensures
		// that the JS is only loaded if it is actually needed
		wp_enqueue_script('octo-core', plugins_url('js/octo.js', __FILE__), array('jquery'), '1.0', TRUE);
		wp_enqueue_script('octo-compiler', plugins_url('js/compiler.js', __FILE__), array('octo-core'), '1.0', TRUE);
		wp_enqueue_script('octo-emulator', plugins_url('js/emulator.js', __FILE__), array('octo-core'), '1.0', TRUE);


		//dump($args);
		//dump(plugins_url('js/script.js', __FILE__));


		// Reminder: must store all shortcode HTML
		// in a variable, and return it at the end (do not echo)
		$output = '';
		$output .= '<h4>Canvas:</h4>';
		$output .= '<canvas id="target" width="640" height="320"></canvas>';
		$output .= '<h4>End Canvas</h4>';
		$output .= '<style>canvas#target{border: solid 1px black;}</style>';

		$output .= '<br/><hr/><br/>';
		$output .= '<h4>Source Code:</h4>';
		$output .= '<pre style="background: ' . $atts['quiet'] . '; color: ' . $atts['fill'] . ';">';
		$output .= wp_strip_all_tags($content);
		$output .= '</pre>';

		/*
		var TICKS_PER_FRAME = 7;
		var FILL_COLOR  = "#FFCC00";
		var BACK_COLOR  = "#996600";
		var BUZZ_COLOR  = "#FFAA00";
		var QUIET_COLOR = "#000000";
		*/

		return $output;
	}

}


new OctoPress();
