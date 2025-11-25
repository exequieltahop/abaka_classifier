<x-auth-layout title="Logs">
    <div class="container mx-auto px-3 mt-5">
        <div class="w-full shadow-xl rounded-sm border border-gray-300">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3">
                <h5 class="text-primary font-medium">
                    <x-icon type="history" />
                    Logs
                </h5>
            </div>
            <div class="overflow-x-auto px-4 h-[70vh]">
                <table class="table-auto border-collapse w-full text-left text-primary">
                    <thead class="border border-x-0 border-t-0 border-b-gray-300 text-nowrap">
                        <tr>
                            <th class="px-2">Action</th>
                            <th class="px-2">Class</th>
                            <th class="px-2">Probability</th>
                            <th class="p-2">Date Inferenced</th>
                            <th class="relative">
                                <div class="dropdown inline-block">
                                    <button id="statusDropdownBtn"
                                        class="flex items-center gap-1 cursor-pointer select-none">
                                        <i class="fa-solid fa-caret-down"></i>
                                        Status
                                    </button>

                                    <ul id="statusDropdownMenu"
                                        class="absolute left-0 mt-2 bg-white shadow-lg rounded border hidden z-50">
                                        <li>
                                            <a href="/inferenced-images"
                                                class="block px-3 py-2 text-blue-300 hover:bg-gray-100 ">
                                                <i class="fa-solid fa-layer-group"></i>
                                                All
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/inferenced-images?status={{ urlencode(2) }}"
                                                class="block px-3 py-2 text-green-500 hover:bg-gray-100 ">
                                                <i class="fa-solid fa-check"></i>
                                                Validated
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/inferenced-images?status={{ urlencode(1) }}"
                                                class="block px-3 py-2 text-gray-500 hover:bg-gray-100 ">
                                                <i class="fa-solid fa-x"></i>
                                                Unvalidated
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>

                            <th class="px-2">Validation</th>
                            <th class="px-2">Validated At</th>
                        </tr>
                    </thead>
                    <tbody class="text-nowrap">
                        @forelse ($data as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-t-0 border-l-0 border-r-0 p-1 w-1">
                                    <div class="relative flex align-items gap-2">
                                        <a href="{{ route('inferenced-images.show', ['inferenced_image' => urlencode($item->encrypted_id)]) }}"
                                            class="block px-4 py-2 rounded bg-violet-800 text-white">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        @if ($item->status == 1)
                                            <button onclick="toggleDropdown(this)"
                                                class="bg-violet-800 text-white px-2 py-1 rounded inline-flex items-center gap-1 cursor-pointer">
                                                <i class="fa fa-pencil"></i> Validate
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div
                                                class="dropdown-menu absolute right-0 mt-1 bg-white border rounded shadow-lg hidden z-50">
                                                <button
                                                    class="block cursor-pointer px-4 py-2 text-gray-600 less-accurate"
                                                    data-id="{{ $item->encrypted_id }}">
                                                    <i class="fa fa-less"></i> Less Accurate
                                                </button>
                                                <button class="block cursor-pointer px-4 py-2 text-green-600 accurate"
                                                    data-id="{{ $item->encrypted_id }}">
                                                    <i class="fa fa-check"></i> Accurate
                                                </button>
                                                <button class="block cursor-pointer px-4 py-2 text-red-600 not-accurate"
                                                    data-id="{{ $item->encrypted_id }}">
                                                    <i class="fa fa-x"></i> Not Accurate
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->system_predicted_class }}</td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">{{ $item->class_probability }}
                                </td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->created_at->format('F j, Y | h:i:s A') }}</td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->status == 1 ? 'Unverified' : 'Verified' }}</td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->expert_validation_string_format }}</td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->updated_at == $item->created_at ? '' : $item->updated_at->format('F j, Y h:i:s A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500">--No Data--</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- pagination --}}
            <div class="w-full p-3 flex align-center justify-end border border-x-0 border-b-0 border-t-gray-300 gap-1">
                <a href="{{ $data->previousPageUrl() }}"
                    class="px-3 py-1 bg-violet-800 text-white font-sm rounded-tl-sm rounded-bl-sm">
                    < Prev </a>
                        <a href="{{ $data->nextPageUrl() }}"
                            class="px-3 py-1 bg-violet-800 text-white font-sm rounded-tr-sm rounded-br-sm">
                            Next >
                        </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Close dropdown if clicked outside
            window.addEventListener('click', async function(e) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e
                            .target)) {
                        menu.classList.add('hidden');
                    }
                });

                // less accurate
                const less_accurate_btn = e.target.closest('.less-accurate');
                if (less_accurate_btn) {
                    const id = less_accurate_btn.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        text: 'You wont be able to revert it',
                        showCancelButton: true,
                        confirmButtonColor: 'blue',
                        cancelButtonColor: 'red',
                        confirmButtonText: 'Yes, Proceed'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const response = await axios.put(
                                    `/inferenced-images/${encodeURIComponent(id)}`, {
                                        type: 2
                                    }, {
                                        headers: {
                                            'X-CSRF-TOKEN': window.token,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                Swal.fire({
                                    title: 'Success',
                                    icon: 'success',
                                    text: 'Successfully Validated Inferenced Image'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } catch (error) {
                                console.error(error);
                                Swal.fire({
                                    title: 'Server Error',
                                    icon: 'error',
                                    text: 'Something went wrong'
                                });
                            }
                        }
                    });
                }
                // accurate
                const accurate = e.target.closest('.accurate');
                if (accurate) {
                    const id = accurate.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        text: 'You wont be able to revert it',
                        showCancelButton: true,
                        confirmButtonColor: 'blue',
                        cancelButtonColor: 'red',
                        confirmButtonText: 'Yes, Proceed'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const response = await axios.put(
                                    `/inferenced-images/${encodeURIComponent(id)}`, {
                                        type: 1
                                    }, {
                                        headers: {
                                            'X-CSRF-TOKEN': window.token,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                Swal.fire({
                                    title: 'Success',
                                    icon: 'success',
                                    text: 'Successfully Validated Inferenced Image'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } catch (error) {
                                console.error(error);
                                Swal.fire({
                                    title: 'Server Error',
                                    icon: 'error',
                                    text: 'Something went wrong'
                                });
                                return;
                            }
                        }
                    });

                }
                // less accurate
                const not_accurate = e.target.closest('.not-accurate');
                if (not_accurate) {
                    const id = not_accurate.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        text: 'You wont be able to revert it',
                        showCancelButton: true,
                        confirmButtonColor: 'blue',
                        cancelButtonColor: 'red',
                        confirmButtonText: 'Yes, Proceed'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const response = await axios.put(
                                    `/inferenced-images/${encodeURIComponent(id)}`, {
                                        type: 3
                                    }, {
                                        headers: {
                                            'X-CSRF-TOKEN': window.token,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                Swal.fire({
                                    title: 'Success',
                                    icon: 'success',
                                    text: 'Successfully Validated Inferenced Image'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } catch (error) {
                                console.error(error);
                                Swal.fire({
                                    title: 'Server Error',
                                    icon: 'error',
                                    text: 'Something went wrong'
                                });
                            }
                        }
                    });
                }
            });

            const btn = document.getElementById("statusDropdownBtn");
            const menu = document.getElementById("statusDropdownMenu");

            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                menu.classList.toggle("hidden");
            });

            document.addEventListener("click", () => {
                menu.classList.add("hidden");
            });

        });

        // Toggle dropdown visibility
        function toggleDropdown(button) {
            const menu = button.nextElementSibling;
            menu.classList.toggle('hidden');
        }
    </script>
</x-auth-layout>
