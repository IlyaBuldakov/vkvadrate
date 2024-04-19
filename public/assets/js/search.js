var searchInput = document.querySelector('#search__input');

let params = new URL(document.location.toString()).searchParams;
let query = params.get("query");

searchInput.value = query;
