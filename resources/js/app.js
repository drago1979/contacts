/*
|--------------------------------------------------------------------------
| Custom JS code
|--------------------------------------------------------------------------
| This file contains application`s custom JS code
|
*/



// If the user is redirected to the page AFTER clicking on
// "save" button, we will inform him/her
(function checkIfPageReloadedAfterSave () {
    if ($('#js-reload-after-save').attr('value') == 1) {
        alert('If you made any changes - your records are saved.');
    }
})();



// These counters are needed for generating temporary Ids for items added
// by user (items not yet saved in the DB); These IDs are used as array
// keys and as part of "markUpIDs" (used for HTML elements deletion).
let temporaryIdNewNumberExistingContact = 0;
let temporaryIdNewNumberNonExistingContact = 0;
let temporaryIdNonExistingContact = 0;

// --------------------------------------------------------
// ADDING NEW, EMPTY, INPUTS  for Numbers & Contacts
// --------------------------------------------------------

// Adding empty fields for phone description & number & button
// for EXISTING contacts

function addNewNumberFieldExistingContact(idElementToAppendMarkup, contactId) {

    let markup = `
            <div id="contact_number_temporary_id_${temporaryIdNewNumberExistingContact}"
            class="row">

                <input type="hidden"
                       name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][id]"
                       value="">

                <input type="hidden"
                       name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][contact_id]"
                       value="${contactId}">


                <div class="col-lg-5">
                    <input class="mb-2"
                           type="text"
                           name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][description]"
                           value=""
                           required
                    >
                </div>

                <div class="col-lg-5">
                    <input class="mb-2"
                           type="text"
                           name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][number]"
                           value=""
                           required
                     >
                </div>


                <div class="col-lg-2">
                    <button type="button"
                            class="btn btn-link c-btn-link link-danger"
                            onclick="deleteExistingAndNonExistingRecordFromMarkup(
                                '#contact_number_temporary_id_${temporaryIdNewNumberExistingContact}',
                                true)"
                    >
                        Delete
                    </button>
                </div>
            </div>
        `;

    temporaryIdNewNumberExistingContact++;

    $(idElementToAppendMarkup).append(markup);
}

// Adding an empty field for phone description & number & button
// for NON-EXISTING contact
function addNewNumberFieldNonExistingContact(idElementToAppendMarkup, temporaryIdNonExistingContact) {

    let markup = `
            <div id="non_existing_contact_number_temporary_id_${temporaryIdNewNumberNonExistingContact}"
                 class="row">

                <div class="col-lg-5">
                    <input class="mb-2"
                           type="text"
                           name="new_contacts[${temporaryIdNonExistingContact}][phone_numbers][${temporaryIdNewNumberNonExistingContact}][description]"
                           value=""
                           required
                    >
                </div>

                <div class="col-lg-5">
                    <input class="mb-2"
                           type="text"
                           name="new_contacts[${temporaryIdNonExistingContact}][phone_numbers][${temporaryIdNewNumberNonExistingContact}][number]"
                           value=""
                           required
                    >
                </div>

                <div class="col-lg-2">
                    <button type="button"
                            class="btn btn-link c-btn-link link-danger"
                            onclick="deleteExistingAndNonExistingRecordFromMarkup(
                                '#non_existing_contact_number_temporary_id_${temporaryIdNewNumberNonExistingContact}',
                                true)"
                    >
                        Delete
                    </button>
                </div>
            </div>
        `;

    $(idElementToAppendMarkup).append(markup);

    temporaryIdNewNumberNonExistingContact++;

}


// Adding an empty field for new Contact (Contact info + phone info)
// (description, number, buttons)
function addNewContactField(id) {

    let markup = `
            <div id="contact_temporary_id_${temporaryIdNonExistingContact}" class="row mb-2">

                <div class="col-lg-5">

                    <div class="row">
                        <div class="col-lg">
                            <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][first_name]
                                   value=""
                                   required
                            >
                        </div>

                        <div class="col-lg">
                            <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][last_name]
                                   value=""
                                   required
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg">

                            <button type="button"
                                    class="btn btn-link c-btn-link link-danger c-padding-left-remove"
                                    onclick="deleteExistingAndNonExistingRecordFromMarkup(
                                        '#contact_temporary_id_${temporaryIdNonExistingContact}',
                                        true)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>

                </div>


                <div class="col-lg-7">

                    <div id="contact_temporary_id_${temporaryIdNonExistingContact}_phones">
                    </div>

                <div class="row">
                    <div class="col-lg">
                        <button onclick="addNewNumberFieldNonExistingContact('#contact_temporary_id_${temporaryIdNonExistingContact}_phones', '${temporaryIdNonExistingContact}')"
                                type="button"
                                class="btn btn-link c-btn-link link-danger"
                        >
                            Add number
                        </button>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="c-border-line mb-2 mx-auto"></div>
                </div>
            </div>

        </div>


    `
    ;

    $('#' + id).append(markup);
    temporaryIdNonExistingContact++;

}


// --------------------------------------------------------
// DELETING RECORDS (CONTACTS AND NUMBERS)
// --------------------------------------------------------

//
// DELETING EXISTING RECORDS
//

// Existing-record-delete-button passes the:
//      1) Markup-ID &
//      2) DELETE URL to the
// modal`s (delete-existing-record) form (delete-existing-record)
function passUrlAndMarkupElementIdToExistingRecordDeleteModal(markUpId, url) {

    $('#js-modal-delete-existing-record-delete-button').attr('data-markupid', markUpId);

    $('#js-delete-existing-record-form').attr('action', url);

}


// When delete-existing-contact modal/form is submitted,
// do the following:
//      1. Send AJAX request
//      2. Record deleted ? => Call a function to delete the record from markup
//      3. Record not deleted ? => Return "not deleted" info

$('#js-delete-existing-record-form').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: $('#js-delete-existing-record-form').attr('action'),
        type: 'post',
        data: $('#js-delete-existing-record-form').serialize(),
        success: function () {
            deleteExistingAndNonExistingRecordFromMarkup($('#js-modal-delete-existing-record-delete-button').attr('data-markupid'));
            $('#js-delete-existing-record-modal').modal('hide');
        },
        error: function () {
            alert('An error occurred. Please try again later or contact our support.')
            $('#js-delete-existing-record-modal').modal('hide');
        }
    });
});


//
// USED WHEN DELETING BOTH TYPES OF RECORDS (IN & NOT IN THE DATABASE)
//

// Called in 2 cases:
//      1) If "delete-existing-record" AJAX successful:
//      2) If "delete-non-existing-record" delete button clicked.
//
// Performs:
//      1) delete the element from markup
//      2) inform the user (only for existing record deletion)
function deleteExistingAndNonExistingRecordFromMarkup(markupId, empty = false) {

    setTimeout(function () {
        $(markupId).remove();

        // Do this for records that do exist in database:
        if (empty === false) {
            alert('Record deleted.');
            $('#js-delete-non-existing-record-modal').modal('hide');
        }
    }, 200);

}
