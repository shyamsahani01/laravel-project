function toggleOrder(item) {
    var items = $(".order-no");
    $.map(items, (ele) => {
        if ($(ele).hasClass("active")) {
            $(ele).removeClass("active")
        }
    })
    $(item).toggleClass("active");
}

function toggleDesign(item) {
    var items = $(".design-image");
    $.map(items, (ele) => {
        if ($(ele).hasClass("active")) {
            $(ele).removeClass("active")
        }
    })
    $(item).toggleClass("active");
}

$(".order-no").on("click", (event) => {
    toggleOrder(event.target)
});

$(".design-image").on("click", (event) => {
    toggleDesign(event.target)
});

/* ---- particles.js config ---- */

particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 100,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#000000"
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0.1,
                "color": "#ff00ff"
            },
            "polygon": {
                "nb_sides": 5
            },
            "image": {
                "src": "img/github.svg",
                "width": 100,
                "height": 100
            }
        },
        "opacity": {
            "value": 0.5,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.3,
                "sync": false
            }
        },
        "size": {
            "value": 5,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 0.5,
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": true,
            "attract": {
                "enable": true,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                "mode": "grab"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 140,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200,
                "duration": 0.4
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});


class Loader {
    constructor(loader_id, image, text) {
        if (loader_id) {
            this.loader = document.getElementById(loader_id)
            this.loader.className = "loader"

            this.text = text ? text : "Loading...";
            this.image = image ? image : "./assets/images/spinner.gif";
            this.setup();
        } else {
            throw new Error("loader id is required.")
        }
    }
    setup() {
        this.img = document.createElement("img")
        this.img.src = this.image
        this.img.className = "image"
        this.p = document.createElement("p")
        this.p.className = "text"
        this.p.innerText = this.text

        this.loader.appendChild(this.img)
        this.loader.appendChild(this.p)
    }

    show() {
        try {
            this.loader.classList.add("active")
            return true
        } catch (err) {
            return false
        }
    }
    hide() {
        try {
            this.loader.classList.remove("active")
            return true
        } catch (err) {
            return false
        }
    }
    toggle() {
        try {
            this.loader.classList.toggle("active")
            return true
        } catch (err) {
            return false
        }
    }
    setText(text) {
        this.text = text
        this.p.innerText = this.text
    }

}