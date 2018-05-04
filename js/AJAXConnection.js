class AJAXConnection
{
    constructor()
    {
        this.xmlHTTP = new XMLHttpRequest();
    }

    process(method, url, stateChangeMethod)
    {
        if(this.xmlHTTP.readyState === 0 || this.xmlHTTP.readyState === 4)
        {
            this.xmlHTTP.open(method, url, true);
            this.xmlHTTP.onreadystatechange = stateChangeMethod;
            this.xmlHTTP.send(null);
        }
    }
}