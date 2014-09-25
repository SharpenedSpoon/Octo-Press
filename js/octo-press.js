// Scripts similar to Octo's JS (specifically, methods in octo.js),
// but specific to the way Octo Press is being handled.


function octoPressCompile(sourceCode) {
	// var input  = document.getElementById("input");
	// var output = document.getElementById("output");
	// var status = document.getElementById("status");

	var MAX_ROM = 3584;

	// var c = new Compiler(input.value);
	var c = new Compiler(sourceCode);
	try {
		// output.value = "";
		// output.style.display = "none";
		c.go();
		if (c.rom.length > MAX_ROM) {
			throw "Rom is too large- " + (c.rom.length-MAX_ROM) + " bytes over!";
		}
		// output.value = display(c.rom);
		// output.style.display = "inline";
		// status.innerHTML = ((c.rom.length) + " bytes, " + (MAX_ROM-c.rom.length) + " free.");
		// status.style.backgroundColor = "black";
		// if (c.schip) { status.innerHTML += " (SuperChip instructions used)"; }
	}
	catch(error) {
		// status.style.backgroundColor = "darkred";
		// status.innerHTML = error;
		if (c.pos != null) {
			// input.focus();
			// input.selectionStart = c.pos[1]-1;
			// input.selectionEnd   = c.pos[2]-1;
		}
		return null;
	}

	return {
		rom        :c.rom,
		breakpoints:c.breakpoints,
		aliases    :c.aliases,
		labels     :c.dict
	};
}

function octoPressRun(sourceCode) {
	octoPressRunRom(octoPressCompile(sourceCode));
}

function octoPressRunRom(rom) {
	if (rom === null) { return; }
	init(rom);
	// document.getElementById("emulator").style.display = "inline";
	// document.getElementById("emulator").style.backgroundColor = QUIET_COLOR;
	window.addEventListener("keydown", keyDown, false);
	window.addEventListener("keyup"  , keyUp  , false);
	intervalHandle = setInterval(render, 1000/60);
}
