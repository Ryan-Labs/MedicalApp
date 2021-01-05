const isGranted = document.getElementById("isGranted").value;
let hasResponse = document.getElementById("hasResponse").value;

const responseSection = document.getElementById("responseSection");
const responseBody = document.getElementById("responseBody");

const alreadyResponseMsg = document.getElementById("alreadyResponseMsg");
const displaySectionBtn = document.getElementById("displaySectionBtn");

const content = document.getElementById("content");

if (isGranted) {

    responseSection.style.display = "block";

    if (!hasResponse) {
        displaySectionBtn.style.display = "block";
    } else {
        alreadyResponseMsg.style.display = "block";
    }

}


global.showContent = function showContent() {

    if ("none" == responseBody.style.display) {
        responseBody.style.display= "block";
    } else {
        responseBody.style.display= "none";
    }

};

global.buildResponse = function showContent(adId) {

    let responseObj = {
        content: content.value,
        adId: adId
    };

    if (confirm("Voulez-vous envoyer votre candidature ?")) {

        fetch("/response/newFromAd",{
            method: "POST",
            headers: {
                "X-Requested-Width": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({'responseObj': responseObj})
        }).then(data => {

            hasResponse = 1;
            displaySectionBtn.style.display = "none";
            responseBody.style.display = "none";
            alreadyResponseMsg.style.display = "block";

             document.location = "/ad/" + adId;
        });

    }

};