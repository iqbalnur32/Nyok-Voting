require('./bootstrap');

// Turbolinks
var Turbolinks = require("turbolinks")

if(Turbolinks.supported) {
    Turbolinks.start()
} else {
    console.warn("browser kamu tidak mendukung `Turbolinks`")
}