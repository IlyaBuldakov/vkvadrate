var searchInput = document.querySelector('#search__input');

let params = new URL(document.location.toString()).searchParams;

sendWsMessageAndDrawHtml();

function sendWsMessageAndDrawHtml() {
    let query = params.get("query");

    if (query !== null) {
        searchInput.value = query;
        var ws = new WebSocket('ws://127.0.0.1:2345');

        ws.onmessage = function (evt) {
            var basket = document.querySelector('#basket');

            var marketplaceDto = JSON.parse(evt.data);

            var marketplaceNameBox = document.querySelector('#marketplace_name');
            marketplaceNameBox.innerHTML = marketplaceDto.sign;

            var marketplaceItems = marketplaceDto.items;

            marketplaceItems.forEach(function (item) {
                basket.innerHTML
                    += " <div class=\"col-lg-4 col-md-6\" style=\"margin-bottom: 20px\">\n" +
                    "                            <div class=\"card rounded shadow-sm border-0 mb-5 h-100\">\n" +
                    "                                <div class=\"card-body p-4\"><img\n" +
                    "                                        src=\"" + item.photoUrl + "\" alt=\"\"\n" +
                    "                                        class=\"img-fluid d-block mx-auto mb-3\">\n" +
                    "                                    <h5><a href=\"" + item.itemUrl + "\"\n" +
                    "                                           class=\"text-dark\">" + item.name + "</a></h5>\n" +
                    "                                    <p class=\"small text-muted font-italic\">\n" +
                    "                                        Текст для описания товара\n" +
                    "                                    </p>\n" +
                    "                                    <div class=\"market__box float-start\">\n" +
                    "                                        <div class=\"row\">\n" +
                    "                                            <img src=\"" + marketplaceDto.logoPath + "\"\n" +
                    "                                                 style=\"width: 75px !important; height: 45px !important;\" alt=\"\">\n" +
                    "                                            <div class=\"col\">\n" +
                    "                                                <p class=\"small text-muted font-italic\"\n" +
                    "                                                   style=\"margin-top: 0.65rem !important\">\n" +
                    "                                                    " + marketplaceDto.sign + "\n" +
                    "                                                </p>\n" +
                    "                                            </div>\n" +
                    "                                        </div>\n" +
                    "                                    </div>\n" +
                    "                                    <div class=\"price__box float-end\">\n" +
                    "                                        <h4>" + item.price + " ₽</h4>\n" +
                    "                                    </div>\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>";
            });
        };

        waitForSocketConnection(ws, function () {
            ws.send([params.get('filters'), query])
        });
    }

    function waitForSocketConnection(socket, callback) {
        setTimeout(
            function () {
                if (socket.readyState === 1) {
                    if (callback != null) {
                        callback();
                    }
                } else {
                    waitForSocketConnection(socket, callback);
                }

            }, 5);
    }
}
