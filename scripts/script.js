$(document).ready(function () {
    // Login
    $("#input-email").blur(function () {
        if (!$(this).val()) {
            $("#emailAlertLogin").show();
        } else {
            $("#emailAlertLogin").hide();
        }
    });

    $("#input-password").blur(function () {
        if (!$(this).val()) {
            $("#passwordAlert").show();
        } else {
            $("#passwordAlert").hide();
        }
    });

    $("#loginForm").submit(function (e) {
        e.preventDefault();

        var email = $("#input-email").val();
        var password = $("#input-password").val();

        if (!isValidEmail(email) || password.trim() === "") {
            $("#errorAlertLogin").show();
            return false;
        }

        this.submit();
    });

    $("#username").blur(function () {
        if (!$(this).val()) {
            $("#usernameAlert").show();
        } else {
            $("#usernameAlert").hide();
        }
    });

    $("#new-email").blur(function () {
        if (!$(this).val()) {
            $("#emailAlertRegister").show();
        } else {
            $("#emailAlertRegister").hide();
        }
    });

    $("#new-password").blur(function () {
        if (!$(this).val()) {
            $("#passwordAlertNew").show();
        } else {
            $("#passwordAlertNew").hide();
        }
    });

    $("#verify-password").blur(function () {
        let passwordNew = $("#new-password").val();

        if (!$(this).val() || passwordNew != $(this).val()) {
            $("#passwordAlertVerify").show();
        } else {
            $("#passwordAlertVerify").hide();
        }
    });

    $("#registerForm").submit(function (e) {
        e.preventDefault();

        let username = $("#username").val();
        let email = $("#new-email").val();
        let passwordNew = $("#new-password").val();
        let passwordVerify = $("#verify-password").val();

        if (passwordNew != passwordVerify) {
            $("#errorAlertRegister").show();
            return false;
        } else if (
            !isValidEmail(email) ||
            passwordNew.trim() === "" ||
            username.trim() === ""
        ) {
            $("passwordAlertVerify").show();
        }

        this.submit();
    });

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

});
document.addEventListener('DOMContentLoaded', function() {
document.getElementById('search-button').addEventListener('click', function() {
    var searchTerm = document.getElementById('search-input').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the search results container with the response
            document.getElementById('search-results').innerHTML = this.responseText;
        }
    };
    xhr.send('search=' + encodeURIComponent(searchTerm));
});

$(document).ready(function () {
    // Existing code ...

    function editPost(postId) {
        fetch('editPostForm.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'postId=' + postId
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('editPostModal').innerHTML = html;
            // Assuming you have a modal or a specific div to display the edit form
            // Open the modal or make the div visible. Adjust as needed for your UI framework or setup.
            $('#editPostModal').modal('show'); // Bootstrap example
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Make editPost globally available by attaching it to the window object
    window.editPost = editPost;

    // Rest of your existing code...

});

function showEditModal() {
    document.getElementById('editPostModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editPostModal').style.display = 'none';
}


});