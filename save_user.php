<?php

    include_once 'classes.php';
    $Link = new Link('localhost', 'root', '', 'sklad');

    if (isset($_POST['login']))
    {
        $login = $_POST['login'];
        if ($login == '')
        {
            unset($login);
        }
    }

    if (isset($_POST['password']))
    {
        $password=$_POST['password'];
        if ($password =='')
        {
            unset($password);
        }
    }


    if (empty($login) or empty($password))
    {
        exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }

    //если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);

    //удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);

    if ($Link->LoginIsExist($login)=="OK")
    {
        exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин. <a href='reg.php'>Вернуться к регистрации</a>");
    }

    // если такого нет, то сохраняем данные
    $hash = md5($password);
    $Link->Register($login,$hash);
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='form.php'>Войти</a>";

?>