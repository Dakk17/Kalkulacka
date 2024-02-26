<?php
// Název cookie pro ukládání čísla
$cookie_name1 = "num";

// Prázdná hodnota pro cookie s číslem
$cookie_value1 = "";

// Název cookie pro ukládání operátoru
$cookie_name2 = "operator";

// Prázdná hodnota pro cookie s operátorem
$cookie_value2 = "";

// Zpracování odeslaného čísla (funkce: zpracuj_cislo)
if (isset($_POST['num'])) {
  // Pokud je odeslané číslo, přidá se k aktuálně zobrazenému číslu
  $num = $_POST['input'] . $_POST['num'];
} else {
  // Pokud není odeslané číslo, nastaví se proměnná $num na prázdný řetězec
  $num = "";
}

// Zpracování odeslaného operátoru (funkce: zpracuj_operator)
if (isset($_POST['op'])) {
  // Uloží do proměnné $cookie_value1 hodnotu posledního zadaného čísla
  $cookie_value1 = $_POST['input'];

  // Vytvoří cookie s názvem $cookie_name1 a hodnotou $cookie_value1, platné 30 dnů
  setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/");

  // Uloží do proměnné $cookie_value2 hodnotu odeslaného operátoru
  $cookie_value2 = $_POST['op'];

  // Vytvoří cookie s názvem $cookie_name2 a hodnotou $cookie_value2, platné 30 dnů
  setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/");

  // Vymaže proměnnou $num
  $num = "";
}

// Zpracování stisku tlačítka rovná se (funkce: zpracuj_rovnase)
if (isset($_POST['equal'])) {
  // Uloží do proměnné $num hodnotu posledního zadaného čísla
  $num = $_POST['input'];

  // Výpočet podle uloženého operátoru v cookie
  switch ($_COOKIE['operator']) {
    case "+":
      $result = $_COOKIE['num'] + $num;
      break;
    case "-":
      $result = $_COOKIE['num'] - $num;
      break;
    case "*":
      $result = $_COOKIE['num'] * $num;
      break;
    case "/":
      $result = $_COOKIE['num'] / $num;
      break;
  }

  // Zkontroluje, zda je v cookie hodnota 'c', což pravděpodobně odpovídá tlačítku "C" (vymazat)
  switch ($_COOKIE) {
    case 'c':
      $result = 0; // Pokud je hodnota 'c', výsledek se nastaví na 0 (vynulování)
      break;
  }

  // Nastaví proměnnou $num na výsledek výpočtu
  $num = $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
</head>
<body>
        <div class="calc">
            <form action="" method="post" class="form">
                <br>
                <input type="text" class="maininput" name="input" value="<?php echo @$num ?>"> <br> <br>
                <input type="submit" class="numbtn" name="num"value="7">
                <input type="submit" class="numbtn" name="num"value="8">
                <input type="submit" class="numbtn" name="num"value="9">
                <input type="submit" class="calbtn" name="op"value="+"> <br><br>
                <input type="submit" class="numbtn" name="num"value="4">
                <input type="submit" class="numbtn" name="num"value="5">
                <input type="submit" class="numbtn" name="num"value="6">
                <input type="submit" class="calbtn" name="op"value="-"><br><br>
                <input type="submit" class="numbtn" name="num"value="1">
                <input type="submit" class="numbtn" name="num"value="2">
                <input type="submit" class="numbtn" name="num"value="3">
                <input type="submit" class="calbtn" name="op"value="*"><br><br>
                <input type="submit" class="c" name="delete"value="c">
                <input type="submit" class="numbtn" name="num"value="0">
                <input type="submit" class="equal" name="equal"value="=">
                <input type="submit" class="calbtn" name="op"value="/">


            </form>
        </div>
</body>
</html>
