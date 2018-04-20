function searchFormUpdated()
{
    var searchCategory = document.getElementById('searchCategory').value;
    var searchOrder = document.getElementById('searchOrder').value;
    var searchHasCase = document.getElementById('searchHasCase').checked;
    var searchHasBow = document.getElementById('searchHasBow').checked;

    //Debug information
    console.log(searchCategory
        + "\n" + searchHasCase
        + "\n" + searchHasBow
        + "\n" + searchOrder);

    // //AJAX method to call Search Model
    // var xmlHTTP = new XMLHttpRequest();
    // xmlHTTP.onreadystatechange = function ()
    // {
    //     if (this.readyState === 4 && this.status === 200)
    //     {
    //         var uic = document.getElementById("searchResultDisplay");
    //         uic.innerHTML = this.responseText;
    //     }
    // };
    // xmlHTTP.open('GET',
    //     'search.php?category=' + searchCategory
    //      + '&seach=' + ""
    //      + '&order=' + searchOrder
    //      + '&hasCase=' + searchHasCase
    //      + '&hasBow=' + searchHasBow
    //      + '&page=0',
    //     true);
    // xmlHTTP.send();
}

/**
 * Live search bar
 * run 'onkeyup' event for search bar input
 * If the search bar isn't empty, create a new AJAX request and display the returned data
 *
 * @param str
 */
function liveSearchBar(str)
{
    // console.log("search query: " + str);
    if(str.length === 0)
    {
        document.getElementById('hintList').innerHTML = "";
        return;
    }
    else
    {
        var xmlHTTP = new XMLHttpRequest();
        xmlHTTP.open('GET', 'Models/livesearch.php?q=' + str, true);
        xmlHTTP.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                var uic = document.getElementById("hintList");
                var JSONData = JSON.parse(this.responseText);
                var hintDisplay = "";
                // uic.innerHTML = "<li>" + str + "</li>";
                if(this.responseText.length > 2)
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
            }
        };
        xmlHTTP.send();
    }
}