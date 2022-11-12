<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('アドバイザープロフィール情報') }}
    </x-slot>

    <x-slot name="description">
        {{ __('アドバイザーのプロフィール情報を更新する。') }}
    </x-slot>

    <x-slot name="form">
        <!-- Company Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Company Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                    x-on:change="
                                     photoName = $refs.photo.files[0].name;
                                     const reader = new FileReader();
                                     reader.onload = (e) => {
                                         photoPreview = e.target.result;
                                     };
                                     reader.readAsDataURL($refs.photo.files[0]);
                             " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Company Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->advisor->profile_photo_url }}" alt="{{ $this->user->advisor->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Company Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->advisor->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="advisor_photo" class="mt-2" />
            </div>
        @endif

        <!-- Company Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="advisor_name" value="{{ __('名前') }}" />
            <x-jet-input name="advisor_name" id="advisor_name" type="text" class="mt-1 block w-full"
                wire:model.defer="state.advisor.name" autocomplete="advisor_name" />
            <x-jet-input-error for="advisor.name" class="mt-2" />
        </div>

        <!-- Company Profile -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="advisor_profile" value="{{ __('紹介') }}" />
            <textarea name="advisor_profile" id="advisor_profile" cols="30" rows="5"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                required wire:model.defer="state.advisor.profile"></textarea>
            <x-jet-input-error for="advisor.profile" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
