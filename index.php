<div class="container">

    <form method="post" action="test.php">
        <label for="miasto">Wpisz miasta</label>
        <input type="text" name="miasto">

        <label for="gmina">Wpisz gminy</label>
        <input type="text" name="gmina">

        <label for="wojewodztwo">Wpisz województwa</label>
        <input type="text" name="wojewodztwo">

        <label for="rejestrPrzedsiebiorcy">rejestrPrzedsiebiorcy</label>
        <input type="checkbox" name="rejestrPrzedsiebiorcy" id="przedsiębiorcy">

        <label for="rejestrStowarzyszenia">rejestrStowarzyszenia</label>
        <input type="checkbox" name="rejestrStowarzyszenia" id="rejestrStowarzyszenia">

        <label for="strony">Ilosc stron</label>
        <input type="number" name="strony" min="1">

        <label for="createposts">Create posts?</label>
        <input type="checkbox" name="createposts" id="createposts">

        <input type="submit" value="PARSE KRS">
    </form>

    <form method="post" action="parser-ceidg.php">
        <label for="miasto">Wpisz miasta</label>
        <input type="text" name="miasto">

        <label for="gmina">Wpisz gminy</label>
        <input type="text" name="gmina">

        <label for="wojewodztwo">Wpisz województwa</label>
        <input type="text" name="wojewodztwo">

        <label for="createposts">Create posts?</label>
        <input type="checkbox" name="createposts" id="createposts">

        <!-- <label for="rejestrPrzedsiebiorcy">rejestrPrzedsiebiorcy</label>
        <input type="checkbox" name="rejestrPrzedsiebiorcy" id="przedsiębiorcy">

        <label for="rejestrStowarzyszenia">rejestrStowarzyszenia</label>
        <input type="checkbox" name="rejestrStowarzyszenia" id="rejestrStowarzyszenia"> -->

        <input type="submit" value="PARSE CEIDG">
    </form>
</div>

<style>
    body{
        background-color:#bababa;
    }

    .container{
        max-width:80%;
        margin:20px auto;
        justify-content: space-between;
        display: flex;
        align-items: flex-start;
        flex-wrap:wrap;
        gap:30px 0;
    }

    .container h1{
        font-size:50px;
        text-align:center;
        font-weight:800;
    }

    form{
        width:auto;
        margin-top:50px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        flex-direction: column;
    }

    form label{
        font-size:32px;
        margin-top:25px;
        margin-bottom:10px;
    }

    form input[type="submit"] {
        font-size:32px;
        border-radius:5px;
        padding:10px 20px;
        background-color:white;
        color:black;
        border:1px solid red;
        cursor:pointer;
        transition:.2s;
        margin-top:25px;
    }

    form input[type="text"] {
        font-size:32px;
        border-radius:5px;
        padding:10px 20px;
        background-color:white;
        color:black;
        border:1px solid red;
        cursor:pointer;
        transition:.2s;
    }

    form input[type="submit"]:hover{
        background-color:red;
    }
</style>