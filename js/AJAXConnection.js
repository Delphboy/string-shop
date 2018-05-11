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

// function AJAXConnection(method, url, operation)
// {
//     let obj = new XMLHttpRequest();
//     if(obj.readyState === 0 || obj.readyState === 4)
//     {
//         obj.open(method, url, true);
//         obj.onreadystatechange = operation;
//         obj.send(null);
//     }
// }

function makeNewAJAX()
{
    return new XMLHttpRequest();
}