<?php
include_once 'header.php';
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
?>

<?php
session_start();
if($Link->LoginIsExist($_SESSION['user']) != "OK"){
    header("Location: form.php");
    exit;
}
?>


        <div class="row head_row_new"><span id="header_new"><h1>Информация о товаре</h1></span></div>

        <div id="content">




            <?php

            if (isset($_POST) && isset ($_POST['name']) && isset ($_POST['count'])
                && isset($_POST['type']) && isset($_POST['id']) )
            {
                $link=new Link('localhost','root','','sklad');
                $item=new Item($_POST['id'],$_POST['type'],$_POST['name'],$_POST['count'],"2021-02-21 20:52:41");
                $link->EditItem($item);
                header('location:sklad.php');
            }

            $id = 0;
            if(isset($_GET['id'])){

                $id = $_GET['id'];
            }

            $item_tov=$Link->GetItem($id);

            if ($item_tov==FALSE) :
                echo '<div id="table">Нет такого товара</div>';
            else:?>

                <div class="table">

                    <h3>Информация о товаре</h3>
                    <input type="hidden" name="id" value="<?php echo $item_tov->id; ?>" />

                    <label>Наименование:</label>
                    <label><?php echo $item_tov->name; ?></label>
                    <br>

                    <label>Количество:</label>
                    <label><?php echo $item_tov->count; ?></label>
                    <br>

                    <label>Тип:</label>
                    <label><?php echo $item_tov->type; ?></label>

                    <br>

                    <p>Фото:</p>

                    <?php
                    $id = 0;
                    if(isset($_GET['id'])){

                        $id = $_GET['id'];
                    }

                    $item_tov=$Link->GetItem($id);

                    $photo = $Link->GetPhotoName($id);

                    if ($photo=='NOT_FILE') :?>
                        <img src="./img/no-photo.jpg" border="2px"  >
                    <?php else:?>
                        <img src="<?php echo $photo; ?>" border="2px"  >
                    <?php endif;?>

                    <br>

                    <a href="edit.php?id=<?php echo $id; ?>">Редактировать</a>

                </div>

            <?php endif;?>
        </div>

        <script type="text/javascript">

            var validator = new FormValidator('add_item', [{
                name: 'name',
                rules: 'required|callback_check_name'
            }, {
                name: 'count',
                rules: 'required|numeric|callback_check_count'
            }, {
                name: 'type',
                rules: 'required'
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

            validator.registerCallback('check_count', function(value) {
                if (value > 0) {
                    return true;
                }

                return false;
            }).setMessage('check_count', 'Введите корректное количество');

            validator.registerCallback('check_name', function(value) {
                if (value.length > 2) {
                    return true;
                }

                return false;
            }).setMessage('check_name', 'Введите корректное имя');

            validator.setMessage('required', 'Заполните, пожалуйста, все поля');
            validator.setMessage('numeric', 'Введите пожалуйста числовое значение в поле Количество');
        </script>

        <hr class="featurette-divider">


<?php
include_once 'footer.php';
?>