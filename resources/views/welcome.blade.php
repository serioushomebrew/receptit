<!DOCTYPE html>
<html>
    <head>
        <title>Recept.it</title>
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css' async>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" async>
    </head>
    <body>
        <div class="search" role="search">
            <ol class="search__tags"></ol>
            <input type="search" class="search__field" autofocus autosave autocomplete="no" placeholder="Wat heb ik in huis?" />
            <button class="search__submit">
              <i class="fa fa-search"></i>
            </button>
        </div>
        <ul class="search__autocomplete">

        </ul>
        <script src="js/index.js"></script>
    </body>
</html>
