debugger;
//przypisanie zmiennej button przycisku z html
let buttons = document.querySelectorAll(".likeBtn");

buttons.forEach(function (button) {

    //sprawdzanie czy zostalo wcisniete
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