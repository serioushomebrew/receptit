<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recept.it</title>
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css' async>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" async>
        <link rel="stylesheet" type="text/css" href="css/scan.css" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    </head>
    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <img src="images/logo-ah.svg" class="logo" />
            <h2><i class="fa fa-filter"></i> Filters</h2>

            <section>
                <h3>Dieet optie</h3>
                <label><input type="checkbox" name="receptvleesvisofvega" value="vegetarisch" class="filter" /> Vegetarisch</label><br />
                <label><input type="checkbox" name="receptvleesvisofvega" value="vlees" class="filter" /> Vlees</label><br />
                <label><input type="checkbox" name="receptvleesvisofvega" value="vis" class="filter" /> Vis</label><br />
                <label><input type="checkbox" name="receptvleesvisofvega" value="gevogelte" class="filter" /> Gevogelte</label>
            </section>

            <section>
                <h3>Allergie</h3>
                <label><input type="checkbox" name="receptallergeneninfo" value="lactosevrij" class="filter" /> Lactosevrij</label><br />
                <label><input type="checkbox" name="receptallergeneninfo" value="glutenvrij" class="filter" /> Glutenvrij</label>
            </section>

            <section>
                <h3>Prijzen</h3>
                <label><input type="radio" name="" value="" class="filter" /> Bonus</label><br />
                <label><input type="radio" name="" value="" class="filter" /> Laag naar hoog</label><br />
                <label><input type="radio" name="" value="" class="filter" /> Hoog naar laag</label>
            </section>
        </div>
        <div class="sidebar-toggle">
            <i class="fa fa-angle-right"></i>
        </div>

    <video class="background-video" autoplay poster="background.png" src="background.mp4"></video>
    <script>
        document.querySelector('.background-video').playbackRate = 0.8;
    </script>
        <div class="container">
            <div class="row">
                <div class="col-xs-9 col-xs-offset-1">
                    <img src="images/logo.png" class="img-responsive branding-logo">
                </div>
            </div>

            <div class="search__wrapper">
                <section class="search" role="search">
                    <ol class="search__tags"></ol>
                    <input type="search" class="search__field" autofocus autosave autocomplete="no" placeholder="Wat heb ik in huis?" />
                    <button class="search__submit">
                        <i class="fa fa-search"></i>
                    </button>
                    <button class="btn btn-default btn-small" data-toggle="modal" data-target="#scanModal">
                        <i class="fa fa-barcode"></i>
                    </button>
                    <div class="barcode-pointer">
                        scan je bonus kaart
                    </div>
                </section>
              <ul class="search__autocomplete">

              </ul>
            </div>


            <div id="shoppingList" class="suggestions">
            </div>

            <div class="results">

            </div>
        </div>



        <!-- Camera Modal -->
        <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="scanModalLabel">Scan uw bonus kaart</h4>
                    </div>
                    <div class="modal-body">
                        <div id="container">
                            <div id="interactive" class="viewport"></div>

                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe Modal -->
        <div class="modal fade" id="recipeModal" tabindex="-1" role="dialog" aria-labelledby="recipeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="recipeModalLabel">Recept</h4>
                    </div>
                    <div class="modal-body" id="recipeModalBody">

                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <div class="loaderdisplay">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>

        <script src="js/jquery/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="js/index.js"></script>
        <script src="js/bootstrap/bootstrap.js" type="text/javascript"></script>
        <script src="js/quagga/quagga.js" type="text/javascript"></script>
        <script src="js/scan.js" type="text/javascript"></script>
        <script src="js/receptit/client.js" type="text/javascript"></script>
        <script src="js/receptit/product.js" type="text/javascript"></script>
    </body>
</html>
