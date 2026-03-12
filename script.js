document.addEventListener("DOMContentLoaded", function() {

    let like_buttons = document.querySelectorAll(".likeBtn");

    like_buttons.forEach(function (button) {

    button.addEventListener("click", function () {
        debugger;
        let postId = button.dataset.id;
        //ajax
        fetch('adding_likes.php?post_id=' + postId)
        .then(function (response) {
            debugger;
            if (response.status === 200) {
                return response.json();
            }
        })
        .then(function (body) {
            debugger;
            let elements = document.querySelectorAll('.likesNumber');

            let target = Array.from(elements).find(e => e.dataset.id === body.post_id);
            target.innerText = body.likes_number
        })
    }) 
});

    let edit_buttons = document.querySelectorAll(".btn-edit");

    edit_buttons.forEach(function(button) {

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

    // let delete_photo_buttons = document.querySelectorAll(".btn-delete-photo");

    // delete_photo_buttons.forEach(function(button) {

    //     button.addEventListener("click", function() {

    //         let postDiv = this.closest(".post");

    //         let content = postDiv.querySelector(".post-content");
    //         let form = postDiv.querySelector(".edit-form");

    //         content.style.display = "block";
    //         form.style.display = "none";
    //     });

    // });

});