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
        <div class="row head_row_new"><span id="header_new"><h1>Склад продукции</h1></span></div>

        <div id="content">
            <?php

            $page = 1;
            $itemsByPage = 5;
            if(isset($_GET['page'])){

                $page = $_GET['page'];
            }
            if(isset($_GET['itemsByPage'])){

                $itemsByPage = $_GET['itemsByPage'];
            }

            $warehouse=$Link->GetItemsByPage($page, $itemsByPage);

            if ($warehouse==FALSE) :
                echo '<div id="table">Нет ни одного товара</div>';
            else:?>

            <p>
                <?php
                if($page != 1)
                {
                    $prev = $page-1;
                    echo "<a href=\"sklad.php?page=1\"> << </a>";
                    echo "<a href=\"sklad.php?page=$prev\"> Пред </a>";
                }
                echo " Страница $page ";
                if($page != $warehouse["countOfPages"])
                {
                    $next = $page+1;
                    $countOfPages = $warehouse["countOfPages"];
                    echo "<a href=\"sklad.php?page=$next\"> След </a>";
                    echo "<a href=\"sklad.php?page=$countOfPages\"> >> </a>";

                }

                ?>
            </p>

            <table id="item-tabl">
                <thead>
                    <th>Наименование товара</th>
                    <th>Тип</th>
                    <th>Дата добавления</th>
                    <th>Количество</th>
                    <th>Действия</th>
                </thead>
                <tbody>
                <?php

                foreach ($warehouse["array"] as $item): ?>
                <tr class="row_item">
                    <td><?php echo $item->GetName();?></td>
                    <td><?php echo $item->GetType();?></td>
                    <td><?php echo $item->GetDate();?></td>
                    <td><?php echo $item->GetCount();?></td>
                    <td>
                        <a href="details.php?id=<?php echo $item->GetID(); ?>">Информация</a>
                        <br>
                        <a href="edit.php?id=<?php echo $item->GetID(); ?>">Редактировать</a>
                        <br>
                        <input type="submit" class="delitem" value="Удалить" name="<?php echo $item->GetID(); ?>" />
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <div><h3 class="right">Всего: <?php echo $Link->GetAllCount();?> товар(-ов)</h3> </div>
            <?php endif;?>

            <hr class="featurette-divider">

            <div class="table">
                <form method="post" action="add.php" name="add_item" class="additem">
                    <h3>Новый товар</h3>
                    <label>Наименование:</label>
                    <input type="text" name="name" />

                    <label>Количество:</label>
                    <input type="text" name="count" />
                    <label>Тип:</label>

                    <?php $types=$Link->GetTypes();?>
                    <select name="type">
                        <?php foreach ( $types as $type ) : ?>
                            <option value="<?php echo $type['id']?>"><?php echo $type['type_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <p class="error" id="error"></p>
                    <input type="submit"  name="addgood" value="Добавить" />
                </form>

            </div>

            <hr class="featurette-divider">

            <form method="post" class="addtype" name="addtype" action="addtype.php" >
                <h3>Добавить тип товара</h3>
                <input name="type_name" id="type_name" type="text"/>
                <p class="error" id="error_type"></p>
                <input type="submit" value="Добавить" />
            </form>
            <?php
            ?>
        </div>

        <script type="text/javascript">
            var validator_type = new FormValidator('addtype', [{
                name: 'type_name',
                rules: 'required|callback_check_name'
            }], function(errors, event) {
                if (errors.length > 0) {
                    var errorString = '';

                    for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                        errorString += errors[i].message + '<br />';
                    }

                    var el = document.getElementById('error_type');

                    el.innerHTML = errorString;
                }
            });

            validator_type.registerCallback('check_name', function(value) {
                if (value.length > 2) {
                    return true;
                }

                return false;
            }).setMessage('check_name', 'Введите корректное имя');
            validator_type.setMessage('required', 'Заполните, пожалуйста, все поля');

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

        <form method="get" action="del.php" id="delform">
            <input type="hidden" name="delid" id="delid" val=""/>
        </form>


<?php
include_once 'footer.php';
?>