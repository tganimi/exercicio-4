<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Exercício 4</title>
    <meta name="description" content="Exercício 4">
    <meta name="author" content="Thiago Ganimi">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

</head>

<body>

<div class="container">

    <ul class="alert alert-danger d-none" role="alert"></ul>

    <form action="proccess/send_form.php" method="post">

        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" class="form-control" name="name" id="name" />
        </div>

        <div class="form-group">
            <label for="nome">Last name: </label>
            <input type="text" class="form-control" name="last_name" id="last-name" />
        </div>

        <div class="form-group">
            <label for="email">E-mail: </label>
            <input type="email" class="form-control" name="email" formnovalidate id="email" />
        </div>

        <div class="form-group">
            <label for="nome">Phone number: </label>
            <input type="text" class="form-control" name="phone_number" id="phone-number" />
        </div>

        <div class="form-group">
            <label for="login">Login: </label>
            <input type="text" class="form-control" name="login" id="login" />
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" />
        </div>

        <button type="submit" class="btn btn-primary" id="btn-send">Save</button>
    </form>
</div>

<script
    src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
    crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#btn-send').click(function(e){
            e.preventDefault();

            var name = $("#name").val();
            var lastName = $("#last-name").val();
            var email = $("#email").val();
            var phoneNumber = $("#phone-number").val();
            var login = $("#login").val();
            var password = $("#password").val();

            $.ajax({
                type: "POST",
                url: "/proccess/send_form.php",
                dataType: "json",
                data: {
                    name: name,
                    lastName: lastName,
                    email: email,
                    phoneNumber: phoneNumber,
                    login: login,
                    password: password
                },
                success : function(data) {

                    if (data.code == "200"){
                        $(".alert-danger").empty().addClass('d-none');
                        alert(data.msg);
                        location.reload();

                    } else {

                        $(".alert-danger").empty();

                        $.each( data.msg, function( key, value ) {
                            $(".alert-danger").append('<li>'+value+'</li>').removeClass('d-none');
                        });

                    }
                }
            });
        });
    });
</script>
</body>
</html>

