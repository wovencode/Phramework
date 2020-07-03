var app = new Framework7({
  // App root element
  root: '#app',
  // App Name
  name: '',
  // Disable Router
  router: false,
  // App id
  id: '',
  // Enable swipe panel
  panel: {
    swipe: 'left',
  }
});

var mainView = app.views.create('.view-main');




function hideElement(id) {
    document.getElementById(id).style.visibility = "hidden";
}