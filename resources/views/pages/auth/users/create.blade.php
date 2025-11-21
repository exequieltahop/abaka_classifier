<x-auth-layout title="Manage Users - Create">
    <div class="container mx-auto px-3 mt-5">

        {{-- create --}}
        <a href="{{ route('users.index') }}" class="bg-violet-800 px-2 py-1 text-white rounded-sm hover:bg-violet-500">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

        {{-- index --}}
        <div class="w-full shadow-xl rounded-sm border border-gray-300 mt-5">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3">
                <div class="flex align-center justify-between flex-wrap gap-2">
                    <h5 class="text-primary font-medium">
                        <x-icon type="user-plus" />
                        Create Users
                    </h5>
                </div>
            </div>
            <div class="flex justify-center">

                {{-- form --}}
                <form action="{{ route('users.store') }}" class="p-3 w-full max-w-[900px]" method="POST">
                    @csrf
                    <div class="grid gap-2">
                        <div class="mb-3">
                            <label for="name" class="font-medium text-violet-800">Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full border border-violet-800 p-2 text-violet-800"
                                placeholder="Ex. Juan Dela Cruz" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-red-700 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="font-medium text-violet-800">Email</label>
                            <input type="email" name="email" id="email"
                                class="w-full border border-violet-800 p-2 text-violet-800"
                                placeholder="email@example.com" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-red-700 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="font-medium text-violet-800">Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full border border-violet-800 p-2 text-violet-800"
                                placeholder="Contains 1 uppercase, 1 lowercase, 1 number  min 8 char">
                            @error('password')
                                <small class="text-red-700 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button
                                class="bg-violet-800 text-white px-2 py-1 rounded-sm cursor-pointer hover:bg-violet-600">
                                <i class="fa-solid fa-arrow-right"></i>
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-auth-layout>
