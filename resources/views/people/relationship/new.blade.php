@extends('layouts.skeleton')

@section('content')

<section class="ph3 ph0-ns">

  {{-- Breadcrumb --}}
  <div class="mt4 mw7 center mb3">
    <p><a href="{{ url('/people/'.$contact->id) }}">< {{ $contact->getCompleteName() }}</a></p>
    <div class="mt4 mw7 center mb3">
      <h3 class="f3 fw5">Add a new relationship</h3>
    </div>
  </div>

  <div class="mw7 center br3 ba b--gray-monica bg-white mb6">

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @include('partials.errors')

    <form action="/people" method="POST">
      {{ csrf_field() }}

      <div class="pa4-ns ph3 pv2 mb3 mb0-ns bb b--gray-monica">
        <form-select
          :options="{{ $relationshipTypes }}"
          v-bind:required="true"
          v-bind:title="'Type of relationship'"
          v-bind:id="'relationship_type_id'">
        </form-select>
      </div>

      {{-- New contact / link existing --}}
      <div class="pa4-ns ph3 pv2 mb3 mb0-ns bb b--gray-monica">
        <p class="mb2 b">Who's the relationship with?</p>
        <div class="dt dt--fixed">
          <div class="dtc pr2">
            <input type="radio" id="" name="birthdate" value="approximate" @click="relationship_form_new_contact = true">
            <form-radio
              v-bind:label="'Add a new contact'"
              v-bind:name="'type'" @click="relationship_form_new_contact = true">
            </form-radio>
          </div>
          <div class="dtc">
            <input type="radio" id="" name="birthdate" value="approximate" @click="relationship_form_new_contact = false">
            <form-radio
              v-bind:label="'Link existing contact'"
              v-bind:name="'type'" @click="relationship_form_new_contact = false">
            </form-radio>
          </div>
        </div>
      </div>

      <div v-if="relationship_form_new_contact">
        {{-- Name --}}
        <div class="pa4-ns ph3 pv2 bb b--gray-monica">
          {{-- This check is for the cultures that are used to say the last name first --}}
          <div class="mb3 mb0-ns">
            @if (auth()->user()->name_order == 'firstname_first')

            <div class="dt dt--fixed">
              <div class="dtc pr2">
                <form-input
                  value="{{ $contact->first_name }}"
                  v-bind:input-type="'text'"
                  v-bind:id="'firstname'"
                  v-bind:required="true"
                  v-bind:title="'{{ trans('people.people_add_firstname') }}'">
                </form-input>
              </div>
              <div class="dtc">
                <form-input
                  value="{{ $contact->last_name }}"
                  v-bind:input-type="'text'"
                  v-bind:id="'lastname'"
                  v-bind:required="false"
                  v-bind:title="'{{ trans('people.people_add_lastname') }}'">
                </form-input>
              </div>
            </div>

            @else

            <div class="dt dt--fixed">
              <div class="dtc pr2">
                <form-input
                  value="{{ $contact->last_name }}"
                  v-bind:input-type="'text'"
                  v-bind:id="'lastname'"
                  v-bind:required="false"
                  v-bind:title="'{{ trans('people.people_add_lastname') }}'">
                </form-input>
              </div>
              <div class="dtc">
                <form-input
                  value="{{ $contact->first_naem }}"
                  v-bind:input-type="'text'"
                  v-bind:id="'firstname'"
                  v-bind:required="true"
                  v-bind:title="'{{ trans('people.people_add_firstname') }}'">
                </form-input>
              </div>
            </div>

            @endif
          </div>
        </div>

        {{-- Gender --}}
        <div class="pa4-ns ph3 pv2 mb3 mb0-ns bb b--gray-monica">
          <form-select
            :options="{{ $genders }}"
            v-bind:required="true"
            v-bind:title="'{{ trans('people.people_add_gender') }}'"
            v-bind:id="'gender'">
          </form-select>
        </div>
      </div>

      {{-- Birthdate --}}
      <div class="pa4-ns ph3 pv2 bb b--gray-monica">
        <div class="mb3 mb0-ns">
          <form-specialdate
            v-bind:months="{{ $months }}"
            v-bind:days="{{ $days }}"
            v-bind:month="{{ $month }}"
            v-bind:day="{{ $day }}"
            v-bind:age="'{{ $age }}'"
            v-bind:default-date="'{{ $birthdate }}'"
            v-bind:locale="'{{ auth()->user()->locale }}'"
            :value="'{{ $birthdayState }}'"
          ></form-specialdate>
        </div>
      </div>

      {{-- Form actions --}}
      <div class="ph4-ns ph3 pv3 bb b--gray-monica">
        <div class="flex-ns justify-between">
          <div class="">
            <a href="/people" class="btn btn-secondary w-auto-ns w-100 mb2 pb0-ns">{{ trans('app.cancel') }}</a>
          </div>
          <div class="">
            <button class="btn btn-secondary w-auto-ns w-100 mb2 pb0-ns" name="save_and_add_another" type="submit">{{ trans('people.people_save_and_add_another_cta') }}</button>
            <button class="btn btn-primary w-auto-ns w-100 mb2 pb0-ns" name="save" type="submit">{{ trans('people.people_add_cta') }}</button>
          </div>
        </div>
      </div>

    </form>
  </div>
</section>

@endsection
