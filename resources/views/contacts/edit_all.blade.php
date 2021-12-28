@extends('layouts.app')

@section('content')

    <div class="container c-container">
        <!--    FORM TITLE  -->
        <div class="row">
            <div class="col-lg">
                <h2>Contacts</h2>
            </div>
        </div>

        <!--    FIELDS` TITLES    -->
        <div class="row">

            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg">
                        <h6>First Name</h6>
                    </div>

                    <div class="col-lg">
                        <h6>Last Name</h6>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <h6>Phone Numbers</h6>
            </div>
        </div>

        <!--    SEPARATOR LINE between "column titles" & "contacts" -->
        <div class="row">
            <div class="col">
                <div class="c-border-line mb-2 mx-auto"></div>
            </div>
        </div>

        <!-- FORM CONTAINING ALL CONTACT DATA (contacts & phone numbers)    -->
        <form action="{{ route('contacts_and_numbers') }}"
              method="POST"
        >
            @csrf

            <div id="js-contacts-wrapper">

                <!-- ONE CONTACT DATA (name & phone) -->
                @foreach($contacts as $contact)
                    <div id="contact_id_{{ $contact->id }}" class="row mb-2">

                        <!--    ONE CONTACT NAME (first, last) -->
                        <div class="col-lg-5">

                            <input type="hidden" name="contacts[{{ $contact->id }}][id]"
                                   value="{{ $contact->id }}">

                            <div class="row">
                                <div class="col-lg">
                                    <input type="text" name="contacts[{{ $contact->id }}][first_name]"
                                           value="{{ $contact->first_name }}"
                                           required
                                    >
                                </div>

                                <div class="col-lg">
                                    <input type="text" name="contacts[{{ $contact->id }}][last_name]"
                                           value="{{ $contact->last_name }}"
                                           required
                                    >
                                </div>
                            </div>

                            <!-- DELETE SINGLE CONTACT BUTTON -->
                            @can('update-delete-store')
                                <div class="row">
                                    <div class="col-lg">
                                        <button type="button"
                                                class="btn btn-link c-btn-link link-danger c-padding-left-remove"
                                                data-bs-toggle="modal" data-bs-target="#js-delete-existing-record-modal"
                                                onclick="passUrlAndMarkupElementIdToExistingRecordDeleteModal(
                                                    '#contact_id_{{ $contact->id }}',
                                                    '{{ route('contacts.delete', [$contact->id]) }}') "
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endcan


                        </div>

                        <!-- CONTACTS PHONE NUMBERS -->
                        <div class="col-lg-7">

                            <div id="js-contact_id_{{ $contact->id }}_phones"
                                 class="js-wrapper"
                                 data-contactid= {{ $contact->id }}
                            >

                            @foreach($contact->phoneNumbers as $contactPhone)

                                <!-- CONTACTS SINGLE PHONE NUMBER -->
                                    <div id="contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}"
                                         class="row">

                                        <input type="hidden"
                                               name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][id]"
                                               value="{{ $contactPhone->id }}">

                                        <input type="hidden"
                                               name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][contact_id]"
                                               value="{{ $contact->id }}">

                                        <div
                                            class="{{ Auth::user()->can('update-delete-store') ? 'col-lg-5' : 'col-lg-6' }}">
                                            <input class="mb-2"
                                                   type="text"
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][description]"
                                                   value="{{ $contactPhone->description }}"
                                                   required
                                            >
                                        </div>

                                        <div
                                            class="{{ Auth::user()->can('update-delete-store') ? 'col-lg-5' : 'col-lg-6' }}">
                                            <input class="mb-2"
                                                   type="text"
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][number]"
                                                   value="{{ $contactPhone->number }}"
                                                   required
                                            >
                                        </div>

                                        <!-- DELETE SINGLE PHONE NUMBER BUTTON -->
                                        @can('update-delete-store')

                                            <div class="col-lg-2">

                                                <button type="button"
                                                        class="btn btn-link c-btn-link link-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#js-delete-existing-record-modal"
                                                        onclick="passUrlAndMarkupElementIdToExistingRecordDeleteModal(
                                                            '#contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}',
                                                            '{{ route('phone_numbers.delete', [$contact->id, $contactPhone->id]) }}') "
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        @endcan

                                    </div>
                                @endforeach
                            </div>


                            <!-- ADD NEW PHONE NUMBER (to existing contact) BUTTON -->
                            @can('update-delete-store')

                                <div class="row">
                                    <div class="col-lg">
                                        <button
                                            onclick="addNewNumberFieldExistingContact('#js-contact_id_{{ $contact->id }}_phones', {{ $contact->id }})"
                                            type="button"
                                            class="btn btn-link c-btn-link link-danger c-padding-left-remove"
                                        >
                                            Add number
                                        </button>
                                    </div>
                                </div>
                            @endcan
                        </div>

                        <!--        Separator (line) - comes after single contact -->
                        <div class="row">
                            <div class="col">
                                <div class="c-border-line mb-2 mx-auto"></div>
                            </div>
                        </div>
                    </div>



                @endforeach

            </div>

            <!-- ADD NEW CONTACT & SUBMIT FORM BUTTONS -->
            @can('update-delete-store')

                <div class="row">
                    <div class="col-lg-2">
                        <button
                            class="c-main-button c-padding-left-remove"
                            onclick="addNewContactField('js-contacts-wrapper')"
                            type="button"
                        >
                            Add a contact
                        </button>
                    </div>

                    <div class="col-lg-1">
                        <button
                            class="c-main-button"
                            type="submit"
                        >
                            Save
                        </button>
                    </div>
                </div>

            @endcan

        </form>

    </div>

    @include('includes.modals')

    <!-- If user is redirected to the page after clicking "save", "value" attribute = "1" -->
    <!-- This value is used by JS -->
    <input id="js-reload-after-save" type="hidden" name="status" value="{{ session('reload_after_save') }}">


@endsection
