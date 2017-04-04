function getElementsByAttribute(attribute, context) {
    var nodeList = (context || document).getElementsByTagName('*');
    var nodeArray = [];
    var iterator = 0;
    var node = null;

    while (node = nodeList[iterator++]) {
        if (node.hasAttribute(attribute)) nodeArray.push(node);
    }

    return nodeArray;
}

function Birthday(id, person, day, month, year)
{
    this.id = id;
    this.person = person;
    this.day = day;
    this.month = month;
    this.year = year;

    const self = this;

    const months = ["Onbekend",
        "Januari",
        "Februari",
        "Maart",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Augustus",
        "September",
        "Oktober",
        "November",
        "December"];

    this.genWindow = function () {
        const body = document.getElementsByTagName('body')[0];
        let monthsHTML, daysHTML;
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
        body.innerHTML += "<div id=\"background\" class=\"buttonCloseWindows\"></div><div id=\"window" + self.id + "\" class=\"window addWindow\"><h2>Verjaardag bewerken</h2><input id=\"name\" name=\"name\" type=\"text\"><select id=\"day\" name=\"day\">" + daysHTML + "</select><select id=\"month\" name=\"month\">" + monthsHTML + "</select><input id=\"year\" name=\"year\" type=\"number\"><div><span id=\"buttonSubmit\" class=\"button\">Opslaan</span> <span id=\"buttonCancel\" class=\"button\">Annuleer</span> <span id=\"buttonDelete\" class=\"button\">Verwijder</span></div></div>";
    };
    this.removeWindow = function () {
        document.getElementById('background').parentNode.removeChild(document.getElementById('background'));
        document.getElementById('window' + self.id).parentNode.removeChild(document.getElementById('window' + self.id));
    };
    this.edit = function()
    {
        self.genWindow();

        document.getElementsByName("name")[0].setAttribute("value", this.person);
        getElementsByAttribute("value", document.getElementById('day'))[this.day].setAttribute("selected", "true");
        getElementsByAttribute("value", document.getElementById('month'))[this.month - 1].setAttribute("selected", "true");
        document.getElementsByName("year")[0].setAttribute("value", this.year);

        document.getElementById("buttonCancel").onclick = function () {
            self.removeWindow();
        };
        document.getElementById("buttonSubmit").onclick = function () {
            // TODO: Ajax request

            self.person = document.getElementsByName("name")[0].value;
            self.day = Number(document.getElementsByName("day")[0].value);
            self.month = Number(document.getElementsByName("month")[0].value);
            self.year = Number(document.getElementsByName("year")[0].value);

            self.removeWindow();
            self.delete();
            self.add();
        };
        document.getElementById("buttonDelete").onclick = function () {
            document.getElementById("buttonDelete").innerHTML = "Verwijderen: Zeker?";
            document.getElementById("buttonDelete").setAttribute("id", "buttonDeleteConfirm");
            document.getElementById("buttonDeleteConfirm").onclick = function () {
                //TODO: Ajax request

                self.delete();
                self.removeWindow();
            }
        }
    };
    this.delete = function ()
    {
        document.getElementById("birthday-" + this.id).remove();
    };
    this.add = function () {
        const parentMonth = document.getElementById("month-" + this.month).childNodes[1];

        if (parentMonth.childNodes.length == 0) {
            parentMonth.innerHTML =  "<li class=\"box\" id=\"birthday-" + this.id + "\"><h3>" + this.person + "</h3>" +
                "<a href=\"#\" onclick=\"birthday" + this.id + ".edit()\" >(edit)</a> " +
                "<span>" + this.day + " " + months[this.month] + " " + this.year +  "</span></li>";
        } else {
            console.log(parentMonth.childNodes);
            for (i = 0; i < parentMonth.childNodes.length; i++) {
                let id = parentMonth.childNodes[i].id.split('-');
                id = Number(id[1]);

                var day = (parentMonth.childNodes[i].childNodes[3].data.split(" "));
                var year = day[3];
                var day = day[1];

                var newItem = document.createElement("li");
                var textnode = document.createTextNode("<h3>" + this.person + "</h3>" +
                    "<a href=\"#\" onclick=\"birthday" + this.id + ".edit()\" >(edit)</a> " +
                    "<span>" + this.day + " " + months[this.month] + " " + this.year +  "</span>");
                newItem.appendChild(textnode)

                if (this.day < day) {
                    parentMonth.childNodes[i].childNodes[3].insertBefore();
                } else if (this.day == day && this.year < year) {
                    console.log(parentMonth.childNodes[i].childNodes[3]);
                }


            }
        }
    }
}

console.log("Ready obj.");