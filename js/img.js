( function() {

function vote(vote) {
	var xhr = new XMLHttpRequest();
	var form = new FormData();
	xhr.open( 'post', window.location.origin + '/vote', true );
	form.append( 'imageid', imageid )
	form.append( 'uid', uid );
	form.append( 'vote', vote );
	xhr.send(form);
}

function votedGood() {
	document.getElementById('thumbsUp').style.background = '#4d982f';
	document.getElementById('thumbsDown').style.background = 'none';
}

function votedBad() {
	document.getElementById('thumbsDown').style.background = '#9e2424';
	document.getElementById('thumbsUp').style.background = 'none';

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