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

        <div id="contacts-wrapper" class="wrapper">

            {{-- One contact --}}
            @foreach($contacts as $contact)
                <div id="contact_id_{{ $contact->id }}" class="row">
                    {{--        Contact personal info--}}
                    <div class="col-lg-5 border border-1">

                        <div class="row">
                            <div class="col-lg">
                                <input type="text" value="{{ $contact->first_name }}">
                            </div>

                            <div class="col-lg">
                                <input type="text" value="{{ $contact->last_name }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg border border-1">
                                {{--                                                                <button--}}
                                {{--                                                                    onclick="deleteContactRetrievedFromDatabase('contact_id_{{ $contact->id }}', '{{ route('contacts.delete', [$contact->id]) }}')"--}}
                                {{--                                                                    type="button" class="c-button-link"--}}
                                {{--                                                                >--}}
                                {{--                                                                    Delete--}}
                                {{--                                                                </button>--}}


                                {{-- Button invokes modal to delete a user --}}
                                <button type="button" id="js-btn-call-delete-existing-contact-modal"
                                        class="btn rounded-pill c-btn-orange mb-4 c-btn-lg"
                                        data-bs-toggle="modal" data-bs-target="#js-delete-existing-contact-modal"
                                        data-url="{{ route('contacts.delete', [$contact->id]) }}"
                                        onclick="passUrlToExistingContactDeleteModal('contact_id_{{ $contact->id }}', '{{ route('contacts.delete', [$contact->id]) }}') "
                                >
                                    <i class="fas fa-user m-r-xs" aria-hidden="true"></i>
                                    Delete - modal
                                </button>


                            </div>
                        </div>

                    </div>

                    {{-- Contact`s phone numbers --}}

                    <div class="col-lg-7 border border-1">

                        <div id="contact_id_{{ $contact->id }}_phones" class="js-wrapper">

                            @foreach($contact->phoneNumbers as $contactPhone)
                                <div class="row">
                                    <div class="col-lg-4 border border-1">
                                        <input type="text" value={{ $contactPhone->description }}>
                                    </div>

                                    <div class="col-lg-5 border border-1">
                                        <input type="text" value={{ $contactPhone->number }}>
                                    </div>

                                    <div class="col-lg-3 border border-1">
                                        <button type="button" class="c-button-link">Delete</button>
                                    </div>
                                </div>
                            @endforeach


                        </div>


                        {{-- Add new number --}}
                        <div class="row">
                            <div class="col-lg border border-1">
                                <button onclick="addNewNumberField('contact_id_{{ $contact->id }}_phones')"
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
                <button onclick="addNewContactField('contacts-wrapper')"
                        type="button"
                >
                    Add a contact
                </button>
            </div>

            <div class="col-lg-1 border border-1">
                <button type="button">Save</button>
            </div>
        </div>


    </div>






    {{-- MODALS --}}
    {{-- Modal 1: - CONTACT FORM --}}
    <div id="js-delete-existing-contact-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="js-delete-existing-user-modal-labeledby"
         aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header justify-content-center">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Are you sure ?</h3>

                    <button type="button" class="btn-close btn-secondary d-none" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>


                <div class="modal-body">

                    <form id="js-delete-existing-contact-form" class="login-form"
                          method="POST"
                          {{-- Form`s "action" attribute is added by custom JS (passUrlToExistingContactDeleteModal() ) --}}
                          action=""
                          enctype="multipart/form-data">
                        @method('DELETE')
                        {{--                        !!!!!!!!!! --}}
                        {{--                        @csrf--}}


                        <div class="form-group">
                            <label class="text-dark" for="email">E-mail adresa:</label>

                            <input type="email" id="email" name="email" class="form-control"
                                   required="required" placeholder="email@adresa.com">

                            <small id="name" class="form-text text-danger">* Obavezno polje</small>
                        </div>


                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">
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

@endsection
