$(document).ready(function(){
    // $("p").click(function(){ 
    //     $.getJSON("https://www.allocine.fr/_/autocomplete/mobile/theater/ugc?callback=?", function(data){
    //         $("this").text(data);
    //     });
    // });
    if($("#showtimes").length){

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var id = urlParams.get('id');
        console.log(id);

        var name = urlParams.get('name');
        console.log(name);

        if(urlParams.has('date')){
            var date = urlParams.get('date');
        }
        else{
            var date = 0;
        }
        
        console.log(date);

        setListeners();
    }
    if($("#search_form").length){
        selected_value = $("input[name='option']:checked").val();
        if(selected_value != "party"){
            $("#cine_name").hide();
            $("#movie").hide();
        }
        $("#search_form").change(function(){
            selected_value = $("input[name='option']:checked").val();
            if(selected_value == "party"){
                $("#cine_name").show();
                $("#movie").show();
            }
            else{
                $("#cine_name").hide();
                $("#movie").hide();
            }
        });
    }

    function setListeners() {
        $("#previous").click(function () { 
            date --;
            $.ajax({
                type: "GET",
                url: "request.php",
                data: {"date": date, "id": id, "name": name},
                success: function (data) {
                    $("#showtimes").replaceWith(data);
                    setListeners();
                }
            });
        });

        $("#next").click(function () { 
            date ++;
            $.ajax({
                type: "GET",
                url: "request.php",
                data: {"date": date, "id": id, "name": name},
                success: function (data) {
                    $("#showtimes").replaceWith(data);
                    setListeners();
                }
            });
        });
    }

});