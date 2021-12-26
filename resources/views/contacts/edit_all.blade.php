@extends('layouts.app')

{{--@foreach($contacts as $contact)--}}

{{--    {{ $contact->first_name }}--}}

{{--@endforeach--}}

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

                <!--                --><?php
                //                //                This incrementing counter gives values to array-keys <input>
                //                //                "name" attributes
                //                $i = 0;
                //
                //                ?>

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
                                        Delete - modal
                                    </button>


                                </div>
                            </div>

                        </div>

                        {{-- Contact`s phone numbers --}}

                        <div class="col-lg-7 border border-1">

                            <div id="js-contact_id_{{ $contact->id }}_phones"
                                 class="js-wrapper"
                                 data-contactid= {{ $contact->id }}
                            >

                                <!--                                --><?php
                                //                                //                          This incrementing counter also gives values to array-keys <input>
                                //                                //                          "name" attributes
                                //                                $k = 0;
                                //
                                //                                ?>

                                {{--                                NESTED ARRAYS STRUCTURE --}}
                                @foreach($contact->phoneNumbers as $contactPhone)



                                    <div id="contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}"
                                         class="row">

                                        {{--                                        <input type="hidden" value="$(this).parent.attr('contactid')">--}}

                                        {{--                                        <input type="hidden" name="contacts[{{ $i }}][phone_numbers][{{ $k }}][id]"--}}
                                        <input type="hidden" name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][id]"

                                               value="{{ $contactPhone->id }}">

                                        <input type="hidden"
                                               {{--                                               name="contacts[{{ $i }}][phone_numbers][{{ $k }}][contact_id]"--}}
                                               name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][contact_id]"

                                               value="{{ $contact->id }}">

                                        <div class="col-lg-4 border border-1">
                                            <input type="text"
                                                   {{--                                                   name="contacts[{{ $i }}][phone_numbers][{{ $k }}][description]"--}}
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][description]"

                                                   value={{ $contactPhone->description }}>
                                        </div>

                                        <div class="col-lg-5 border border-1">
                                            <input type="text"
                                                   {{--                                                   name="contacts[{{ $i }}][phone_numbers][{{ $k }}][number]"--}}
                                                   name="contacts[{{ $contact->id }}][phone_numbers][{{ $contactPhone->id }}][number]"


                                                   {{--                                            <input type="text" name="phone_number[{{ $contactPhone->id }}][number]"--}}
                                                   value={{ $contactPhone->number }}>
                                        </div>


                                        <div class="col-lg-3 border border-1">
                                            <button type="button"
                                                    class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#js-delete-existing-record-modal"
                                                    {{-- !!!!!!!!!!           This "onclick" and delete contact onclick should be abstracted --}}
                                                    onclick="passUrlAndMarkupElementIdToExistingRecordDeleteModal(
                                                        '#contact_id_{{ $contact->id }}_phone_number_id_{{ $contactPhone->id }}',
                                                        '{{ route('phone_numbers.delete', [$contact->id, $contactPhone->id]) }}') "

                                            >
                                                Delete - modal
                                            </button>
                                        </div>

                                    </div>

                                    <!--                                    --><?php
                                    //                                    $k++;
                                    //
                                    //                                    ?>

                                @endforeach

                                <?php
                                //                                $i++;
                                ?>

                            </div>


                            {{-- Add new number --}}
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
                        </div>
                    </div>
                @endforeach

            </div>

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

        </form>


    </div>






    {{-- MODALS --}}
    {{-- Modal 1: - delete-existing-record-modal --}}
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

                    {{-- Form`s "action" attribute is added by custom JS (passUrlAndMarkupElementIdToExistingRecordDeleteModal() ) --}}
                    <form id="js-delete-existing-record-form" class="login-form"
                          method="POST"
                          action=""
                    >
                        @method('DELETE')
                        @csrf

                        {{-- Button`s "data-markupid" attribute is added by custom JS (passUrlAndMarkupElementIdToExistingRecordDeleteModal() ) --}}
                        <div class="text-center mt-2">
                            <button type="submit"
                                    id="js-modal-delete-existing-record-delete-button"
                                    class="btn btn-primary btn-flat m-b-30 m-t-30"
                                    data-markupid=""
                            >
                                Delete
                            </button>
                        </div>

                    </form>

                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                </div>
            </div>
        </div>
    </div>





    {{-- Modal 2: - delete-non-existing-record-modal --}}
    <div id="js-delete-non-existing-record-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="js-delete-non-existing-record-modal-labeledby"
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

                    {{-- Button`s "data-markupid" attribute is added by custom JS (passUrlAndMarkupElementIdToExistingRecordDeleteModal() ) --}}
                    <div class="text-center mt-2">
                        <button type="button"
                                id="js-modal-delete-non-existing-record-delete-button"
                                class="btn btn-primary btn-flat m-b-30 m-t-30"
                                data-markupid=""
                                onclick="deleteExistingRecordFromMarkup($(this).attr('data-markupid'))"
                        >
                            Delete
                        </button>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                </div>
            </div>
        </div>
    </div>

@endsection






<div class="col-lg-7 border border-1">



</div>
</div>
</div>
`
;
