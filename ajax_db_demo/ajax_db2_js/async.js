document.getElementById('city').onchange=function(){
    process(this.value);
};

// holds an instance of XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();

// creates an XMLHttpRequest instance
function createXmlHttpRequestObject() {
    var xmlHttp;
    // this should work for all browsers except IE6 and older
    try {
        xmlHttp = new XMLHttpRequest();
    }
    catch(e) {
        var XmlHttpVersions = new Array(
            "MSXML2.XMLHTTP.6.0",
            "MSXML2.XMLHTTP.5.0",
            "MSXML2.XMLHTTP.4.0",
            "MSXML2.XMLHTTP.3.0",
            "MSXML2.XMLHTTP",
            "Microsoft.XMLHTTP");
        for(i=0; i<XmlHttpVersions.length && !xmlHttp; i++) {
            try { 
                xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
            } 
            catch (e) {}
        }
    }

    // return the created object or display an error message
    if (!xmlHttp)
        alert("Error creating the XMLHttpRequest object.");
    else 
        return xmlHttp;
}


// called to read a file from the server
function process(code) {
    prog = "list_and_ajax.php?code=" + code;
    document.getElementById('area_display').innerHTML = '';
    
    if (xmlHttp) {
        try {
            xmlHttp.open("GET", prog, true);
            xmlHttp.onreadystatechange = handleRequestPart1;
            xmlHttp.send(null);
        }
        catch (e) {
            alert("Can't connect to server:\n" + e.toString());
        }
    }
}


// function that handles the HTTP response
function handleRequestPart1() {
    myDiv = document.getElementById('area_list');

    // display the status of the request 
    if (xmlHttp.readyState==1) {
        // myDiv.innerHTML += "Request status: 1 (loading) <br/>";
    }
    else if (xmlHttp.readyState==2) {
        // myDiv.innerHTML += "Request status: 2 (loaded) <br/>";
    }
    else if (xmlHttp.readyState==3) {
        // myDiv.innerHTML += "Request status: 3 (interactive) <br/>";
    }
    else if (xmlHttp.readyState == 4) {
        // continue only if HTTP status is "OK"
        if(xmlHttp.status==200) {
            try {
                // read the message from the server
                response = xmlHttp.responseText;
                // display the message 
                // myDiv.innerHTML += "Request status: 4 (complete). Server said: <br/>";
                myDiv.innerHTML = response;
            }
            catch(e) {
                alert("Error reading the response: " + e.toString());
            }
        } 
        else {
            alert("There was a problem retrieving the data:\n" + xmlHttp.statusText);
        }
    }
}


///////////////////////////////////////////////////////////////////////

function show_detail(uid) {
    prog = "display.php?uid=" + uid;
    console.log('run...'+prog);

    if (xmlHttp) {
        try {
            xmlHttp.open("GET", prog, true);
            xmlHttp.onreadystatechange = handleRequestPart2;
            xmlHttp.send(null);
        }
        catch (e) {
            alert("Can't connect to server:\n" + e.toString());
        }
    }
}


function handleRequestPart2() {
    myDiv = document.getElementById('area_display');

    if(xmlHttp.readyState==1) {
        // myDiv.innerHTML += "Request status: 1 (loading) <br/>";
    }
    else if(xmlHttp.readyState==2) {
        // myDiv.innerHTML += "Request status: 2 (loaded) <br/>";
    }
    else if(xmlHttp.readyState==3) {
        // myDiv.innerHTML += "Request status: 3 (interactive) <br/>";
    }
    else if(xmlHttp.readyState==4) {
        if(xmlHttp.status==200) {
            try {
                response = xmlHttp.responseText;
                myDiv.innerHTML = response;
            }
            catch(e) {
                // display error message
                alert("Error reading the response: " + e.toString());
            }
        } 
        else {
            // display status message
            alert("There was a problem retrieving the data:\n" + xmlHttp.statusText);
        }
    }
}
