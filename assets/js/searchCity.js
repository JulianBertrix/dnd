window.getCity = function(data) {
    //vide le container
    $("#cityName").empty();

    //reconstruction de la vue affichant la méteo de la ville recherchée
    $("#cityName").append($("<h1>").text(data.city)
            .append($("<img>").addClass("icon").attr("src", "http://openweathermap.org/img/w/" + data.icon + ".png")))
        .append($("<div>").addClass("row")
            .append($("<div>").addClass("col-6")
                .append($("<h5>").addClass("right").text("temperature : ")))
            .append($("<div>").addClass("col-6")
                .append($("<p>").addClass("left").text(data.temperature + " °C"))))
        .append($("<div>").addClass("row")
            .append($("<div>").addClass("col-6")
                .append($("<h5>").addClass("right").text("humidity rate : ")))
            .append($("<div>").addClass("col-6")
                .append($("<p>").addClass("left").text(data.humidity + " °C"))));
};

window.searchCity = function(e) {
    e.preventDefault();
    $.ajax({
        url: window.location.origin + "/search/city/weather",
        type: "POST",
        data: {
            city: $("#city").val(),
        },
        success: function(datas) {
            getCity(datas)
        },
        error: function() {
            alert("nop");
        }
    });
};