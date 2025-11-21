<x-auth-layout title="Manage Users">
    <div class="container mx-auto px-3 mt-5">

        {{-- create --}}
        <a href="{{ route('users.create') }}" class="bg-violet-800 px-2 py-1 text-white rounded-sm hover:bg-violet-500">
            <i class="fa-solid fa-user-plus"></i>
            user
        </a>

        {{-- index --}}
        <div class="w-full shadow-xl rounded-sm border border-gray-300 mt-5">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3">
                <div class="flex align-center justify-between flex-wrap gap-2">
                    <h5 class="text-primary font-medium">
                        <x-icon type="history" />
                        List of Users
                    </h5>
                    <form action="{{ route('users.index') }}" method="GET" class="flex align-items gap-2">
                        <input type="search" name="search" id="search"
                            class="text-sm p-1 border rounded-sm px-2 w-full max-w-[300px] border border-violet-800 text-violet-800 font-medium"
                            placeholder="search by name or email">
                        <button type="submit" class="">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto px-4 h-[70vh]">
                <table class="table-auto border-collapse w-full text-left text-primary">
                    <thead class="border border-x-0 border-t-0 border-b-gray-300 text-nowrap">
                        <tr>
                            <th class="px-2">Action</th>
                            <th class="px-2">
                                @if (empty(urldecode(request('sort_name'))))
                                    <a href="{{ route('users.index', ['sort_name' => urlencode('desc')]) }}">
                                        Name
                                        <i class="fa-solid fa-caret-down"></i>
                                    </a>
                                @else
                                    @if (urldecode(request('sort_name')) == 'desc')
                                        <a href="{{ route('users.index', ['sort_name' => urlencode('asc')]) }}">
                                            Name
                                            <i class="fa-solid fa-caret-up"></i>
                                        </a>
                                    @endif
                                    @if (urldecode(request('sort_name')) == 'asc')
                                        <a href="{{ route('users.index', ['sort_name' => urlencode('desc')]) }}">
                                            Name
                                            <i class="fa-solid fa-caret-down"></i>
                                        </a>
                                    @endif
                                @endif
                            </th>
                            <th class="px-2">Email</th>
                            <th class="p-2">
                                @if (empty(urldecode(request('sort_date'))))
                                    <a href="{{ route('users.index', ['sort_date' => urlencode('desc')]) }}">
                                        Date Created
                                        <i class="fa-solid fa-caret-down"></i>
                                    </a>
                                @else
                                    @if (urldecode(request('sort_date')) == 'desc')
                                        <a href="{{ route('users.index', ['sort_date' => urlencode('asc')]) }}">
                                            Date Created
                                            <i class="fa-solid fa-caret-up"></i>
                                        </a>
                                    @endif
                                    @if (urldecode(request('sort_date')) == 'asc')
                                        <a href="{{ route('users.index', ['sort_date' => urlencode('desc')]) }}">
                                            Date Created
                                            <i class="fa-solid fa-caret-down"></i>
                                        </a>
                                    @endif
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-nowrap">
                        @forelse ($data as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-t-0 border-l-0 border-r-0 p-1 w-1">
                                    <div class="relative flex align-items gap-2">
                                        <button href=""
                                            class="block px-4 py-2 rounded cursor-pointer bg-violet-800 text-white delete-user"
                                            data-id="{{ $item->encrypted_id }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                        <a href="{{ route('users.edit', ['user' => urlencode($item->encrypted_id)]) }}"
                                            class="block px-4 py-2 rounded cursor-pointer bg-violet-800 text-white">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                    </div>
                                </td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->name }}
                                </td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->email }}
                                </td>
                                <td class="border border-t-0 border-l-0 border-r-0 p-1">
                                    {{ $item->created_at->format('F j, Y | h:i:s A') }}
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

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /**
             * event click
             */
            document.addEventListener('click', function(e) {

                /**
                 * delete user
                 */
                const delete_user_btn = e.target.closest('.delete-user');
                if (delete_user_btn) {
                    const id = delete_user_btn.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        text: 'You wont be able to revert it',
                        showCancelButton: true,
                        confirmButtonColor: 'blue',
                        cancelButtonColor: 'red',
                        confirmButtonText: 'Yes, Proceed'
                    }).then(async (result) => {
                        if (!result.isConfirmed) return;

                        try {
                            await axios.delete(`/users/${encodeURIComponent(id)}`, {
                                headers: {
                                    'X-CSRF-TOKEN': window.token,
                                    'Accept': 'application/json'
                                }
                            });

                            Swal.fire({
                                title: 'Success',
                                icon: 'success',
                                text: 'Successfully Deleted User'
                            }).then(() => {
                                window.location.reload();
                            });
                        } catch (error) {
                            console.error(error);
                            Swal.fire({
                                title: 'Server Error',
                                icon: 'error',
                                text: 'Something went wrong, pls try again'
                            });
                            return;
                        }

                    });
                }

            });
        });
    </script>

</x-auth-layout>
