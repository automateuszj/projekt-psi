console.log("JS działa");

document.addEventListener("DOMContentLoaded", function() {

    let buttons = document.querySelectorAll(".btn-edit");

    buttons.forEach(function(button) {

        button.addEventListener("click", function() {

            let postDiv = this.closest(".post");

            let content = postDiv.querySelector(".post-content");
            let form = postDiv.querySelector(".edit-form");

            content.style.display = "none";
            form.style.display = "block";
        });

    });

    let cancel_buttons = document.querySelectorAll(".btn-cancel");

    cancel_buttons.forEach(function(button) {

        button.addEventListener("click", function() {

            let postDiv = this.closest(".post");

            let content = postDiv.querySelector(".post-content");
            let form = postDiv.querySelector(".edit-form");

            content.style.display = "block";
            form.style.display = "none";
        });

    });

});