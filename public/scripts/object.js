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

    let self = this;

    this.genWindow = function () {
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
        body.innerHTML += "<div id=\"background\" class=\"buttonCloseWindows\"></div><div id=\"window" + self.id + "\" class=\"window addWindow\"><h2>Verjaardag bewerken</h2><input id=\"name\" name=\"name\" type=\"text\"><select id=\"day\" name=\"day\">" + daysHTML + "</select><select id=\"month\" name=\"month\">" + monthsHTML + "</select><input id=\"year\" name=\"year\" type=\"number\"><div><span id=\"buttonSubmit\" class=\"button\">Opslaan</span> <span id=\"buttonCancel\" class=\"buttonCloseWindows button\">Annuleer</span></div></div>";
    };

    this.edit = function()
    {
        self.genWindow();

        let window = document.getElementById("window" + self.id);

        document.getElementsByName("name")[0].setAttribute("value", this.person);
        getElementsByAttribute("value", document.getElementById('day'))[this.day].setAttribute("selected", "true");
        getElementsByAttribute("value", document.getElementById('month'))[this.month - 1].setAttribute("selected", "true");
        document.getElementsByName("year")[0].setAttribute("value", this.year);

        document.getElementById("buttonCancel").onclick = function () {
            document.getElementById('background').parentNode.removeChild(document.getElementById('background'));
            document.getElementById('window' + self.id).parentNode.removeChild(document.getElementById('window' + self.id));
        };
        document.getElementById("buttonSubmit").onclick = function () {

            document.getElementById(document.getElementsByName('month'));
            console.log(document.getElementById(document.getElementsByName('month')[0].value));

            document.getElementById('background').parentNode.removeChild(document.getElementById('background'));
            document.getElementById('window' + self.id).parentNode.removeChild(document.getElementById('window' + self.id));
        };
    }

    this.delete = function ()
    {
        
    }
}

console.log("Ready obj.");