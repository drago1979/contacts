<div id="js-delete-existing-record-modal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="js-delete-existing-record-modal-labeledby"
     aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header justify-content-center">
                <h3 class="modal-title text-center">Are you sure ?</h3>

                <button type="button" class="btn-close btn-secondary d-none" data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>


            <div class="modal-body">

                <!-- Form`s "action" attribute is added by custom JS (passUrlAndMarkupElementIdToExistingRecordDeleteModal() ) -->
                <form id="js-delete-existing-record-form" class="login-form d-flex justify-content-evenly"
                      method="POST"
                      action=""
                >
                @method('DELETE')
                @csrf

                <!-- Button`s "data-markupid" attribute is added by custom JS (passUrlAndMarkupElementIdToExistingRecordDeleteModal() ) -->
                    <div class="text-center mt-2">
                        <button type="submit"
                                id="js-modal-delete-existing-record-delete-button"
                                class="btn btn-primary btn-flat m-b-30 m-t-30"
                                data-markupid=""
                        >
                            Delete
                        </button>
                    </div>

                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
