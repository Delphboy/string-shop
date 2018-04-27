var ajax = new AJAXConnection();
var search = "";
var resultsDisplay = "";

/**
 * Live createSearchString bar
 * run 'onkeyup' event for createSearchString bar input
 * Create a new AJAX object to process the createSearchString input
 *
 * @param str
 */
function liveSearchBar(str)
{
    ajax.process('GET', 'Models/livesearch.php?q=' + str, handleResponse);
    console.log(ajax);
    search = str;
}

/**
 * EVENT HANDLER: Clear the live search when the text box has lost focus
 */
function clearSearch()
{
    // alert("Hello ladies");
    let uic = document.getElementById("hintList");
    uic.innerHTML = "";
}

/**
 * Process the the AJAX call to the server
 * Display the live createSearchString bar results
 */
function handleResponse()
{
    let uic = document.getElementById("hintList");

    if(ajax.xmlHTTP.readyState === 4 && ajax.xmlHTTP.status === 200)
    {
        resultsDisplay = "";
        let JSONData = JSON.parse(ajax.xmlHTTP.responseText);

        if (ajax.xmlHTTP.responseText.length > 2)
        {
            processJSON(JSONData);
        }
        else
        {
            resultsDisplay = "<li style='position:relative; z-index: 10' class='col-md-12 list-group-item container'>No suggestions</li>"
        }
    }
    else
    {
        resultsDisplay = "<li style='position:relative; z-index: 10' class='col-md-12 list-group-item container'>Loading...</li>"
    }

    //Update display
    if(search.length > 0)
        uic.innerHTML = resultsDisplay;
    else
        uic.innerHTML = "";
}

/**
 * Process the JSON data returned from the AJAX call
 * @param JSONData
 */
function processJSON(JSONData)
{
    JSONData.forEach(function (obj)
    {
        var advertID = (obj.id * 7).toString(16);
        if(resultsDisplay === "")
        {
            resultsDisplay =
                "<li style='position: relative; z-index: 10' class='list-group-item container col-md-12 col-sm-12'>" +
                "<div class='col-md-2'>" +
                "<img width='50px' height='auto' src='/images/uploads/" + obj.pictures + "'  />" +
                "</div>" +
                "<div class='col-md-9 list-group-item-text'><h4><a href='/advert.php?advert=" + advertID + "'>" + obj.title + "</a></h4></div>" +
                "<div class='col-md-9'>" + obj.description + "</div>" +
                "</li>";
        }
        else
        {
            resultsDisplay +=
                "<li style='position: relative; z-index: 10' class='list-group-item container col-md-12 col-sm-12'>" +
                "<div class='col-md-2'>" +
                "<img width='50px' height='auto' src='/images/uploads/" + obj.pictures + "'  />" +
                "</div>" +
                "<div class='col-md-9 list-group-item-text'><h4><a href='/advert.php?advert=" + advertID + "'>" + obj.title + "</a></h4></div>" +
                "<div class='col-md-9'>" + obj.description + "</div>" +
                "</li>";
        }
    });
}