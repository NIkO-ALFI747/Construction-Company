<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $title ?> - Building company</title>
    <link rel="stylesheet" href="/styles/mdb.min.css" />
    <link rel="stylesheet" href="/styles/container.css" />
    <link rel="stylesheet" href="/styles/header.css" />
    <link rel="stylesheet" href="/styles/flex-slider.css" />
    <link rel="stylesheet" href="/styles/teaser.css" />
    <link rel="stylesheet" href="/styles/table.css" />
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/styles/header.js" language="javascript"></script>
    <script src="/styles/flex-slider.js" language="javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/jquery.flexslider-min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  </head>
  <body style="background: rgb(67, 66, 62) no-repeat center center fixed; background-size: cover;">
    <div style="background:url(/images/background.jpg) no-repeat; background-size: 100%;">
      <!-- Header Start -->
      <div id="header">
        <div class="logo">
          <a href="/">Build With Us</a>
        </div>
        <nav>
          <form class="search" action=""> 
            <input name="q" placeholder="Search..." type="search">
          </form>
          <ul>
            <li>
              <a href="/">Главная</a>
            </li>
            <li>
              <a href="">Объекты строительства</a>
              <ul class="mega-dropdown">
                <li class="row">
                  <ul class="mega-col">
                    <li><a href="/objects/info_page">Информация об объектах строительства</a></li>
                    <li><a href="/objects/creation_page">Добавить</a></li>
                    <li><a href="/objects/edition_page">Изменить/Удалить</a></li>
                  </ul>
                  <ul class="mega-col">
                    <li><a href="/object_types/info_page">Информация о типах объектов строительства</a></li>
                    <li><a href="/object_types/creation_page">Добавить</a></li>
                    <li><a href="/object_types/edition_page">Изменить/Удалить</a></li>
                  </ul>
                  <ul class="mega-col">
                    <li><a href="/schedules/info_page">Информация о графике работ на объектах</a></li>
                    <li><a href="/schedules/creation_page">Добавить</a></li>
                    <li><a href="/schedules/edition_page">Изменить/Удалить</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="">Рабочие</a>
              <ul>
                <li><a href="#">Информация о рабочих</a></li>
                <li><a href="#">Добавить</a></li>
                <li><a href="#">Изменить/Удалить</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
      <!-- Header End -->
      <div class="content">
        <h2>Всё для ремонта и строительства</h2><br />
        <h3>Весь комплекс строительных работ</h3>
      </div>
