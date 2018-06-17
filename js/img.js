( function() {

function vote(vote) {
	xhr = new XMLHttpRequest();
	var form = new FormData();
	xhr.open( 'post', window.location.origin + '/vote' );
	form.append( 'imageid', imageid );
	form.append( 'uid', uid );
	form.append( 'vote', vote );
	xhr.send(form);
}

function votedGood() {
	document.getElementById('thumbsUp').firstElementChild.style.background = '#4d982f';
	document.getElementById('thumbsDown').firstElementChild.style.background = 'none';
}

function votedBad() {
	document.getElementById('thumbsDown').firstElementChild.style.background = '#9e2424';
	document.getElementById('thumbsUp').firstElementChild.style.background = 'none';
}

function thumbsUp() {
	vote(1);
	votedGood();
}

function thumbsDown() {
	vote(0);
	votedBad();
}

if( voted !== undefined ) {
	voted ? votedGood() : votedBad() ;
}

document.getElementById('thumbsUp').addEventListener( 'click', thumbsUp );
document.getElementById('thumbsDown').addEventListener( 'click', thumbsDown );
document.getElementById('report').addEventListener( 'click', function() { alert( 'In development!' ) } );

})();