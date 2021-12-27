@extends('layouts.app')

@section('content')
    {{--    All contacts --}}
    <div class="container">
        {{--        Top Title --}}
        <div class="row">
            <div class="col-lg border border-1">
                <h2>Contacts</h2>
            </div>
        </div>

        {{--        Column titles --}}
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

        <form action="{{ route('contacts_and_numbers') }}"
              method="POST"
        >
            @csrf

            <div id="js-contacts-wrapper" class="wrapper">

                {{-- One contact --}}
                @foreach($contacts as $contact)
                    <div id="contact_id_{{ $contact->id }}" class="row">
                        {{--        Contact personal info--}}
                        <div class="col-lg-5 border border-1">

                            {{--                            <input type="hidden" name="contacts[{{ $i }}][id]"--}}
                            <input type="hidden" name="contacts[{{ $contact->id }}][id]"

                                   value="{{ $contact->id }}">

                            <div class="row">
                                <div class="col-lg">
                                    {{--                                    <input type="text" name="contacts[{{ $i }}][first_name]"--}}
                                    <input type="text" name="contacts[{{ $contact->id }}][first_name]"

                                           value="{{ $contact->first_name }}">
                                </div>

                                <div class="col-lg">
                                    {{--                                    <input type="text" name="contacts[{{ $i }}][last_name]"--}}
                                    <input type="text" name="contacts[{{ $contact->id }}][last_name]"

                                           value="{{ $contact->last_name }}">
                                </div>
                            </div>

                            @can('update-delete-store')
                                <div class="row">
                                    <div class="col-lg border border-1">

                                        {{-- Button invokes modal to delete a user --}}
                                        <button type="button"
                                                class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                                data-bs-toggle="modal" data-bs-target="#js-delete-existing-record-modal"
                                                {{-- !!!!!!!!!!           This "onclick" and delete phone onclick should be abstracted --}}
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

                        {{-- Contact`s phone numbers --}}

                        <div class="col-lg-7 border border-1">

                            <div id="js-contact_id_{{ $contact->id }}_phones"
                                 class="js-wrapper"
                                 data-contactid= {{ $contact->id }}
                            >

                                @foreach($contact->phoneNumbers as $contactPhone)

                                    <div id="contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}"
                                         class="row">

                                        <input type="hidden"
                                               name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][id]"
                                               value="{{ $contactPhone->id }}">

                                        <input type="hidden"
                                               name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][contact_id]"
                                               value="{{ $contact->id }}">

                                        <div class="col-lg-4 border border-1">
                                            <input type="text"
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][description]"
                                                   value={{ $contactPhone->description }}>
                                        </div>

                                        <div class="col-lg-5 border border-1">
                                            <input type="text"
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][number]"
                                                   value={{ $contactPhone->number }}>
                                        </div>

                                        <div class="col-lg-3 border border-1">

                                            @can('update-delete-store')

                                                <button type="button"
                                                        class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#js-delete-existing-record-modal"
                                                        {{-- !!!!!!!!!!           This "onclick" and delete contact onclick should be abstracted --}}
                                                        onclick="passUrlAndMarkupElementIdToExistingRecordDeleteModal(
                                                            '#contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}',
                                                            '{{ route('phone_numbers.delete', [$contact->id, $contactPhone->id]) }}') "

                                                >
                                                    Delete
                                                </button>

                                            @endcan
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            {{-- Add new number --}}
                            @can('update-delete-store')

                                <div class="row">
                                    <div class="col-lg border border-1">
                                        <button
                                            onclick="addNewNumberFieldExistingContact('#js-contact_id_{{ $contact->id }}_phones', {{ $contact->id }})"
                                            type="button"
                                            class="c-button-link"
                                        >
                                            Add number
                                        </button>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach

            </div>

            @can('update-delete-store')

                <div class="row">
                    <div class="col-lg-2 border border-1">
                        <button onclick="addNewContactField('js-contacts-wrapper')"
                                type="button"
                        >
                            Add a contact
                        </button>
                    </div>

                    <div class="col-lg-1 border border-1">
                        <button type="submit">Save</button>
                    </div>
                </div>

            @endcan

        </form>


    </div>

    @include('includes.modals')


@endsection
