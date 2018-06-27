(function() {

var menu = document.getElementById('menu');

function showMenu(e) {
	e.stopPropagation();
	positionMenu();
	menu.style.visibility = 'visible';
	menu.style.opacity = '1';
}

function removeMenu() {
	menu.style.opacity = '0';
	setTimeout( function(){menu.style.visibility = 'hidden'}, 300 );
}

var positionMenu = ( function() {
	var menuRectangle = menu.getBoundingClientRect(),
		menuWidth = menuRectangle.right - menuRectangle.left;

	return function() {
		var menuIconPosition = document.getElementById('menuIcon').getBoundingClientRect();
		menu.style.top = menuIconPosition.top + 45 + 'px';
		menu.style.left = menuIconPosition.left - menuWidth/2 + 45/2 + 'px';
	}
})();

function redirect(to) {
	window.location.href = window.location.origin + '/' + to;
}

document.getElementById('separator').style.gridColumnStart = document.querySelector('nav').firstElementChild.children.length - 2;

document.getElementById('userIcon').addEventListener( 'click', function() {alert('Holla!') } );

document.getElementById('menuIcon').addEventListener( 'click', showMenu );
document.body.addEventListener( 'click', removeMenu );

document.getElementById('menu').addEventListener( 'click', function(e) { e.stopPropagation() } );
window.addEventListener( 'resize', positionMenu );

document.getElementById('my-images').addEventListener( 'click', function() { redirect('my-images') } );
document.getElementById('logout').addEventListener( 'click', function() { redirect('logout') } );

})();
