(function() {

var toggleMenu = ( function() {
	var style = window.getComputedStyle( document.getElementById('menu') );
	var menu = document.getElementById('menu');
	return function(e) {
		e.stopPropagation();
		positionMenu();
		if( style.getPropertyValue('visibility') === 'hidden' ) {
			menu.style.visibility = 'visible';
		} else {
			menu.style.visibility = 'hidden';
		}
	}
})();

function removeMenu() {
	document.getElementById('menu').style.visibility = 'hidden';
}

var positionMenu = ( function() {
	var menuRectangle = menu.getBoundingClientRect();
	var menuWidth = menuRectangle.right - menuRectangle.left;

	return function() {
		var menu = document.getElementById('menu'),
			menuIconPosition = document.getElementById('menuIcon').getBoundingClientRect();

		menu.style.top = menuIconPosition.top + 45 + 'px';
		menu.style.left = menuIconPosition.left - menuWidth/2 + 45/2 + 'px';
	}
})();

function redirect(to) {
	window.location.href = window.location.origin + '/' + to;
}

document.getElementById('menuIcon').addEventListener( 'click', toggleMenu );
document.getElementById('menu').addEventListener( 'click', function(e) { e.stopPropagation() } );
document.body.addEventListener( 'click', removeMenu );
window.addEventListener( 'resize', positionMenu );

document.getElementById('userIcon').addEventListener( 'click', function() { window.location.href = window.location.origin + '/profile'; });

document.getElementById('profile').addEventListener( 'click', function() { redirect('profile') } );
document.getElementById('my-images').addEventListener( 'click', function() { redirect('my-images') } );
document.getElementById('upgrade').addEventListener( 'click', function() { window.location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' } );
document.getElementById('logout').addEventListener( 'click', function() { redirect('logout') } );

})();