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


    <div class="row head_row_new"><span id="header_new"><h1>Личный кабинет</h1></span></div>

    <div id="content">

            <div class="table">

                <h3>Информация о пользователе</h3>

                <label>Имя пользователя:</label>
                <label><?php echo $_SESSION['user'] ?></label>
                <br>
            </div>

    </div>



    <hr class="featurette-divider">


    <div class="r" style="padding-top: 15px; padding-bottom: 15px;">
        <!-- T056 -->
        <div class="t056">
            <div class="container centeredSection">
                <div class="lr_col_10 prefix_1">
                    <h1 field="title"><div style="font-size:28px;" data-customstyle="yes"><strong>Спеллер</strong></div></h1>
                    <div class="descr" field="descr"><div style="font-size:18px;" data-customstyle="yes">
                            <span>Яндекс.Спеллер помогает находить и исправлять орфографические ошибки в русском, украинском или английском тексте. Языковые модели Спеллера включают сотни миллионов слов и словосочетаний.</span>
                        </div></div>      </div>
            </div>
        </div>
    </div>

    <div class="r last-layer">
        <!-- T123 -->
        <div class="text-field">
            <textarea style="width: 100%;" id="text_field" class="text"></textarea>
        </div>
        <div class="button-field">
            <input id="correction" type="button" value="Исправить" class="button">
        </div>
    </div>

    <hr class="featurette-divider">

    <script type="text/javascript" src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
<?php
include_once 'footer.php';
?>