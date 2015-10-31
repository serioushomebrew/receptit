$(function() {

    var App = {
        init : function() {
            var self = this;

            Quagga.init(this.state, function(err) {
                if (err) {
                    return self.handleError(err);
                }
                Quagga.start();
            });
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
                    width: 640,
                    height: 480,
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

    App.init();

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
            console.clear();

            console.log('bonus card found, gettings client list.');

            var added = [];
            var title = document.querySelector('#title');
            Client.getShoppingList(13555,function(data){


                if(typeof data[0] == 'undefined') {
                    title.innerHTML = 'Er zijn geen aankoppen gekoppeld aan uw Bonus kaart.';
                } else {
                    title.innerHTML = 'Uw aankopen';

                    for(var i =0; i < data.length; i++){
                        var productId = data[i].nasanr;

                        if(added.indexOf(productId) != -1)
                            continue;

                        added.push(productId);
                        Product.getByNasaNr(productId, function(data){
                            var brand = data[0].merknaam;
                            var div = document.createElement('div');
                            if(brand == 'AH')
                                div.innerHTML = data[0].productomschrijving;
                            else
                                div.innerHTML = brand;
                            var container = document.querySelector('#shoppingList');
                            container.appendChild(div);
                        });



                    }

                    console.log(added);

                }

            });

        }
    });

});