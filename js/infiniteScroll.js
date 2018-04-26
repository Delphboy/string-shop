let ajaxConn = new AJAXConnection();

let searchCategory = "";
let searchOrder = "";
let searchHasCase = "";
let searchHasBow = "";
let page = 0;


function loadMore(queryString)
{
    ajaxConn.process("GET", "Models/loadmore.php?" + queryString, displayMoreAds);
}


function displayMoreAds()
{
    let output = "";
    let outputLocation = document.getElementById("searchResultDisplay");
    if(ajaxConn.xmlHTTP.readyState === 4 && ajaxConn.xmlHTTP.status === 200)
    {
        output = ajaxConn.xmlHTTP.responseText;
    }
    else
    {
        output = "Loading...";
    }
    outputLocation.innerHTML = output;
}

/**
 * EVENT HANDLER: Handles the search form being updated
 */
function handleSearch()
{
    let str = createSearchString();
    console.log(
        "Search Params\n" +
        searchCategory + "\n" +
        searchOrder + "\n" +
        searchHasCase + "\n" +
        searchHasBow + "\n" +
        page
    );
    loadMore(str);
}

function createSearchString()
{
    searchCategory = document.getElementById("searchCategory").value;
    searchOrder = document.getElementById("searchOrder").value;
    searchHasCase = document.getElementById("searchHasCase").value;
    searchHasBow = document.getElementById("searchHasBow").value;

    //Convert JS bools to PHP bools
    if(searchHasCase === "on")
        searchHasCase = 1;
    else
        searchHasCase = 0;

    if(searchHasBow === "on")
        searchHasBow = 1;
    else
        searchHasBow = 0;

    let str = "cat=" + searchCategory
        + "&order=" + searchOrder
        + "&bow=" + searchHasBow
        + "&case=" + searchHasCase
        + "&page=" + page;
    console.log("Search String: " + str);

    return str;
}
function bottomOfPage()
{
    page++;
    createSearchString();
}

