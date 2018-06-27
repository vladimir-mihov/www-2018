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

function captureAndUpload(e) {
	restoreArea(e);
	var files = e.dataTransfer ? e.dataTransfer.files : this.file.files ;
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
	if( files.length !== 1 ) {
		alert( 'Only 1 file pre upload supported for now.' );
		return;
	} else {
		form_data.append( 'file', files[0] );
	}
	/*for( var i = 0 ; i < files.length ; ++i ) {
		var filename = files[i].name.split('.');
		if( filename[1] != 'png' && filename[1] != 'jpg' ) {
			alert( 'Supported formats are .png and .jpg' );
			return;
		}
		form_data.append( 'file' + i, files[i] );
	}*/
	xhr.send(form_data);
}

document.getElementById('file-button').addEventListener( 'click', function() { document.getElementById('file').click(); } );

document.getElementById('drop-area').addEventListener( 'dragenter', clearArea );
document.getElementById('drop-area').addEventListener( 'dragleave', restoreArea );
document.getElementById('drop-area').addEventListener( 'dragover', function(e) { noDefaultStopBubble(e); } );
document.addEventListener( 'drop', captureAndUpload );

document.getElementById('drop-text').addEventListener( 'dragenter', clearArea );
document.getElementById('drop-text').addEventListener( 'dragleave', restoreArea );
document.getElementById('drop-text').addEventListener( 'dragover', function(e) { noDefaultStopBubble(e); } );

document.getElementById('upload-form').addEventListener( 'submit', captureAndUpload );

})();
