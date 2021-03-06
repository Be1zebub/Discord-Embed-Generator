function hexdec(hexString) {
    hexString = (hexString + '').replace(/[^a-f0-9]/gi, '')
    return parseInt(hexString, 16)
}

var params = null;
function getParams() {
    if (params !== null) {}
    params = URI(window.location.search).query(true);
    return params;
}

function GetParam(p_name, p_default) {
    var param;
    if (typeof URLSearchParams !== "undefined") {
        var urlParams = new URLSearchParams(window.location.search);
        param = urlParams.get(p_name);
    } else {
        var urlParams = getParams();
        param = urlParams[p_name];
    }
    if (param === null) {
        param = p_default;
    }
    return param;
}

function setParam(key, value) {
    if (!window.history.pushState) {
        return;
    }

    if (!key) {
        return;
    }

    var url = new URL(window.location.href);
    var params = new window.URLSearchParams(window.location.search);
    if (value === undefined || value === null) {
        params.delete(key);
    } else {
        params.set(key, value);
    }

    url.search = params;
    url = url.toString();
    window.history.replaceState({url: url}, null, url);
}

function doOnReady(cback) {
    if (document.readyState == "loading") {
      document.addEventListener("DOMContentLoaded", cback);
    } else {
      cback();
    }
}

function readBody(xhr) {
    var data;
    if (!xhr.responseType || xhr.responseType === "text") {
        data = xhr.responseText;
    } else if (xhr.responseType === "document") {
        data = xhr.responseXML;
    } else {
        data = xhr.response;
    }
    return data;
}

var alert_timer = null;

function sendMessage() {
    var rawColor = pickr.getColor().toHEXA().toString();//document.getElementById('InputColor').value;

    var params = {
        username: document.getElementById('InputNick').value,
        avatar_url: document.getElementById('InputAvatar').value,
        embeds: [{
            "title": document.getElementById('InputTitle').value,
            "description": document.getElementById('InputText').value,
            "color": hexdec(rawColor),
        }],
    };

    if (alert_timer !== null) {
        clearTimeout(alert_timer);
        alert_timer = null;

        document.getElementById("alert_err").hidden = true;
        document.getElementById("alert_succ").hidden = true;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('InputWebhook').value);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.onreadystatechange = function() {
        var success = false;
        if (this.status >= 200 && this.status < 300) {
            success = true;
        }

        document.getElementById("alert_err").hidden = !success;
        document.getElementById("alert_succ").hidden = success;

        if (alert_timer !== null) {
            clearTimeout(alert_timer);
            alert_timer = null;
        }

        alert_timer = setTimeout(function() {
            document.getElementById("alert_err").hidden = true;
            document.getElementById("alert_succ").hidden = true;
        }, 2500);
    };
    xhr.send( JSON.stringify(params) );

    setParam("nick", params.username);
    setParam("avatar", params.avatar_url);
    setParam("title", params.embeds[0].title);
    setParam("message", params.embeds[0].description);
    setParam("color", rawColor);
}

document.addEventListener("DOMContentLoaded", function() {
	document.getElementById("SendBtn").onclick = sendMessage;

	document.getElementById("CreateWebhook").onclick = function() {
		window.location.replace(oauth2_url);
	};
});

var params2values = [];
params2values["InputNick"] = "nick";
params2values["InputAvatar"] = "avatar";
params2values["InputTitle"] = "title";
params2values["InputText"] = "message";
//params2values["InputColor"] = "color";

var default_pram_values = [];
default_pram_values["color"] = "#2894dc";

function GetQueryParam(param) {
    return GetParam(param, default_pram_values[param] !== undefined ? default_pram_values[param] : "");
}

var pickr;

doOnReady(function() {
    Object.entries(params2values).forEach(([id, param]) => {
        document.getElementById(id).value = GetQueryParam(param);
    });

    pickr = Pickr.create({
        el: ".color-picker",
        theme: "monolith", // monolith, classic, nano
        appClass: "color-picker",
        default: GetQueryParam("color"),
        defaultRepresentation: "HEX",
        position: "top-start",
        inline: false,
        disabled: false,
        swatches: [
            "rgba(244, 67, 54, 1)",
            "rgba(233, 30, 99, 1)",
            "rgba(156, 39, 176, 1)",
            "rgba(33, 150, 243, 1)",
            "rgba(3, 169, 244, 1)",
            "rgba(0, 188, 212, 1)",
            "rgba(0, 150, 136, 1)",
            "rgba(76, 175, 80, 1)",
            "rgba(139, 195, 74, 1)",
            "rgba(205, 220, 57, 1)",
            "rgba(255, 235, 59, 1)",
            "rgba(255, 193, 7, 1)"
        ],
        components: {
            preview: true,
            opacity: false,
            hue: true,
            interaction: {
                hex: true,
                rgba: true,
                hsla: true,
                hsva: true,
                cmyk: true,
                input: true,
                clear: false,
                save: false
            }
        }
    });

    pickr.on("change", (color, source, instance) => {
        pickr.applyColor();
    });
});
