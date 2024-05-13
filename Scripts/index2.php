<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['color']) && !empty($_POST['color'])) {
            $color = $_POST['color'];
            $color = htmlspecialchars($color);
            file_put_contents("http://192.168.70.133/database.csv", $color);
            echo '<meta http-equiv="refresh" content="0">';
        }
    }
?>
<!DOCTYPE html>
<!--Author Elias De Hondt-->
<html lang="en">
    <head>
        <!--Meta + Title-->
        <title>Redundant Web Servers DEMO</title>
        <meta property="og:title" content="Redundant Web Servers DEMO"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Meta + Title-->
        <!--CSS-->
        <style>
            body {
                background-color: <?php echo htmlspecialchars(file_get_contents("http://192.168.70.133/database.csv")); ?>;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                color: #f0f0f0;
            }
            input[type="color"] {
                width: 200px;
                height: 200px;
                border: none;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            input[type="submit"], h1, h2 {
                background-color: #4F94F0;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
                font-size: 24px;
                transition: background-color 0.3s ease;
            }
            input[type="submit"]:hover {
                background-color: #3F83E0;
            }
            form {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        </style>
        <!--CSS-->
    </head>
    <body>
    <h1>Redundant Web Servers DEMO</h1>
    <h1>Webserver 2</h1>
    <p>This page is hosted on multiple web servers. The background color is stored in a database file. When you change the color, the change will be visible on all servers.</p>
    <br>
    <form method="post">
        <input type="color" id="color" name="color">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <!--Footer-->
    <footer id="footer"></footer>
    <!--Footer-->
    <!--JS-->
    <script>
        function loadHTML(myDivId, url) {
            let xmlhttp;
            if (window.XMLHttpRequest) xmlhttp = new XMLHttpRequest();
            else xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
                    if(xmlhttp.status == 200) {
                        document.getElementById(myDivId).innerHTML = xmlhttp.responseText;
                        let scripts = document.getElementById(myDivId).getElementsByTagName('script');
                        for (let i = 0; i < scripts.length; i++) {
                            let script = document.createElement('script');
                            script.text = scripts[i].text;
                            document.body.appendChild(script);
                        }
                    }
                }
            }
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
        loadHTML("footer", "https://eliasdh.com/assets/includes/external-footer.html");
    </script>
    <!--JS-->
    </body>
</html>