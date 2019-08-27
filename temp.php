<script> 
 
 
 $('body').on('click', 'input#searchVariables', function () {

      var datasetId = $('.TSDatasetID').val();
        var term = $('#searchTextbox').val();
        alert(term);

        $.ajax({
            type: "GET",
            url: "trendssearchresults.aspx?datasetId=" + datasetId + "&term=" + term,
            error: function (xhr, status, error) {

                //alert the error if needed
                alert('Error: ' + xhr.responseText);
            },
            success: function (responseData) {

                $('#searcharea').html(responseData);
                $('#searcharea').show();
            }
        });
 });



  $(document).ready(function () {
    $(".draggableVar").draggable({ revert: false, helper: 'clone', scroll: true, appendTo: 'body', start: function () {
        $(this).data("startingScrollTop", $(this).parent().scrollTop());
    },
        drag: function (event, ui) {
            var st = parseInt($(this).data("startingScrollTop"));
            ui.position.top -= $(document).scrollTop() - st;
        }
    });
</script>