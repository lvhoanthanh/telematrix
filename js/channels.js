$(document).ready(function() {
    var currentPage = 1;
    var itemsPerPage = 10;
    var totalPages = 1;
    $('#create-modal').on('hidden.bs.modal', function(e) {
        var form = document.querySelector('.create-form');
        form.classList.remove('was-validated');
        $('#edit-channel-name').val('');
        $('#edit-channel-url').val('');
    })

    $('#edit-modal').on('hidden.bs.modal', function(e) {
        var form = document.querySelector('.edit-form');
        form.classList.remove('was-validated');
        $('#edit-channel-name').val('');
        $('#edit-channel-url').val('');
    })

    // Show an alert for 3 seconds
    function showAlert(message, type) {
        var alertDiv = document.createElement("div");
        alertDiv.className = "alert alert-" + type;
        alertDiv.innerHTML = message;
        var contentAlert = document.getElementById("alert-messages");
        contentAlert.innerHTML = '';
        contentAlert.appendChild(alertDiv);
        setTimeout(function() {
            contentAlert.innerHTML = '';
        }, 3000);
    }   

    const action_url = BASE_URL_JS + 'actions/channels.php';
    // Function to load data into the table
    function loadData(currentPage, itemsPerPage) {
        $('#loader').show();
        var search = $('#search').val();
        $.ajax({
            url: action_url,
            type: 'GET',
            data: {
                action: 'read',
                search: search,
                page: currentPage,
                limit: itemsPerPage
            },
            dataType: 'json',
            success: function(data) {
                $('#loader').hide();
                $('#device-table tbody').html('');
                $.each(data.records, function(index, record) {  
                    var row = '<tr>';
                    row += '<td>' + record.channel_name + '</td>';
                    row += '<td>' + record.url + '</td>';
                    row += '<td class="text-center">';
                    row += '<button class="btn btn-sm btn-edit" data-id="' + record.id + '"><img src="'+BASE_URL_JS+'/assets/icons/edit_icon.png" />Edit</button>';
                    row += '<button class="btn btn-sm btn-delete" data-id="' + record.id + '"><img src="'+BASE_URL_JS+'/assets/icons/delete_icon.png" />Delete</button>';
                    row += '</td>';
                    row += '</tr>';
                    $('#device-table tbody').append(row);
                });
                $(".pagination").empty();
                $(".display-number-record").empty();

                totalPages = data.totalPages; // Total number of pages

                var displayPages = 5 // Number of page links to display

                var startPage = currentPage - Math.floor(displayPages / 2); // Calculate the starting page

                // Adjust startPage to ensure it's within valid range
                if (startPage < 1) {
                    startPage = 1;
                } else if (startPage > totalPages - displayPages + 1) {
                    startPage =
                        totalPages - displayPages + 1;
                }
                var fromRecord = (currentPage - 1) * itemsPerPage + 1;
                var toRecord = Math.min(currentPage * itemsPerPage, data.total);

                // Create the pagination links
                var prevArrow = "<li class='page-item'><a class='page-link page-prev' href='#'>&lt;</a></li>";
                var nextArrow = "<li class='page-item'><a class='page-link page-next' href='#'>&gt;</a></li>";
                var firstPageLink = "<li class='page-item'><a class='page-link page-first' href='#'>&laquo;</a></li>";
                var lastPageLink = "<li class='page-item'><a class='page-link page-last' href='#'>&raquo;</a></li>";
                var displayNumberOf = "<div>" + fromRecord + "-" + toRecord + " of " + data.total + "</div>";

                $(".pagination").append(firstPageLink + prevArrow);

                // Create the pagination links based on displayPages
                for (var i = startPage; i < startPage + displayPages; i++) {
                    if (i <= totalPages && i > 0) {
                        var active = (i == currentPage) ? "active" : ""; // Set the active class for the current page
                        $(".pagination").append("<li class='page-item " + active + "'><a class='page-link' href='#'>" + i + "</a></li>");
                    }
                }
                $(".display-number-record").append(displayNumberOf);
                $(".pagination").append(nextArrow + lastPageLink);
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                showAlert(xhr.responseText, 'danger')
            }
        });
    }

    // Function to create a new device
    function createChannel() {
        var form = document.querySelector('.create-form');
        if (!form.checkValidity()) {
            return form.classList.add('was-validated');
        }
        var channel_name = $('#channel_name').val();
        var url = $('#url').val();
        $('#loader').show();
        $.ajax({
            url: action_url,
            type: 'POST',
            data: {
                action: 'create',
                channel_name: channel_name,
                url: url,
            },
            dataType: 'json',
            success: function(data) {
                $('#loader').hide();
                $('#create-modal').modal('hide');
                loadData(currentPage, itemsPerPage);
                showAlert(data.message, 'success')
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                showAlert(xhr.responseText, 'danger')
            }
        });
    }

    // Function to edit an existing device
    function editChannel(id) {
        $('#loader').show();
        $.ajax({
            url: action_url,
            type: 'GET',
            data: {
                action: 'read_one',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#loader').hide();
                $('#edit-id').val(data.id);
                $('#edit-channel-name').val(data.channel_name);
                $('#edit-channel-url').val(data.url);
                $('#edit-modal').modal('show');
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                showAlert(xhr.responseText, 'danger')
            }
        });
    }

    // Function to update an existing device
    function updateChannel() {
        var form = document.querySelector('.edit-form');
        if (!form.checkValidity()) {
            return form.classList.add('was-validated');
        }
        $('#loader').show();
        var id = $('#edit-id').val();
        var channel_name = $('#edit-channel-name').val();
        var url = $('#edit-channel-url').val();
        $.ajax({
            url: action_url,
            method: 'POST',
            data: {
                action: 'update',
                id: id,
                channel_name: channel_name,
                url: url
            },
            success: function(response) {
                $('#loader').hide();
                const data = JSON.parse(response);
                $('#edit-modal').modal('hide');
                // Reload table data
                loadData(currentPage, itemsPerPage)
                // Display success message
                showAlert(data.message, 'success')
            },
            error: function() {
                $('#loader').hide();
                // Display error message
                $('#edit-modal').modal('hide');
                showAlert(xhr.responseText, 'danger')
            }
        });
    }

    // Function to delete a device
    function deleteChannel(id) {
        $('#loader').show();
        $.ajax({
            url: action_url,
            type: 'POST',
            data: {
                action: 'delete',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#loader').hide();
                // Reload table data
                loadData(currentPage, itemsPerPage)
                // Display success message
                showAlert(data.message, 'success')
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                // Display error message
                showAlert(xhr.responseText, 'danger')
            }
        });
    }

    // Load device data when page loads
    loadData(currentPage, itemsPerPage)
    $(document).on('click', '.btn-add', function() {
        $('#create-modal').modal('show');
    });

    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        editChannel(id);
    });

    $(document).on('click', '.btn-save', function() {
        createChannel();
    });

    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        $('#delete-id').val(id)
        $('#confirm-modal').modal('show');
    });

    $(document).on('click', '#confirm-delete-btn', function() {
        var id = $('#delete-id').val();
        deleteChannel(id);
        $('#confirm-modal').modal('hide');
    });

    $(document).on('click', '.btn-save-edit', function() {
        var id = $('#edit-id').val();
        updateChannel(id);
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = parseInt($(this).text());
        if (!isNaN(page) && page !== currentPage) {
            currentPage = page;
            loadData(currentPage, itemsPerPage);
        }
    });

    $(document).on('click', '.page-prev', function(e) {
        e.preventDefault();
        var page = parseInt($('ul.pagination').find('li.active').text()) - 1;
        if (page >= 1)
            currentPage = page;
        else if (page == 1)
            currentPage = 1;
        loadData(currentPage, itemsPerPage);
    });

    $(document).on('click', '.page-next', function(e) {
        e.preventDefault();
        var page = parseInt($('ul.pagination').find('li.active').text()) + 1;
        if (page < totalPages)
            currentPage = page;
        else if (page == totalPages)
            currentPage = totalPages;
        loadData(currentPage, itemsPerPage);
    });

    $(document).on('click', '.page-last', function(e) {
        e.preventDefault();
        currentPage = totalPages;
        loadData(currentPage, itemsPerPage);
    });


    $(document).on('click', '.page-first', function(e) {
        e.preventDefault();
        currentPage = 1;
        loadData(currentPage, itemsPerPage);
    });

    $(document).on('keydown', '#search', function(event) {
        if (event.which === 13 || event.keyCode === 13) {
            event.preventDefault();
            loadData(1, itemsPerPage);
        }
    });

    // Check this click evnet - 
    $(document).on('click', "#ddlDemoDropdown li", function() {
        if (!$(this).hasClass('init')) {
            var selectedValue = $(this).attr('data-value');
            itemsPerPage = selectedValue;
            loadData(1, itemsPerPage);
        }
    });
})