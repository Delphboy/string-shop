let ajaxConn = new AJAXConnection();
let searchQuery = "";
let searchCategory = "";
let searchOrder = "";
let searchHasCase = "";
let searchHasBow = "";
let page = 0;
let isMoreResults = true;

function loadMore(queryString)
{
    ajaxConn.process("GET", "Models/loadmore.php?" + queryString, displayMoreAds);
    searchQuery = queryString;
}


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

    if(outputLocation.innerHTML.length = 0)
    {
        outputLocation.innerHTML = output;
        // document.getElementById("message").innerHTML = "";
    }
    else
    {
        outputLocation.innerHTML += output;
        // document.getElementById("message").innerHTML = "";
    }
}

/**
 * EVENT HANDLER: Handles the search form being updated
 */
function handleSearch()
{
    isMoreResults = true;
    document.getElementById("searchResultDisplay").innerHTML = "";
    let str = createSearchString();
    page = 0;
    // console.log(
    //     "Search Params\n" +
    //     searchCategory + "\n" +
    //     searchOrder + "\n" +
    //     searchHasCase + "\n" +
    //     searchHasBow + "\n" +
    //     page
    // );
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

    // console.log("Search String: " + str);

    return str;
}

function bottomOfPage()
{
    page += 1;
    searchQuery = createSearchString();
    loadMore(searchQuery);
}

