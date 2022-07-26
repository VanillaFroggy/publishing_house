<?php
    session_start();
    
    $pageTitle = "Про нас";

    if($_SESSION["userRole"] == '1')
        require_once "admin_header.php";
    else
        require_once "user_header.php";

?>

<div class="description container mt-2">
    <div class="portfolio">
    <h1 class="text-center">Для авторов</h1>

        <div class="container about ml-4">
    <p>Дорогие коллеги!<br><br>

        Мы рассматриваем возможности сотрудничества по изданию ваших новых работ и переизданию уже имеющихся книг. Условия издания оговариваются индивидуально после рассмотрения заявки.<br><br>

        Срок рассмотрения заявки – от 2-х недель.<br><br><br>

        
        <b>Как подать заявку?</b><br><br>

        Отправить на адрес <u><b>capibararedactor@mail.ru</b></u> письмо, в котором нужно указать:<br><br>
        <ol>
            <li>
            Название работы;<br><br>
            </li>
            <li>
            Тематика/жанр;<br><br>
            </li>
            <li>
            Краткая информация об авторе;<br><br>
            </li>
            <li>
            Обязательства перед 3 лицами (если права на рукопись передавались 3 лицам/ рукопись выкладывалась в открытый доступ);<br><br>
            </li>
            <li>
            Краткая аннотация к работе (200-300 слов);<br><br>
            </li>
            <li>
            Полное оглавление;<br><br>
            </li>
            <li>
            Рукопись (объем от 7 авторских листов*) – полный текст, в формате doc/rtf<br><br>
            </li>
        </ol>
        * (1 лист 40 тыс. знаков с пробелами)<br><br>

        Ждем Ваших предложений!</p>

  </div>
  </div>
<?php
    include_once "footer.php";
?>
</div>