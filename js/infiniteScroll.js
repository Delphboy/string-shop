var ajax = new AJAXConnection();
let display = "";

window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        alert("Hello there");
    }
};

function loadMore(getString)
{
    ajax.process('GET', '/Models/loadmore.php?' + getString, displayMoreAds);
}

function displayMoreAds()
{
    let previews = document.getElementByID("searchResultDisplay");

    if(ajax.xmlHTTP.readyState === 4 && ajax.xmlHTTP.status === 200)
    {
        display = ajax.xmlHTTP.responseText;
    }
    else
    {
        display = "Loading";
    }

    //Update display
    if(search.length > 0)
        previews.innerHTML = display;
    else
        previews.innerHTML = "";
}