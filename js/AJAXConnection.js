// var xmlHTTP = createXmlHTTPObject();
//
// function createXmlHTTPObject()
// {
//     var xmlHTTP;
//
//     try
//     {
//         xmlHTTP = new XMLHttpRequest();
//     }
//     catch (ex)
//     {
//         xmlHTTP = false;
//         console.log(ex);
//     }
//
//     if(!xmlHTTP)
//     {
//         alert('An error occurred creating the AJAX object');
//     }
//     else
//     {
//         return xmlHTTP;
//     }
// }
//
// function process()
// {
//     if(xmlHTTP.readyState === 4 && xmlHTTP.status === 200)
//     {
//
//     }
//     else
//     {
//         setTimeout(process(), 2000);
//     }
// }

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
        // else
        // {
        //     setTimeout(this.process(method, url, stateChangeMethod), 1000);
        // }
    }

}