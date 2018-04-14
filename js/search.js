function searchBtnClick(str)
{
    // Don't display hints if nothing in the search bar
    if(str.length === 0)
    {
        document.getElementById('hintList').innerHTML = "";
        return;
    }
    /**
     * Create a new AJAX object
     * Create an inline function for the object to
     */
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