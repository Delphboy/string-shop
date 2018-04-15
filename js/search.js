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
    if(str.length === 0)
    {
        document.getElementById('hintList').innerHTML = "";
        return;
    }
    else
    {
        var xmlHTTP = new XMLHttpRequest();
        xmlHTTP.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                var uic = document.getElementById("hintList")
                uic.innerHTML = this.responseText;
            }
        };
        xmlHTTP.open('GET', 'livesearch.php?q=' + str, true);
        xmlHTTP.send();
    }
}