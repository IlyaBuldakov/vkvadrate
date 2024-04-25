window.onload = function() {
    var searchInput = document.querySelector('#search__input');

    let params = new URL(document.location.toString()).searchParams;
    let query = params.get("query");

    if (query !== null) {
        searchInput.value = query;
        // TODO: WebSocket
    }
}
