function searchBtnClick(str)
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