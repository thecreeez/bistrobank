<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Кредит</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="https://www.bystrobank.ru">Быстробанк</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="https://www.bystrobank.ru/cabinet/web/index.php">В личный кабинет</a>
      </li>
    </ul>
</div>
</nav>

<div class="container">
    <form>
        <div class="form-group">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-light active">
                    <input type="radio" name="options" id="option1" autocomplete="off" checked> Юридическое лицо
                </label>
                <label class="btn btn-light">
                    <input type="radio" name="options" id="option2" autocomplete="off"> Физическое лицо
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="firstNameLastName">ФИО</label>
            <input type="email" class="form-control" id="firstNameLastName" aria-describedby="emailHelp" placeholder="ФИО">
            <small id="emailHelp" class="form-text text-muted">Только русские символы.</small>
        </div>
        <div class="form-group">
            <label for="INN">ИНН</label>
            <input type="text" class="form-control" id="INN" placeholder="ИНН">
        </div>
        <div class="form-group">
            <label for="Birthday">Дата рождения</label>
            <input type="date" class="form-control" id="Birthday">
        </div>

        <div class="form-group">
            <label>Серия</label>
            <input type="text" class="form-control" id="passportFirst" placeholder="Серия">
            <label>Номер</label>
            <input type="text" class="form-control" id="passportSecond" placeholder="Номер">
            <label>Дата выдачи</label>
            <input type="date" class="form-control" id="passportDate">
        </div>
        <button type="submit" class="btn btn-primary">Дальше</button>
    </form>
</div>
</body>
</html>