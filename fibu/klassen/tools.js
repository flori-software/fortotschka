// Version 2019-06-14   VF


// *****************************************************************************************************
// AJAX - FUNKTIONEN

// Standardmethode zum Erzeugen eins XML-Http-Requests:
function erzXHRObjekt() {
	resObjekt=null;
	try {
		resObjekt=new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(Error) {
		try {
			resObjekt=new ActiveXObject("MSXML2.XMLHTTP");
		}
		catch(Error) {
			try {
				resObjekt=new XMLHttpRequest();
			}
			catch(Error) {
				alert("Es konnte kein XMLHttpRequest-Objekt erzeugt werden. Das Abrechnungsmodul wird nicht fehlerfrei funktionieren. Bitte benachrichtigen Sie den Hersteller.");
			}	
		}
	}
	return resObjekt;
}

function f_change_pic(id,new_url) {
	document.images[id].src=new_url;
}

function f_person_not_double_AJAX() {
	if (resOb.readyState == 4) {
		myText = resOb.responseText;
		if (myText == "DOPPELT") {
			alert("Diesen Namen gibt es bereits! Vielleicht benutzen Sie den zweiten Vornamen oder den Wohnort im Personencode um diese Person von jemand anderem mit dem gleichen Namen zu unterscheiden.");
			document.getElementById("personencode").style.backgroundColor = "tomato";
			myText = document.getElementById("personencode").value;
			myText = myText + " 2";
			document.getElementById("personencode").value = myText;
		}
		else {
			document.getElementById("personencode").style.backgroundColor = "honeydew";
		}
	}
}
