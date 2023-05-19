<script src="<?= BASE_URL . 'js/jquery.min.js' ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script>
  $('#loader').hide();
  $("#ddlDemoDropdown").on("click", ".init", function() {
    $(this).closest("#ddlDemoDropdown").children('li:not(.init)').toggle();
  });

  var allOptions = $("#ddlDemoDropdown").children('li:not(.init)');
  $("#ddlDemoDropdown").on("click", "li:not(.init)", function() {
    allOptions.removeClass('selected');
    $(this).addClass('selected');
    $("ul").children('.init').html($(this).html());
    allOptions.toggle();
  });

  $(document).click(function(event) {
    var target = $(event.target);
    // Check if the clicked element is outside the specific element
    if (!target.closest('#ddlDemoDropdown').length) {
      allOptions.hide();
    }
  });
</script>
</body>

</html>