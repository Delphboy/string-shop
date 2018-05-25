let ajaxLoad = new AJAXConnection();
let ajaxCount = new AJAXConnection();
let searchQuery = "";

let searchString = "";
let searchCategory = "";
let searchOrder = "";
let searchHasCase = "";
let searchHasBow = "";
let page = 0;
let isMoreResults = true;

let advertCount = 0;
let totalAdverts = 1;

/**
 * EVENT HANDLER: Run when the user types in the previousSearchQuery bar.
 * Create AJAX request and update query string
 * @param queryString
 */
function loadMore(queryString)
{
    ajaxLoad.process("GET", "Models/loadmore.php?" + queryString, displayMoreAds);
    // searchQuery = queryString;
}

/**
 * Use the returned value from the AJAX request to append extra results to the bottom of the page
 * If there are no more results, display the "No More Results" message
 * Whilst waiting on the AJAX request, display a "Loading..." message
 */
function displayMoreAds()
{
    let JSONResult = null;
    let output = "";
    let outputLocation = document.getElementById("searchResultDisplay");
    if(ajaxLoad.xmlHTTP.readyState === 4 && ajaxLoad.xmlHTTP.status === 200)
    {
        if(ajaxLoad.xmlHTTP.responseText !== "")
        {
            JSONResult = JSON.parse(ajaxLoad.xmlHTTP.responseText);
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
            if(advertCount < totalAdverts)
                document.getElementById("message").innerHTML = "<h4>Loading... (Loaded " + advertCount + " of " + totalAdverts + ")</h4>";
            else
            {
                document.getElementById("message").innerHTML = "<h4>No More Adverts</h4><br/><p><a href=''>Top of page</a></p>";
                isMoreResults = false;
                console.log("No more adverts");
            }
        }
    }

    if(JSONResult !== null && isMoreResults)
    {
        JSONResult.forEach(function (obj)
        {
            var advertID = (obj.id * 7).toString(16);
            output += "<div class='col-md-6'>" +
                "<div class='col-md-6'>" +
                "<img src='/images/uploads/" + obj.picture + "' class='previewImage'>" +
                "</div>" +
                "<div class='col-md-6'>" +
                "<h2><a href='/advert.php?advert=" + advertID + "'>" + obj.title + "</a></h2>" +
                "<p>" + obj.description + "</p>" +
                "</div>" +
                "<div class='col-xs-12' style='height: 50px'></div> " +
                "</div>";
            advertCount++;
        });
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
    advertCount = 0;
    ajaxCount.process("GET", "Models/queryCount.php?" + createSearchString(), setTotalAdCount);
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
    if(isMoreResults && (ajaxLoad.xmlHTTP.readyState === 0 || ajaxLoad.xmlHTTP.readyState === 4))
    {
        page += 1;
        loadMore(createSearchString());
    }
}

function setTotalAdCount()
{
    if(ajaxCount.xmlHTTP.readyState === 4 && ajaxCount.xmlHTTP.status === 200)
    {
        totalAdverts = parseInt(ajaxCount.xmlHTTP.responseText);
    }
}

