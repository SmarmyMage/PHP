<?php

$pageTitle = "Invoice";

$albums = array("Erykah Badu" => "Mama's Gun", "UMI" => "Introspection", "Cibo Matto" => "Stereotype A", "Tomosuke" => "Marble", "Utada" => "This is the One", 
"The 1999" => "Journey in the Rain", "UMI" => "Love Language", "UMI" = > "talking to the wind", "Pasteboard" => "Glitter", "Josh Cooper" => "Fluroescence",
"The Beatles" => "The White Album");

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title><?php echo $pageTitle; ?></title>
    </head>

    <body class="pl-2">

        <div class="container">

            <header>
                <h1>Form Processing</h1>
            </header>

            <nav>
                <a href="index.php">Home</a> | <a href="form.php">Order Form</a>
            </nav>

            <section>
                <h2>Practice Form</h2>
                    <p>Please make your selections from the form below.</p>
                    <fieldset class="pl-2">
                        <legend> Sample Form </legend>
                        <form method="post" action="handle_invoice.php">
                            <p>
                                <label for="userName">Name</label><br>
                                <input type="text" name="userName" id="userName" value="" class="form-control-static">
                            </p>
                            <p><label for="album">Choose a Album</label><br>
                                <select name="album" id="album">
                                <option value="">-----------------</option>
                                    <?php
                                    foreach($albums as $key => $value):
                                    echo '<option value="'.$key.'">'.$key.' - '.$value.'</option>';
                                    endforeach;
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="quantity">Quantity</label><br>
                                <input type="text" name="quantity" id="quantity" value="">
                            </p>
                            <p>
                                <label>Media</label><br>
                                <input type="radio" name="media" id="cd" value="cd">
                                <label for="cd">CD</label>&emsp;
                                <input type="radio" name="media" id="dl" value="download">
                                <label for="dl">Download</label>
                            </p>
                            <p>
                                <input type="submit" name="submit" value="Submit">
                            </p>
                        </form>
                    </fieldset>
            </section>
        </div>
    </body>    

</html>