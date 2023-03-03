let change_featured_bg = (responsive_media) =>{
    let featured_posts = document.querySelectorAll('.featured_post');
    featured_posts.forEach(featured_post => {
        let featured_bg = featured_post.getAttribute('wide-background');
        let featured_responsive_bg = featured_post.getAttribute('responsive-background');
        if (responsive_media.matches) {
            featured_post.style.backgroundImage = 'url("'+ featured_bg +'")';
        } else {
            featured_post.style.backgroundImage = 'url("'+ featured_responsive_bg +'")';
        }
    });
};

var responsive_media = window.matchMedia("(min-width: 551px)");
change_featured_bg(responsive_media); // Call listener function at run time
responsive_media.addEventListener("change", change_featured_bg); // Attach listener function on state changes