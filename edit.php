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


        <div class="row head_row_new"><span id="header_new"><h1>Редактировать товар</h1></span></div>

        <div id="content">




            <?php


            if (isset($_POST) && isset ($_POST['name']) && isset ($_POST['count'])
                && isset($_POST['type']) && isset($_POST['id']) )
            {
                $id = $_POST['id'];
                $link=new Link('localhost','root','','sklad');
                $item=new Item($_POST['id'],$_POST['type'],$_POST['name'],$_POST['count'],"2021-02-21 20:52:41");
                $link->EditItem($item);

                $uploaddir = './uploads/';
                $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                    $photo=$Link->GetPhotoName($id);
                    if ($photo=='NOT_FILE')
                    {
                        $link->AddPhotoToItem($_POST['id'], $uploadfile);
                    }
                    else
                    {
                        unlink($photo);
                        $link->AddPhotoToItem($_POST['id'], $uploadfile);
                    }

                }
                header('location:sklad.php');
            }

            $id = 0;
            if(isset($_GET['id'])){

                $id = $_GET['id'];
            }
            else header('location:sklad.php');

            $item_tov=$Link->GetItem($id);

            if ($item_tov==FALSE) :
                echo '<div id="table">Нет такого товара</div>';
            else:?>

                <div class="table">
                    <form enctype="multipart/form-data" method="post" action="edit.php" name="add_item" class="additem">
                        <h3>Редактировать товар</h3>

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

                        <hr class="featurette-divider">


                        <input type="hidden" name="id" value="<?php echo $item_tov->id; ?>" />

                        <label>Наименование:</label>
                        <input type="text" name="name" value="<?php echo $item_tov->name; ?>" />


                        <label>Количество:</label>
                        <input type="text" name="count" value="<?php echo $item_tov->count; ?>"   />
                        <label>Тип:</label>

                        <?php $types=$Link->GetTypes();?>
                        <input type="hidden" name="item_id" value="<?php echo $item_tov->type; ?>" />
                        <select name="type">
                            <?php foreach ( $types as $type ) :
                                $tp_id = false;
                                if ($item_tov->type==$type['type_name'])
                                    $tp_id = true;
                                else $tp_id = false;
                                ?>
                                <option "<?php if($tp_id) echo ' selected '?>" value="<?php echo $type['id']?>"><?php echo $type['type_name']?></option>
                            <?php endforeach;?>
                        </select>
                        <p class="error" id="error"></p>
                        <br>

                        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                        <!-- Название элемента input определяет имя в массиве $_FILES -->
                        Загрузить фото <input name="userfile" type="file" />
                        <br>
                        <br>
                        <input type="submit"  name="addgood" value="Редактировать товар" />
                    </form>
                    <br>
                    <form method="post" action="del_photo.php" name="add_item" class="additem">
                        <input type="hidden" name="id" value="<?php echo $item_tov->id; ?>" />
                        <input type="submit"  name="addgood" value="Удалить фото" />
                    </form>


                </div>
            <?php endif;?>

            <hr class="featurette-divider">
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