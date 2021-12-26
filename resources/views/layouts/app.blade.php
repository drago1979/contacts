<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--    !!!!! --}}
    {{--    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>--}}

    {{--    !!!!! --}}
    {{--    <meta name="description" content="{{ $page_description }}">--}}

    {{--    !!!!! --}}
    {{--    --}}{{-- CSS: Normalize --}}
    {{--    <link href="http://default_project.test/assets/css/normalize.css" rel="stylesheet" type="text/css">--}}

    {{-- CSS: Bootstrap:--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{--    @if(app()->environment() == 'production')--}}
    {{--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    {{--    @elseif(app()->environment() == 'local')--}}
    {{--        <link href={{ asset('assets/css/app.css') }} rel="stylesheet" type="text/css">--}}
    {{--    @endif--}}


<!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}


<!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}


</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="">
        @yield('content')
    </main>
</div>


{{-- JS: Jquery--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

{{-- JS: Bootstrap & Poppers--}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

{{--     !!!! --}}
{{--    --}}{{-- JS: Custom--}}
{{--    <script src="{{ asset('assets/site/js/custom.js') }}"></script>--}}

{{-- Move this code to separate file --}}
<script>

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
                                        <button type="button" id="js-btn-call-delete-non-existing-record-modal"
                                                class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                                data-bs-toggle="modal"
                                                data-bs-target="#js-delete-non-existing-record-modal"
                                                onclick="passMarkupElementIdToNonExistingRecordDeleteModal(
                                                    '#contact_number_temporary_id_${temporaryIdNewNumberExistingContact}')"

                                        >
                                            Delete - modal
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
                                        <button type="button" id="js-btn-call-delete-non-existing-record-modal"
                                                class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                                data-bs-toggle="modal"
                                                data-bs-target="#js-delete-non-existing-record-modal"
                                                onclick="passMarkupElementIdToNonExistingRecordDeleteModal(
                                                    '#non_existing_contact_number_temporary_id_${temporaryIdNewNumberNonExistingContact}')"

                                        >
                                            Delete - modal
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

                            <button type="button" id="js-btn-call-delete-existing-record-modal"
                                    class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                    data-bs-toggle="modal" data-bs-target="#js-delete-non-existing-record-modal"
                                    onclick="passMarkupElementIdToNonExistingRecordDeleteModal(
                                        '#contact_temporary_id_${temporaryIdNonExistingContact}')"
                            >
                                Delete - modal
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

    $('#js-delete-existing-record-modal').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $('#js-delete-existing-record-form').attr('action'),
            type: 'post',
            data: $('#js-delete-existing-record-form').serialize(),
            success: function () {
                $('#js-delete-existing-record-modal').modal('hide');
                deleteExistingRecordFromMarkup($('#js-modal-delete-existing-record-delete-button').attr('data-markupid'));
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
    function deleteExistingRecordFromMarkup(markupId) {

        console.log(markupId);

        $(markupId).remove();
        alert('Record deleted.');
        $('#js-delete-non-existing-record-modal').modal('hide');

    }


</script>


</body>
</html>
