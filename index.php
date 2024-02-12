<?php
include 'index.html';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function evaluateExpression($expression) {
        try {
            $expression = str_replace(',', '.', $expression);
            if (preg_match("/^[0-9+\-*/. ]+$/", $expression)) {
                $expression = str_replace(' ', '', $expression);
                return eval("return $expression;");
            } else {
                return "Error";
            }
        } catch (Exception $e) {
            return "Error";
        }
    }

    $beforeOperator = isset($_POST["beforeOperator"]) ? $_POST["beforeOperator"] : "";
    $afterOperator = isset($_POST["afterOperator"]) ? $_POST["afterOperator"] : "";

    if (isset($_POST["CE"])) {
        $beforeOperator = "0";
        $afterOperator = "";
    } elseif (isset($_POST["C"])) {
        $beforeOperator = "0";
        $afterOperator = "";
    } elseif (isset($_POST["Del"])) {
        if (!empty($afterOperator)) {
            $afterOperator = substr($afterOperator, 0, -1);
        } else {
            $beforeOperator = substr($beforeOperator, 0, -1);
        }
    } elseif (isset($_POST["operator"])) {
        if (!empty($beforeOperator) && is_numeric(substr($beforeOperator, -1))) {
            $afterOperator .= $beforeOperator . $_POST["operator"];
            $beforeOperator = "";
        }
    } elseif (isset($_POST["="])) {
        if (!empty($beforeOperator) && !empty($afterOperator) && is_numeric(substr($beforeOperator, -1))) {
            $result = evaluateExpression($afterOperator . $beforeOperator);
            $beforeOperator = $result;
            $afterOperator = "";
        }
    } else {
        if (empty($afterOperator)) {
            $beforeOperator .= isset($_POST["value"]) ? $_POST["value"] : "";
        } else {
            $afterOperator .= isset($_POST["value"]) ? $_POST["value"] : "";
        }
    }

    echo "<script>
              document.getElementById('equals').value = '$beforeOperator$afterOperator';
              document.getElementById('beforeOperator').value = '$beforeOperator';
              document.getElementById('afterOperator').value = '$afterOperator';
          </script>";
}
?>
