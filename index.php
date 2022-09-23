<?php

if ( ! empty($_GET["numerKRS"])) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api-krs.ms.gov.pl/api/krs/OdpisAktualny/{$_GET['numerKRS']}?rejestr={$_GET['rejestr']}&format=json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($status_code == 200)
    {
        $data = json_decode($response, true);

        $rodzaj = $data["odpis"]["rodzaj"];
        $rejestr = $data["odpis"]["naglowekA"]["rejestr"];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Example</title>
</head>
<body>
    <form>
        <label for="numerKRS">Numer KRS</label>
        <input type="number" name="numerKRS" id="numerKRS">
        <label for="cars">Rejestr:</label>
        <select required name="rejestr" id="rejestr">
            <option disabled selected value> -- Wybierz -- </option>
            <option value="P">Przedsiębiorców</option>
            <option value="S">Stowarzyszeń</option>
        </select>
        <button>Wyświetl dane</button>
    </form>

    <?php 
    if ( ! empty($_GET["numerKRS"])) 
    {
        if ($status_code == 200)
        {
                echo "Rodzaj: ". $rodzaj."</br>";
                echo "Rejestr: ". $rejestr."</br>";
        }
        elseif ($status_code == 404)
        {
            echo "Podmiot nie znaleziony";
        }
        elseif ($status_code >= 500 && $status_code < 600)
        {
            echo "Błąd usługi";
        }
        else         
        {
            echo "Błąd";
        }
    }   
    ?>

</body>
</html>