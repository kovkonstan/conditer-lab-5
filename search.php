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


    <div class="row head_row_new"><span id="header_new"><h1>Поиск</h1></span></div>

    <div id="content">
            <div class="table">
                <form method="get" action="search.php" class="additem">

                    <label>Введите запрос:</label>
                    <br>
                    <input type="text" name="search_query" />

                    <br>
                    <br>

                    <input type="submit"  name="addgood" value="Поиск" />
                </form>
            </div>
        <hr class="featurette-divider">
    </div>



    <div id="content">
        <?php

        $page = 1;
        $itemsByPage = 5;
        $search_query = "";
        if(isset($_GET['page'])){

            $page = $_GET['page'];
        }
        if(isset($_GET['itemsByPage'])){

            $itemsByPage = $_GET['itemsByPage'];
        }

        if(isset($_GET['search_query'])){

            $search_query = $_GET['search_query'];
        }

        $warehouse=$Link->GetItemsWithSearch($search_query, $page, $itemsByPage);

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
        <?php endif;?>
    </div>
    <hr class="featurette-divider">
<?php
include_once 'footer.php';
?>