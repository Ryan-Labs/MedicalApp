global.showContent = function showContent() {

    const responseSection = document.getElementById("responseSection");
    const display = responseSection.style.display;

    if ("none" == display) {
        responseSection.style.display= "block";
    } else {
        responseSection.style.display= "none";
    }

};

global.buildResponse = function showContent(adId) {

    const content = document.getElementById("content");

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

        });

        //document.location="/ad/";

    }

};