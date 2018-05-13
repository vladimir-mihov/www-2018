function validate() {
	var value, valuePattern, errMsg;
	var err = document.getElementById('error-block');

	switch( this.id ) {
		case 'user':
			value = document.forms[0].user.value;
			valuePattern = /^[a-zA-Z_][a-zA-Z0-9_]{5,63}$/;
			break;
		case 'pwd':
			value = document.forms[0].pwd.value;
			valuePattern = /^.{6,64}$/;
			break;
		case 'cpwd':
			value = document.forms[0].cpwd.value;
			valuePattern = /^.{6,64}$/;
			break;
		case 'email':
			value = document.forms[0].email.value;
			valuePattern = /(?=^.{0,64}$)^\w+@[a-zA-Z]+\.[a-zA-Z]+$/;
			break;
	}
	
	if( !valuePattern.test(value) && value.length > 0 ) {
		
		switch( this.id ) {
			case 'user':
				if( /^[0-9].*$/.test(value) )
					errMsg = 'Username should begin with a letter or underscore.';
				else if( /^.{1,5}$/.test(value) )
					errMsg = 'Username should be atleast 6 characters long.';
				else if( /^.{65,}$/.test(value) )
					errMsg = 'Username shouldn\'t exceed 64 characters.';
				else {
					var illegalChars = value.split('').filter( ch => /\W/.test(ch) ).sort().filter( function(val,i,arr) {
																										return val != arr[i+1];
																									} ).join('');
					errMsg = 'Username can\'t contain: ' + illegalChars;
				}
				break;
			case 'pwd':
			case 'cpwd':
				errMsg = 'Password should be atleast 6 characters long.';
				break;
			case 'email':
				errMsg = 'Invalid e-mail.';
		}
		
		this.classList.add( 'invalid' );
		this.classList.remove( 'valid' );
		var coordinates = this.getBoundingClientRect();
		err.style.display = 'block';
		err.innerHTML = errMsg;
		err.style.top = coordinates.top + 'px';
		err.style.left = coordinates.right + 7 + 'px';
	} else if( value.length == 0 ){
		this.classList.remove( 'invalid' );
		this.classList.remove( 'valid' );
		err.style.display = 'none';
	} else {
		this.classList.add( 'valid' );
		this.classList.remove( 'invalid' );
		err.style.display = 'none';
	}
}

function removeErrorBlock() {
	document.getElementById('error-block').style.display = 'none';
}

function validatePasswords() {
	var x = document.forms[0].pwd.value;
	var y = document.forms[0].cpwd.value;
	var err = document.getElementById('error-block');
	var cpwdPosition = this.getBoundingClientRect();
	if( y.length == 0 ) {
		this.classList.remove( 'invalid' );
		this.classList.remove( 'valid' );
		err.style.display = 'none';
	} else if( x != y ) {
		this.classList.add('invalid');
		this.classList.remove('valid');
		err.style.display = 'block';
		err.innerHTML = 'Passwords not matching';
		err.style.top = cpwdPosition.top + 'px';
		err.style.left = cpwdPosition.right + 7 + 'px';
	} else {
		this.classList.add('valid');
		this.classList.remove( 'invalid' );
		err.style.display = 'none';
	}
}

function submit(e) {
	if( document.getElementsByClassName('invalid').length > 0 || Array.from(document.getElementsByTagName('input')).some(function(val) { return val.value.length == 0; }) ) {
		e.preventDefault();
		var oldColor = '#5c69ff';
		var submitButton = document.getElementById('submit');
		submitButton.style.background = '#900909';
		setTimeout( function(elem,bg) { elem.style.background = bg; }, 200, submitButton, oldColor );
		return false;
	}
}

document.getElementById('user').addEventListener('focusin',validate);
document.getElementById('user').addEventListener('keyup',validate);
document.getElementById('user').addEventListener('focusout',removeErrorBlock);

document.getElementById('pwd').addEventListener('focusin',validate);
document.getElementById('pwd').addEventListener('keyup',validate);
document.getElementById('pwd').addEventListener('focusout',removeErrorBlock);

document.getElementById('email').addEventListener('focusin',validate);
document.getElementById('email').addEventListener('keyup',validate);
document.getElementById('email').addEventListener('focusout',removeErrorBlock);

document.getElementById('cpwd').addEventListener('focusin',validatePasswords);
document.getElementById('cpwd').addEventListener('keyup',validatePasswords);
document.getElementById('cpwd').addEventListener('focusout',removeErrorBlock);

document.getElementById('form').addEventListener('submit', submit);