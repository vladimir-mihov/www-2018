( function() {

var controls = document.getElementById('controls');
controls.style.gridTemplateColumns = 'repeat(' + controls.getElementsByTagName('button').length + ',1fr)';

var thumbsUp = document.getElementById('thumbsUp').firstElementChild;
var thumbsDown = document.getElementById('thumbsDown').firstElementChild;

function voteGood() {
	thumbsUp.style.background = '#4d982f';
	thumbsDown.style.background = 'none';
	document.forms[0].pressedButton.value = 1;
}

function voteBad() {
	thumbsDown.style.background = '#9e2424';
	thumbsUp.style.background = 'none';
	document.forms[0].pressedButton.value = 0;
}

var removeForm = document.getElementById('removeForm');
var curtain = document.getElementById('curtain');

function showRemoveForm(e) {
	e.stopPropagation();
	e.preventDefault();
	removeForm.style.visibility = 'visible';
	curtain.style.visibility = 'visible';
	removeForm.style.opacity = '1';
	curtain.style.opacity = '0.4';
	return false;
}

function hideRemoveForm() {
	removeForm.style.opacity = '0';
	curtain.style.opacity = '0';
	setTimeout( function() { removeForm.style.visibility = 'hidden'; curtain.style.visibility = 'hidden'; }, 300 );
}

if( voted !== undefined ) {
	voted ? voteGood() : voteBad()
}

document.getElementById('thumbsUp').addEventListener( 'click', voteGood );
document.getElementById('thumbsDown').addEventListener( 'click', voteBad );
document.getElementById('removeDummy').addEventListener( 'click', showRemoveForm );
document.getElementById('curtain').addEventListener( 'click', hideRemoveForm );

})();
