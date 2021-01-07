const searchLocBtn = document.getElementById("searchLocationBtn");

const autocompleteInput = document.getElementById("autocomplete");

let professionsFilter = [];

let values = [];

searchLocBtn.addEventListener("click", function(e){

    values = [];

    const inputResult = $('.resultField').children().each(function() {
        values.push(this.value);
    });

    $('div .ad_card_custom').hide();

    $('div .ad_card_custom').each(function() {

        if (getDisplayType(this, values)) {
            this.style.display = "block";
        }
    });

});

const getDisplayType = function (ad, values) {
    let geoFilter = true;
    let professionFilter = false;

    $(ad).children('.searchField').each(function(index) {
        if (values[index] && values[index] != this.value) {
            geoFilter = false;
        }

        if (values.length == 0) {
            geoFilter = true;
        }

    });

    $(ad).children('.professionField').each(function(index){
        if (professionsFilter.length != 0) {
            professionsFilter.forEach(profession => {

                if (profession && profession == this.value) {
                    professionFilter = true;
                }

            });
        } else {
            professionFilter = true;
        }
    });

    if (geoFilter && professionFilter) {
        return true;
    }
    return false;

};

global.toggleDropdown = function toggleDropdown() {
    $("#dropdownSection").toggle();
    $("#searchProfession").val(null);
    filterFunction();
};

global.filterFunction = function filterFunction() {
    let input, filter, p, i;

    input = document.getElementById("searchProfession");
    filter = input.value.toUpperCase();

    div = document.getElementById("dropdownSection");
    p = div.getElementsByTagName("p");

    for (i = 0; i < p.length; i++) {

        txtValue = p[i].textContent || p[i].innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            p[i].style.display = "";
        } else {
            p[i].style.display = "none";
        }
    }
}

$('.dropdown-item').click(function() {
    addFilter(this);
});

const addFilter = function (element) {
    $('#btnFilter').append('<button class="filter-item btn btn-outline-primary" style="margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> ' + element.textContent + '</button>');
    $("#dropdownSection").toggle();

    professionsFilter.push(element.textContent);

    toFilter();

    $('.filter-item').click(function() {
        const index = professionsFilter.indexOf(this.textContent);
        professionsFilter.splice(index, 1);
        this.remove();
        toFilter();
    });

};

const toFilter = function () {

    $('div .ad_card_custom').hide();

    //Ads iteration
    $('div .ad_card_custom').each(function() {

        if (getDisplayType(this, values)) {
            this.style.display = "block";
        }
    });

};

