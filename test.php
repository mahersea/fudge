<script>
$(document).ready(function () {
      //On Dom ready load your draggable if you need to:
      loadjs();
     $('body').on('click', 'input#searchVariables', function () {

            $.ajax({
                type: "GET",
                url: "index.php",
                error: function (xhr, status, error) {
                    alert('Error: ' + xhr.responseText);
                },
                success: function (responseData) {

                    $('#searcharea').html(responseData);
                    $('#searcharea').show();
                    loadjs(responseData);
                }
            });
     });
});

function loadjs(responseData) {
  $(".draggableVar").draggable({ revert: false, helper: 'clone', scroll: true, appendTo: 'body', start: function () {
        $(this).data("startingScrollTop", $(this).parent().scrollTop());
    },
        drag: function (event, ui) {
            var st = parseInt($(this).data("startingScrollTop"));
            ui.position.top -= $(document).scrollTop() - st;
        }
}
</script>
