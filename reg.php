<?php
include_once 'header.php';
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
?>

        <div class="row head_row_new"><span id="header_new"><h1>Регистрация</h1></span></div>

        <div id="content">

                <div class="table">
                    <form action="save_user.php" method="post" name="add_item">
                        <p>
                            <label>Ваш логин:</label>
                            <br>
                            <input name="login" type="text" size="15" maxlength="15">
                        </p>

                        <p>
                            <label>Ваш пароль:</label>
                            <br>
                            <input name="password" type="password" size="15" maxlength="15">
                        </p>
                        <p class="error" id="error"></p>
                        <input type="submit" name="submit" value="Зарегистрироваться">
                    </form>



                </div>


            <hr class="featurette-divider">
        </div>

        <script type="text/javascript">

            var validator = new FormValidator('add_item', [{
                name: 'login',
                rules: 'required|callback_check_login'
            }, {
                name: 'password',
                rules: 'required|callback_check_password'
            }], function(errors, event) {
                if (errors.length > 0) {
                    var errorString = '';

                    for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                        errorString += errors[i].message + '<br />';
                    }

                    var el = document.getElementById('error');

                    el.innerHTML = errorString;
                }
            });

            validator.registerCallback('check_login', function(value) {
                if (value.length > 4) {
                    return true;
                }

                return false;
            }).setMessage('check_login', 'Введите корректный логин. Колическтво символов в логине должно быть 5 или более');


            validator.registerCallback('check_password', function(value) {
                if (value.length > 7) {
                    return true;
                }

                return false;
            }).setMessage('check_password', 'Введите корректный пароль. Колическтво символов в пароле должно быть 8 или более');

            validator.setMessage('required', 'Заполните, пожалуйста, все поля');
        </script>

        <hr class="featurette-divider">


<?php
include_once 'footer.php';
?>