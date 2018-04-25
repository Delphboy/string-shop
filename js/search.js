let ajax = new AJAXConnection();

/**
 * Live search bar
 * run 'onkeyup' event for search bar input
 * If the search bar isn't empty, create a new AJAX request and display the returned data
 *
 * @param str
 */
function liveSearchBar(str)
{
    ajax.process('GET', 'Models/livesearch.php?q=' + str, handleResponse);
}

/**
 *
 */
function handleResponse()
{
    if(ajax.xmlHTTP.readyState === 4 && ajax.xmlHTTP.status === 200)
    {
        let uic = document.getElementById("hintList");
        let JSONData = JSON.parse(ajax.xmlHTTP.responseText);
        let hintDisplay = "";
        if(ajax.xmlHTTP.responseText.length > 2)
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
        else
        {
            hintDisplay = "<li style='position:relative; z-index: 10' class='col-md-12 list-group-item container'>No suggestions</li>"
        }
        uic.innerHTML = hintDisplay;

        setTimeout(ajax.process(), 1000);
    }
    else
    {
        console.log("An error occurred");
        console.log(ajax.xmlHTTP.readyState);
        console.log(ajax.xmlHTTP.status);
    }

}