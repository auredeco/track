(function(){
    const hamburger = document.getElementsByClassName('fa-bars')[0];
    const nav = document.getElementById('main-nav');

    hamburger.onclick = function(){
        nav.classList.toggle('nav-open');
    }
})();