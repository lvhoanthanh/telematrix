<?php
include '../layout/header.php';
?>
<div class="col-lg-9">
    <div class="title-page"><?= convertToTitleCase(get_page_name()) ?> Management</div>
    <!-- Main Content -->
    <div class="container-table">
        <div class="mt-5">
            <div class="mb-3 mt-3 d-flex justify-content-between header-table">
                <div class="col-md-5 form-control search-container">
                    <span class="search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search" placeholder="Search...">
                </div>
                <button type="button" class="btn btn-primary btn-add">+</button>
            </div>
        </div>
        <table id="device-table" class="table">
            <thead>
                <tr>
                    <th>Device</th>
                    <th>MAC</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody></tbody>

        </table>
        <nav class="container-pagination justify-content-end align-item-center">
            Items per page:
            <ul id='ddlDemoDropdown' class="list-unstyled" style="list-style: none;">
                <li class="init" data-value="10">10</li>
                <li data-value="5">5</li>
                <li data-value="10">10</li>
                <li data-value="15">15</li>
            </ul>
            <div class='display-number-record'></div>
            <div>
                <ul class="pagination"></ul>
            </div>
        </nav>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-modal-label">Edit Device</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation edit-form" novalidate>
                        <input type="hidden" id="edit-id">
                        <div class="form-group">
                            <label for="edit-device">Device:</label>
                            <input type="text" class="form-control" id="edit-device" minlength="3" required>
                            <div class="invalid-feedback">
                                Please enter a device name with at least 3 characters.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit-mac">MAC:</label>
                            <input type="text" class="form-control" id="edit-mac" minlength="3" required>
                            <div class="invalid-feedback">
                                Please enter a MAC address with at least 3 characters.  
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-save-edit">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="create-modal-label">Add Device</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation create-form" novalidate>
                        <div class="form-group">
                            <label for="device">Device:</label>
                            <input type="text" class="form-control" id="device" minlength="3" required>
                            <div class="invalid-feedback">
                                Please enter a device name with at least 3 characters.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mac">MAC:</label>
                            <input type="text" class="form-control" id="mac" minlength="3" required>
                            <div class="invalid-feedback">
                                Please enter a MAC address with at least 3 characters.  
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="delete-id">
            <div class="modal-header">
                <h4 class="modal-title" id="confirm-modal-label">Confirm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this device?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php
include '../layout/footer.php';
?>

<script src="<?php BASE_URL ?>js/devices.js"></script>