<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>Form Processing</title>
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
                        <form method="post" action="handle-form.php">
                            <p>
                                <label for="userName">Name</label><br>
                                <input type="text" name="userName" id="userName" value="" class="form-control-static">
                            </p>
                            <p>
                                <label for="quantity">Quantity</label><br>
                                <input type="text" name="quantity" id="quantity" value="">
                            </p>
                            <p><label for="album">Choose a Album</label><br>
                                <select name="album" id="album">
                                    <option value="Mama's Gun">Mama's Gun</option>
                                    <option value="Intropection">Introspection</option>
                                    <option value="Strerotype A">Stereotype A</option>
                                    <option value="Marble">Marble</option>
                                    <option value="This is the One">This is the One</option>
                                    <option value="Abbey Road">Abbey Road</option>
                                </select>
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