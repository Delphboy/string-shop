var ajax = new AJAXConnection();
var search = "";
var hintDisplay = "";

/**
 * Live search bar
 * run 'onkeyup' event for search bar input
 * Create a new AJAX object to process the search input
 *
 * @param str
 */
function liveSearchBar(str)
{
    ajax.process('GET', 'Models/livesearch.php?q=' + str, handleResponse);
    search = str;
}

/**
 * Process the the AJAX call to the server
 * Display the live search bar results
 */
function handleResponse()
{
    let uic = document.getElementById("hintList");

    if(ajax.xmlHTTP.readyState === 4 && ajax.xmlHTTP.status === 200)
    {
        hintDisplay = "";
        let JSONData = JSON.parse(ajax.xmlHTTP.responseText);

        if (ajax.xmlHTTP.responseText.length > 2)
        {
            processJSON(JSONData);
        }
        else
        {
            hintDisplay = "<li style='position:relative; z-index: 10' class='col-md-12 list-group-item container'>No suggestions</li>"
        }
    }
    else
    {
        hintDisplay = "var "
    }

    //Update display
    if(search.length > 0)
        uic.innerHTML = hintDisplay;
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
        if(hintDisplay === "")
        {
            hintDisplay =
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
            hintDisplay +=
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