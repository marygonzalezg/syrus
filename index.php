<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Syrus location</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.php" />
</head>
    <body>

      <div class="grid">
      <div class="title">
        <?php
        require 'DB.php'
        ?>
        </div>
        <div class="header">
        <?php
        require 'maps.php';
        ?>
        </div>
        <div class="content">
          <script>
          </script>
        </div>
        </div>

        <!--
      <div class="sidebar"></div>
      <div class="content"></div>
      <div class="footer"></div>
    -->
    </body>
  </html>
