const searchLocBtn = document.getElementById("searchLocationBtn");

const autocompleteInput = document.getElementById("autocomplete");

searchLocBtn.addEventListener("click", function(e){

    let values = [];

    const inputResult = $('.resultField').children().each(function() {
        values.push(this.value);
    });

    $('div .ad_card_custom').hide()

    $('div .ad_card_custom').each(function() {

        if (getDisplayType(this, values)) {
            this.style.display = "block";
        }
    });

});

const getDisplayType = function (ad, values) {
    let show = true;

    $(ad).children('.searchField').each(function(index){
        if (values[index] && values[index] != this.value) {
            show = false;
        }
    });

    return show;
};