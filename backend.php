<?php
    $client_id = $CONFIG["client_id"];
    $client_secret = $CONFIG["client_secret"];

    $redirect_uri = (isset($_SERVER["HTTPS"]) ? "https" : "http") ."://". $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]); # this page url, "https://incredible-gmod.ru/embedgenerator/" for my site

    $oauth2_url = "https://discord.com/api/oauth2/authorize?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=webhook.incoming";
    echo("<script> var oauth2_url = \"$oauth2_url\" </script>");

    if (isset($_GET["code"])) {
        $code = $_GET["code"];
        $fname = "cache/$code.lock";

        if (file_exists($fname) && ((time() - filemtime($fname)) < 3600)) {
            $result = file_get_contents($fname);
            $arr = json_decode($result);
        } else {
            $data = array(
                "name"          => "Simple Embed Generator",
                "avatar"        => "https://incredible-gmod.ru/assets/elite_emotes_collection/roflan_batya.png",
                "scope"         => "webhook.incoming",
                "grant_type"    => "authorization_code",
                "redirect_uri"  => $redirect_uri,
                "client_id"     => $client_id,
                "client_secret" => $client_secret,
                "code"          => $code
            );

            $options = array(
                "http" => array(
                  "redirect_uri"  => "Content-type: application/x-www-form-urlencoded\r\n",
                  "method"  => "POST",
                  "content" => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents("https://discord.com/api/v6/oauth2/token", false, $context);
            $code_result = "";

            if ($result !== FALSE) {
                file_put_contents($fname, $result);
                $arr = json_decode($result);
            }
        }

        if (!is_null($arr) && !is_null($arr->webhook) && !is_null($arr->webhook->url)) {
            $code_result = $arr->webhook->url;
        }
    }
?>
