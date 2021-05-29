<!DOCTYPE HTML>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

    <title>Simple Discord Embed Generator</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://incredible-gmod.ru/assets/icons/inc32icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://incredible-gmod.ru/assets/inc16icon.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="bootstrap_superhero.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <?php
        require("config.php");
        require("backend.php");
    ?>
</head>
<body>
    <?php
        if ($CONFIG["is not configured"] == true) {
    ?>
            <h1>read config.php</h1> 
    <?php
            die();
        } else {
    ?>
            <form>
                <h1>Simple discord embed generator</h1> 

                <br>
                <div id="alert_err" class="alert alert-success" role="alert" hidden>Success</div>
                <div id="alert_succ" class="alert alert-warning" role="alert" hidden>Error</div>

                <div class="form-group form-inline">
                    <input type="text" class="form-control" id="InputWebhook" placeholder="Webhook URL" value="<?php echo($code_result) ?>" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-light" id="CreateWebhook">Create one</button>
                    </div>
                </div>
            
                <div class="form-group">
                    <input type="text" class="form-control" id="InputNick" placeholder="Author name">
                </div>
            
                <div class="form-group">
                    <input type="text" class="form-control" id="InputAvatar" placeholder="Avatar image url">
                </div>

                <div class="form-group form-inline">
                    <input type="text" class="form-control" id="InputTitle" placeholder="Embed title">
                    <input class="form-control color-picker" type="color" id="InputColor" colorpick-eyedropper-active="false">
                </div>
            
                <div id="TextInputParent" class="form-group">
                    <textarea class="form-control" rows="3" placeholder="Message text" id="InputText" required>></textarea>
                </div>
            
                <button type='button' class='btn btn-primary' id="SendBtn">Send to discord</button>
            </form>
    <?php
        }
    ?>
</body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</html>
