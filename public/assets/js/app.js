// ------ Preloader ------
function preLoader() {
    document.body.classList.add('loaded_hiding');
    window.setTimeout(function () {
        document.body.classList.add('loaded');
        document.body.classList.remove('loaded_hiding');
    }, 500);
}

if (document.readyState !== "complete") {
    preLoader();
}
// ------ Preloader ------

var marketplaceButtonsBox = document.querySelector('.marketplace__button_box');

window.onload = function() {
    document.querySelectorAll('.marketplace__button').forEach(
        function (button) {
            if (!(params.get('filters') === 'all')) {
                var filters = params.get('filters');
                if (!filters.split(',').includes(button.innerHTML)) {
                    toggleFilterButton(button);
                }
            }
        }
    );
}

function marketplaceFilterButtonAction(element) {
    toggleFilterButton(element);

    if (document.getElementsByClassName('filter_submit__button').length < 1) {
        marketplaceButtonsBox.innerHTML +=
            "<button class=\"btn marketplace__button filter_submit__button\" onclick=\"searchWithFilters()\" type=\"submit\"><i class=\"fa fa-check\"></i></button>";
    }
}

function searchWithFilters() {
    var queryString = "?filters=";
    var resultArray = [];
    var marketplaceFilterButtons = document.getElementsByClassName('marketplace__button');

    Array.from(
        marketplaceFilterButtons,
        function (button) {
            if (button.hasAttribute('enabled')) {
                resultArray.push(button.innerHTML);
            }
        }
    );

    queryString += resultArray;

    if (params.has('query')) {
        queryString += '&query=' + params.get('query');
    }
    params.set('filters', '');
    window.location.replace('/search' + queryString);
}

function toggleFilterButton(button) {
    button.toggleAttribute('enabled');

    if (button.hasAttribute('enabled')) {
        button.style="background-color: #f9900e; color: white";
    } else {
        button.style="background-color: white; color: black";
    }
}
