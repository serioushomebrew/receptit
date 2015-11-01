var App;
$(function() {

    App = {
        running : false,
        init : function() {
            var self = this;

            Quagga.init(this.state, function(err) {
                if (err) {
                    return self.handleError(err);
                }
                Quagga.start();
                App.running = true;
            });
        },

        shopAdd : function(e){
            var name = e.currentTarget.innerHTML;
            addTag(name);
            e.currentTarget.remove();
        },

        inputMapper: {
            inputStream: {
                constraints: function(value){
                    var values = value.split('x');
                    return {
                        width: parseInt(values[0]),
                        height: parseInt(values[1]),
                        facing: "environment"
                    }
                }
            },
            numOfWorkers: function(value) {
                return parseInt(value);
            },
            decoder: {
                readers: function(value) {
                    return [value + "_reader"];
                }
            }
        },
        state: {
            inputStream: {
                type : "LiveStream",
                constraints: {
                    width: 160,
                    height: 127,
                    facing: "environment" // or user
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: 4,
            decoder: {
                readers : [ "ean_reader"]
            },
            locate: true
        },
        lastResult : null
    };

    $('.barcode-pointer').click(function(){
        $('#scanModal').modal('show')
    });

    $('#scanModal').on('shown.bs.modal', function () {
        App.init();
    });

    $('#scanModal').on('hide.bs.modal', function() {
        if(App.running)
            Quagga.stop();
    });

    Quagga.onProcessed(function(result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
            }
        }
    });

    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;

        if(code.substr(0,1) == 2){
            Quagga.stop();
            App.running = false;
            console.clear();

            console.log('bonus card found, gettings client list.');

            var added = [];
            var title = document.querySelector('#title');
            Client.getShoppingList(17981,function(data){


                if(typeof data[0] == 'undefined') {
                    alert('Er zijn geen aankoppen gekoppeld aan uw Bonus kaart.');
                } else {

                    for(var i =0; i < data.length; i++){
                        var productId = data[i].nasanr;

                        if(added.indexOf(productId) != -1)
                            continue;

                        if(typeof data[i].joule == 'undefined' && data[i].schapstickeromschrijving != 'ah broccoli')
                            continue;

                        added.push(productId);
                        Product.getByNasaNr(productId, function(data) {

                            var div = document.createElement('div');
                            div.classList.add('shop-item');
                            div.classList.add('search__tag');

                            if(typeof data[0] != 'undefined'){

                                if(data[0].recepttrefwoord != "" && data[0].recepttrefwoord != 'xxx'){
                                    div.innerHTML = data[0].recepttrefwoord;
                                    var container = document.querySelector('#shoppingList');
                                    div.addEventListener('click', App.shopAdd,false);

                                    container.appendChild(div);
                                }
                            }
                        });
                    }

                    $('#scanModal').modal('hide');
                    $('.upcoming-alert').addClass('alert alert-success');
                }

            });

        }
    });

});

function showReceptModel(id) {
    document.body.classList.add('loading');
    $.post('/api/recipe', {
        id: id
    }, function(data) {
        document.body.classList.remove('loading');
        data = data[0];
        $('#recipeModalLabel').html(data.recepttitel);

        $('#recipeModalBody').html(
            '<strong>receptid:</strong> ' + data.receptid + '<br/>' +
            '<strong>recepttitel:</strong> ' + data.recepttitel + '<br/>' +
            '<strong>receptgang:</strong> ' + data.receptgang + '<br/>' +
            '<strong>receptmoment:</strong> ' + data.receptmoment + '<br/>' +
            '<strong>receptkooktechniek:</strong> ' + data.receptkooktechniek + '<br/>' +
            '<strong>receptseizoen:</strong> ' + data.receptseizoen + '<br/>' +
            '<strong>receptgelegenheid:</strong> ' + data.receptgelegenheid + '<br/>' +
            '<strong>receptsoort:</strong> ' + data.receptsoort + '<br/>' +
            '<strong>receptkindertags:</strong> ' + data.receptkindertags + '<br/>' +
            '<strong>receptvleesvisofvega:</strong> ' + data.receptvleesvisofvega + '<br/>' +
            '<strong>receptallergeneninfo:</strong> ' + data.receptallergeneninfo + '<br/>' +
            '<strong>receptkeuken:</strong> ' + data.receptkeuken + '<br/>' +
            '<strong>receptpersonen:</strong> ' + data.receptpersonen + '<br/>' +
            '<strong>receptserveertype:</strong> ' + data.receptserveertype + '<br/>' +
            '<strong>receptbereidingswijze:</strong> ' + data.receptbereidingswijze + '<br/>' +
            '<strong>receptbereidingstijd:</strong> ' + data.receptbereidingstijd + '<br/>' +
            '<strong>receptbereidingsduurtekst:</strong> ' + data.receptbereidingsduurtekst + '<br/>' +
            '<strong>receptingredienten:</strong> ' + data.receptingredienten + '<br/>' +
            '<strong>receptzoektermen:</strong> ' + data.receptzoektermen + '<br/>' +
            '<strong>receptkeukenspullen:</strong> ' + data.receptkeukenspullen + '<br/>' +
            '<strong>receptenergie:</strong> ' + data.receptenergie + '<br/>' +
            '<strong>receptkoolhydraten:</strong> ' + data.receptkoolhydraten + '<br/>' +
            '<strong>recepteiwitten:</strong> ' + data.recepteiwitten + '<br/>' +
            '<strong>receptvetten:</strong> ' + data.receptvetten + '<br/>' +
            '<strong>receptvetverzadigd:</strong> ' + data.receptvetverzadigd + '<br/>' +
            '<strong>receptnatrium:</strong> ' + data.receptnatrium + '<br/>' +
            '<strong>receptvezels:</strong> ' + data.receptvezels + '<br/>' +
            '<strong>receptbron:</strong> ' + data.receptbron + '<br/>' +
            '<strong>receptafbeelding:</strong> ' + data.receptafbeelding + '<br/>' +
            '<strong>recepturl:</strong> ' + data.recepturl + '<br/>' +
            '<strong>recepttags:</strong> ' + data.recepttags
        );

        $('#recipeModal').modal('show');
    });
}
