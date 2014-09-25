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
			'ticks' => '7',
		);
		$atts = shortcode_atts($defaults, $atts);

		$content = wp_strip_all_tags($content);


		// Load all the octo script files. Loading them in
		// the shortcode instead of wp_enqueue_scripts ensures
		// that the JS is only loaded if it is actually needed
		wp_enqueue_script('octo-core', plugins_url('js/octo.js', __FILE__), array(), '1.0', FALSE);
		wp_enqueue_script('octo-compiler', plugins_url('js/compiler.js', __FILE__), array('octo-core'), '1.0', FALSE);
		wp_enqueue_script('octo-emulator', plugins_url('js/emulator.js', __FILE__), array('octo-core'), '1.0', FALSE);
		wp_enqueue_script('octo-press', plugins_url('js/octo-press.js', __FILE__), array('jquery', 'octo-core', 'octo-compiler', 'octo-emulator'), '1.0', FALSE);


		// Reminder: must store all shortcode HTML
		// in a variable, and return it at the end (do not echo)
		$output = '';


		// output the things that octo.js expects to
		// exist, just to temporarily avoid tons of JS errors
		$output .= '<div id="input"></div>';
		$output .= '<div id="output"></div>';
		$output .= '<div id="status"></div>';
		$output .= '<div id="emulator"></div>';


		// this canvas holds the running Octo program
		$output .= '<style>canvas#target{border: solid 1px black;}</style>';
		$output .= '<div>';
		$output .= '<canvas id="target" width="640" height="320"></canvas>';
		$output .= '</div>';


		// store the source code in a hidden div for later retrieval
		// (good enough, if hack-y, solution for now)
		$output .= '<div id="octo-source" style="display: none !important;">' . wp_strip_all_tags($content) . '</div>';


		// Once the document loads, call our customized octoPressRun
		// function to grab the source code from the above div and run it.
		//
		// Also, we overwrite the default colors with the ones from
		// the shortcode attributes
		$output .= '<script>';
		$output .= 'document.addEventListener( "DOMContentLoaded", function() {';
		$output .= '  TICKS_PER_FRAME = "' . $atts['ticks']      . '";';
		$output .= '  FILL_COLOR      = "' . $atts['fill']       . '";';
		$output .= '  BACK_COLOR      = "' . $atts['background'] . '";';
		$output .= '  BUZZ_COLOR      = "' . $atts['buzz']       . '";';
		$output .= '  QUIET_COLOR     = "' . $atts['quiet']      . '";';
		$output .= '  octoPressRun( document.getElementById( "octo-source" ).innerHTML);';
		$output .= '});';
		$output .= '</script>';


		return $output;
	}

}


new OctoPress();
