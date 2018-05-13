function sendForm(e) {
	e.preventDefault();

	xhr = new XMLHttpRequest();
	xhr.open( 'post', 'register.php', true );
	var formValues = {
		username: document.forms[0].user.value,
		password: document.forms[0].pwd.value
	}
	var form = new FormData();
	form.append( 'JSONForm', JSON.stringify(formValues) );
	xhr.send( form );

	return false;
}

document.getElementById('form').addEventListener( 'submit', sendForm );