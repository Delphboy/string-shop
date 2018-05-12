let ajaxConn = new AJAXConnection();
let searchQuery = "";

let searchString = "";
let searchCategory = "";
let searchOrder = "";
let searchHasCase = "";
let searchHasBow = "";
let page = 0;
let isMoreResults = true;

/**
 * EVENT HANDLER: Run when the user types in the previousSearchQuery bar.
 * Create AJAX request and update query string
 * @param queryString
 */
function loadMore(queryString)
{
    ajaxConn.process("GET", "Models/loadmore.php?" + queryString, displayMoreAds);
    searchQuery = queryString;
}

/**
 * Use the returned value from the AJAX request to append extra results to the bottom of the page
 * If there are no more results, display the "No More Results" message
 * Whilst waiting on the AJAX request, display a "Loading..." message
 */
function displayMoreAds()
{
    let output = "";
    let outputLocation = document.getElementById("searchResultDisplay");
    if(ajaxConn.xmlHTTP.readyState === 4 && ajaxConn.xmlHTTP.status === 200)
    {
        if(ajaxConn.xmlHTTP.responseText !== "")
        {
            output = ajaxConn.xmlHTTP.responseText;
            console.log("found one");
        }
        else
        {
            document.getElementById("message").innerHTML = "<h4>No More Adverts</h4>";
            isMoreResults = false;
            console.log("No more adverts");
        }
    }
    else
    {
        //Still more adverts to come, but they're not here yet - loading
        if(isMoreResults)
        {
            document.getElementById("message").innerHTML = "<h4>Loading...</h4>";
            console.log("Loading");
        }
    }

    if(outputLocation.innerHTML.length === 0)
    {
        outputLocation.innerHTML = output;
    }
    else
    {
        outputLocation.innerHTML += output;
    }
}

/**
 * EVENT HANDLER: Handles the previousSearchQuery form being updated
 */
function handleSearch()
{
    isMoreResults = true;
    document.getElementById("searchResultDisplay").innerHTML = "";
    page = 0;
    let str = createSearchString();
    loadMore(str);
}

/**
 * User the previousSearchQuery bar elements to build a query string for the AJAX request
 * @returns {string}
 */
function createSearchString()
{
    searchString = document.getElementById("searchBar").value;
    searchCategory = document.getElementById("searchCategory").value;
    searchOrder = document.getElementById("searchOrder").value;
    searchHasCase = document.getElementById("searchHasCase");
    searchHasBow = document.getElementById("searchHasBow");

    //Convert JS bools to PHP bools
    if(searchHasCase.checked)
        searchHasCase = 1;
    else
        searchHasCase = 0;

    if(searchHasBow.checked)
        searchHasBow = 1;
    else
        searchHasBow = 0;

    let str = "cat=" + searchCategory
        + "&previousSearchQuery=" + searchString
        + "&order=" + searchOrder
        + "&bow=" + searchHasBow
        + "&case=" + searchHasCase
        + "&page=" + page;

    console.log("Search String: " + str);

    return str;
}

/**
 * EVENT HANDLER: Run this code when the user reaches the bottom of the page
 */
function bottomOfPage()
{
    page += 1;
    searchQuery = createSearchString();
    loadMore(searchQuery);
}

