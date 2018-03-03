import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

//Comment form in video/show
$('#comment_form').on('submit', function(e) {
    e.preventDefault();

    let url = Routing.generate('comment_new');
    let formSerialize = $(this).serialize();

    $.post(url, formSerialize, function(response) {
        console.log(response);

        let comments = document.getElementById('comments-video');

        let comment = document.createElement("div");
        comment.className += "comment";

        let username = document.createElement("span");
        username.className += "username-comment";
        username.innerHTML = response.user.username;
        comment.appendChild(username);

        let date = document.createElement("span");
        date.className += "date-comment";
        let datetime = new Date(response.datetime.date);
        date.innerHTML = datetime.toLocaleString();
        comment.appendChild(date);

        let body = document.createElement("p");
        body.className += "body-comment";
        body.innerHTML = response.text;
        comment.appendChild(body);

        comments.prepend(comment);

        document.getElementById('comment_text').value = "";

    }, 'json');

    return false;
});