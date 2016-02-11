<?php
include_once 'admincontrol.php';
?>
<html>
<head>
    <title>CMS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="stylesheet" href="css/menu.css" type="text/css"/>

    <script type="text/javascript" src="../js/jquery-1.7.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
    <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <script type="text/javascript">
        function showDiv(id) {
            $('.' + id).css('display', 'block');
            $('#dvNewButton').css('display', 'none');
            //$('#dvBtnNew').css('display', 'none');

        }
        function hideDiv(id) {
            $('.' + id).css('display', 'none');
            $('#dvNewButton').css('display', 'block');
            //$('#dvBtnNew').css('display', 'block');
        }

        function gotURL() {
            location.href = '?a=new';
        }

        function ShowDivContent(id) {
            var hdID = $('#hdID').val();
            var newValue = "";
            if (hdID.indexOf(id) > -1) {
                newValue = hdID.replace("," + id, "");
                $('#dvPhotos_' + id).css('display', 'none');
            } else {
                newValue = hdID + ',' + id;
                $('#dvPhotos_' + id).css('display', 'block');
            }
            $('#hdID').val(newValue);
        }

        $(document).ready(function () {
            $(".extLink").fancybox({
                'width':'70%',
                'height':'70%',
                'autoScale':false,
                'transitionIn':'none',
                'transitionOut':'none',
                'type':'iframe'
            });
        });

    </script>

    <script type="text/javascript">
        function submitForm() {
            $('.clsFooter').css('display', 'block');
            $('.clsSubmitForm').css('display', 'none');
            $('#frmForm').submit();
        }

        function submitFormSelected(id) {
            $('#' + id).submit();
        }
    </script>

</head>

<body>

<div id="dvHeader">
    <div id="dvMenu">
        <ul class="dropdown dropdown-horizontal" id="nav">
            <li><a href="index.php">Недвижимость в Бишкеке</a></li>
            <li><a href="estates.php">Недвижимость в Иссык-Куле</a></li>
            
            <li><a href="staff.php">Пользователи</a></li>

            <li><a href="text.php?id=1">О компании</a>
                <ul>
                    <li><a href="text.php?id=1">О компании</a></li>
                    <li><a href="text.php?id=2">Вакансии</a></li>
                    <li><a href="text.php?id=3">Контакты</a></li>
                    <li><a href="inventory.php">Инвентарь</a></li>
                </ul>
            </li>
            
            <li><a href="settings.php">Настройка</a></li>
            
        </ul>

    </div>
    <div id="dvLogout" style="color: #FFFFFF;">
        Добро пожаловать | <a
        href="login.php?a=logout" style="color:red">Выход</a>
    </div>
</div>

<div id="dvContent">
    
