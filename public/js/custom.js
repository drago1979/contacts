// require('./bootstrap');


// These counters are needed for generating temporary Ids for items added
// by user (items not yet saved in the DB);
// These IDs are used (mostly) for array keys.
let temporaryIdNewNumberExistingContact = 0;
let temporaryIdNewNumberNonExistingContact = 0;
let temporaryIdNonExistingContact = 0;

// --------------------------------------------------------
// ADDING NEW, EMPTY, INPUTS (Numbers, Contacts)
// --------------------------------------------------------

// Adding a new, empty, field for phone description and number + buttons
// for EXISTING contacts

function addNewNumberFieldExistingContact(idElementToAppendMarkup, contactId) {

    let markup = `
            <div id="contact_number_temporary_id_${temporaryIdNewNumberExistingContact}" class="row">

                <input type="hidden" name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][id]"
                value='b'>

                <input type="hidden" name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][contact_id]"
                value=${contactId}>


                <div class="col-lg-4 border border-1">
                    <input type="text" name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][description]" value="">
                </div>

                <div class="col-lg-5 border border-1">
                    <input type="text" name="contacts[${contactId}][phone_numbers][t${temporaryIdNewNumberExistingContact}][number]" value="">
                </div>

                <div class="col-lg-3 border border-1">
                                        <button type="button"
                                                class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
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

// Adding a new, empty, field for phone description and number + buttons
// for NON-EXISTING contact
function addNewNumberFieldNonExistingContact(idElementToAppendMarkup, temporaryIdNonExistingContact) {

    let markup = `
            <div id="non_existing_contact_number_temporary_id_${temporaryIdNewNumberNonExistingContact}" class="row">

                <div class="col-lg-4 border border-1">
                    <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][phone_numbers][${temporaryIdNewNumberNonExistingContact}][description]" value="">
                </div>

                <div class="col-lg-5 border border-1">
                    <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][phone_numbers][${temporaryIdNewNumberNonExistingContact}][number]" value="">
                </div>

                <div class="col-lg-3 border border-1">
                                        <button type="button"
                                                class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
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


// Adding a new, empty, field for new Contact (Contact`s info + phone info
// (description, number, buttons)
function addNewContactField(id) {

    let markup = `
            <div id="contact_temporary_id_${temporaryIdNonExistingContact}" class="row">

                <div class="col-lg-5 border border-1">


                    <div class="row">
                        <div class="col-lg">
                            <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][first_name] value="">
                        </div>

                        <div class="col-lg">
                            <input type="text" name="new_contacts[${temporaryIdNonExistingContact}][last_name] value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg border border-1">

                            <button type="button"
                                    class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                    onclick="deleteExistingAndNonExistingRecordFromMarkup(
                                        '#contact_temporary_id_${temporaryIdNonExistingContact}',
                                        true)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>

                </div>


                <div class="col-lg-7 border border-1">

                    <div id="contact_temporary_id_${temporaryIdNonExistingContact}_phones"
                    class="js-wrapper">

                    </div>



                <div class="row">
                    <div class="col-lg border border-1">
                        <button onclick="addNewNumberFieldNonExistingContact('#contact_temporary_id_${temporaryIdNonExistingContact}_phones', '${temporaryIdNonExistingContact}')"
                                type="button"
                                class="c-button-link"
                        >
                            Add number
                        </button>
                    </div>

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

// When delete-existing-contact modal/form is submited,
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
            $('#js-delete-existing-record-modal').modal('hide');
            deleteExistingAndNonExistingRecordFromMarkup($('#js-modal-delete-existing-record-delete-button').attr('data-markupid'));
        },
        error: function () {
            alert('An error occurred. Please try again later or contact our support.')
            $('#js-delete-existing-record-modal').modal('hide');
        }
    });
});

//
// DELETING RECORDS NOT YET IN DATABASE
//

function passMarkupElementIdToNonExistingRecordDeleteModal(temporaryElementId) {
    $('#js-modal-delete-non-existing-record-delete-button').attr('data-markupid', temporaryElementId);
}

//
// USED WHEN DELETING BOTH TYPES OF RECORDS (IN & NOT IN THE DATABASE)
//

// Called in 2 cases:
//      1) If "delete-existing-record" AJAX successful:
//      2) If "delete-non-existing-record" modal`s delete button clicked.
//
// Performs:
//      1) delete the element from markup
//      2) inform the user
function deleteExistingAndNonExistingRecordFromMarkup(markupId, empty = false) {

    $(markupId).remove();

    // Do this for records that do exist in database:
    if (empty === false) {
        alert('Record deleted.');
        $('#js-delete-non-existing-record-modal').modal('hide');
    }
}
