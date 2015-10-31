var App;
$(function() {

    App = {
        init : function() {
            var self = this;

            Quagga.init(this.state, function(err) {
                if (err) {
                    return self.handleError(err);
                }
                Quagga.start();
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

    $('#scanModal').on('shown.bs.modal', function () {
        App.init();
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
            console.clear();

            console.log('bonus card found, gettings client list.');

            var added = [];
            var title = document.querySelector('#title');
            Client.getShoppingList(10265,function(data){


                if(typeof data[0] == 'undefined') {
                    alert('Er zijn geen aankoppen gekoppeld aan uw Bonus kaart.');
                } else {

                    for(var i =0; i < data.length; i++){
                        var productId = data[i].nasanr;

                        if(added.indexOf(productId) != -1)
                            continue;

                        if(typeof data[i].joule == 'undefined')
                            continue;

                        added.push(productId);
                        Product.getByNasaNr(productId, function(data) {
                            //console.log(data[0].nasanr, data[0]);
                            var brand = data[0].merknaam;
                            var div = document.createElement('div');
                            div.classList.add('shop-item');
                            div.classList.add('search__tag');

                            //div.innerHTML = data[0].nasanr;

                            if(data[0].recepttrefwoord != "" && data[0].recepttrefwoord != 'xxx'){
                                div.innerHTML = data[0].recepttrefwoord;
                                var container = document.querySelector('#shoppingList');
                                div.addEventListener('click', App.shopAdd,false);
                            }

                            container.appendChild(div);
                        });
                    }

                    $('#scanModal').modal('hide');
                    $('.upcoming-alert').addClass('alert alert-success');
                }

            });

        }
    });

});