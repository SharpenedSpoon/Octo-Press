# Octo Press

Embed Octo programs within a post or page using a simple [octo] shortcode wrapper.

* Contributers: Ian Douglas
* Tags: octo, chip8, emulator, code
* Requires at least: 3.9
* Tested up to: 4.0
* Stable tag: 1.0.0
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html


## Description
Octo Press is a simple program which adds a shortcode, [octo] (and closing shortcode [/octo]) which will compile, run, and display Octo code within the tags.

Octo is a high-level assembler for the Chip8 virtual machine written by JohnEarnest. You can find out more about it <a href="https://github.com/JohnEarnest/Octo">here</a>, and try it out <a href="http://johnearnest.github.io/Octo/">here</a>.

### Example Usage
Just wrap Octo code with the [octo] ... [/octo] shortcode.
	[octo]
	: smile
		0b00100100
		0b00100100
		0b00000000
		0b10000001
		0b01000010
		0b00111100

	: body
		v2 := 0
		loop
			v0 := random 0b01111111
			v1 := random 0b00111111
			sprite v0 v1 6
			v2 += 1
			if v2 != 32 then
		again
		clear
	;

	: main
		# uncomment for SuperChip high resolution mode:
		#hires
		i := smile
		loop
			body
		again
	[/octo]

## Changelog

#### 1.0.0
* Initial plugin creation
