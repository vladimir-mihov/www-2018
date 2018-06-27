( function() {

function noDefaultStopBubble(e) {
	e.stopPropagation();
	e.preventDefault();
}

function clearArea(e) {
	noDefaultStopBubble(e);
	document.getElementById('drop-text').style.visibility = 'hidden';
	document.getElementById('drop-area').style.border = '1px dashed #fff';
}

function restoreArea(e) {
	noDefaultStopBubble(e);
	document.getElementById('drop-text').style.visibility = 'visible';
	document.getElementById('drop-area').style.border = '1px solid #2e2f31';
}

var file = null;

function captureFile(e) {
	file = e.dataTransfer.files[0];
	document.getElementById('drop-text').innerText = file.name;
	restoreArea(e);
	showTags();
}

function uploadFile(e) {
	noDefaultStopBubble(e);
	var uploadFile = file ? file : e.target.file.files[0] ;
	var xhr = new XMLHttpRequest();
	var form_data = new FormData();
	xhr.onreadystatechange = function() {
		if( this.readyState == 4 ) {
			if( this.status == 200 ) {
				window.location.replace( 'http://localhost/i/' + xhr.response );
			} else {
				console.log( xhr.response );
			}
		}
	}
	xhr.open('post','upload',true);

	form_data.append( 'file', uploadFile );
	form_data.append( 'tags', document.forms[0].tags.value );

	xhr.send(form_data);
	return false;
}

function showTags() {
	document.getElementById('tags').hidden = false;
}

document.getElementById('drop-area').addEventListener( 'dragenter', clearArea );
document.getElementById('drop-area').addEventListener( 'dragleave', restoreArea );
document.getElementById('drop-area').addEventListener( 'dragover', function(e) { noDefaultStopBubble(e); } );
document.addEventListener( 'drop', captureFile );

document.getElementById('drop-text').addEventListener( 'dragenter', clearArea );
document.getElementById('drop-text').addEventListener( 'dragleave', restoreArea );
document.getElementById('drop-text').addEventListener( 'dragover', function(e) { noDefaultStopBubble(e); } );

document.getElementById('file').addEventListener( 'change', showTags );
document.getElementById('file-button').addEventListener( 'click', function() { document.getElementById('file').click() } );

document.getElementById('upload-form').addEventListener( 'submit', uploadFile );

})();
