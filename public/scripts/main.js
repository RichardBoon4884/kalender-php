window.onload = function(){
    listenEdit();
	window.setInterval(function () {
		document.getElementById('buttonAdd').onclick = function(){
			let body = document.getElementsByTagName('body')[0];
			var months = ["Onbekend","Januari","Februari","Maart","April","Mei","Juni","Juli","Augustus","September","Oktober","November","December"];
			var monthsHTML, daysHTML;
			for (i = 1; i < months.length; i++) {
				if (monthsHTML == undefined) {
					monthsHTML = "<option value=\"" + i + "\">" + months[i] + "</option>";
				} else if (monthsHTML != undefined) {
					monthsHTML += "<option value=\"" + i + "\">" + months[i] + "</option>";
				}
			}
			for (i = 1; i < 33; i++) {
				if (daysHTML == undefined) {
					daysHTML = "<option value=\"" + i + "\">" + i + "</option>";
				} else if (daysHTML != undefined) {
					daysHTML += "<option value=\"" + i + "\">" + i + "</option>";
				}
			}
			body.innerHTML += "<div id=\"background\" class=\"buttonCloseWindows\"></div><div id=\"window" + self.id + "\" class=\"window addWindow\"><h2>Verjaardag toevoegen</h2><input id=\"name\" name=\"name\" type=\"text\"><select id=\"day\" name=\"day\">" + daysHTML + "</select><select id=\"month\" name=\"month\">" + monthsHTML + "</select><input id=\"year\" name=\"year\" type=\"number\"><div><span id=\"buttonSubmit\" class=\"button\">Opslaan</span> <span id=\"buttonCancel\" class=\"buttonCloseWindows button\">Annuleer</span></div></div>";
            document.getElementById("buttonCancel").onclick = function () {
                document.getElementById('background').parentNode.removeChild(document.getElementById('background'));
    	        document.getElementById('window' + self.id).parentNode.removeChild(document.getElementById('window' + self.id));
            };
            document.getElementById("buttonSubmit").onclick = function () {
                var person = document.getElementsByName("name")[0].value;
                var day = Number(document.getElementsByName("day")[0].value);
                var month = Number(document.getElementsByName("month")[0].value);
                var year = Number(document.getElementsByName("year")[0].value);

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let id = this.responseText;
                        window['birthday' + id] = new Birthday(id, person, day, month, year);
                        window['birthday' + id].add();
                        listenEdit();
                    } else {
                        return false;
                    }
                };
                xmlhttp.open("GET", "/kalender-php/calendar/ajaxadd/" + person + "/" + day + "/" + month + "/" + year, true);
                xmlhttp.send();

                document.getElementById('background').parentNode.removeChild(document.getElementById('background'));
                document.getElementById('window' + self.id).parentNode.removeChild(document.getElementById('window' + self.id));
            };
		}
	}, 30);
};

function listenEdit() {
    var elements = document.getElementsByClassName('box');
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", function() {
            let id = this.id.split('-');
            id = id[1];
            window['birthday' + id].edit();
        });
    }
}