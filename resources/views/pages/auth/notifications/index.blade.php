<x-auth-layout title="Notifications">
    <div class="container mx-auto px-3 mt-5">

        {{-- index --}}
        <div class="w-full shadow-xl rounded-sm border border-gray-300 mt-5">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3 bg-violet-900 rounded-tl-md rounded-tr-md">
                <div class="flex align-center justify-between flex-wrap gap-2">
                    <h5 class="text-white font-medium">
                        <x-icon type="bell" />
                        Notifications
                    </h5>

                    <a href="{{ url()->previous() }}" class="block w-fit text-white">
                        <x-icon type="arrow-left" />
                        Back
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto px-4 h-[80vh] mb-[100px]">
                {{-- list --}}

                <div class="grid gap-4 p-[1em]">
                    @forelse ($data as $item)
                        @if ($item->data['Title'] == 'Validation Result')
                            @php
                                $status = match ($item->data['description']) {
                                    'Your Abaca Validation Result is Accurate' => 2,
                                    'Your Abaca Validation Result is Not Accurate' => 4,
                                    'Your Abaca Validation Result is Less Accurate' => 3,
                                };
                            @endphp

                            <a href="{{ route('inferenced-images.index', ['status' => urlencode($status)]) }}"
                                class="notif-nav" data-id="{{ $item->id }}">
                                <div
                                    class="flex items-center justify-between border border-gray-300 p-[1em] cursor-pointer hover:bg-gray-100 rounded-md">
                                    <div class="grid">
                                        <span
                                            class="text-xl font-medium text-gray-500">{{ $item->data['Title'] }}</span>
                                        <p
                                            class="text-sm font-medium 
                                            {{ $item->data['description'] == 'Your Abaca Validation Result is Accurate' ? 'text-green-500' : '' }} 
                                            {{ $item->data['description'] == 'Your Abaca Validation Result is Not Accurate' ? 'text-red-500' : '' }}
                                            {{ $item->data['description'] == 'Your Abaca Validation Result is Less Accurate' ? 'text-yellow-500' : '' }}
                                            ">
                                            {{ $item->data['description'] }}
                                        </p>
                                    </div>
                                    @if (!$item->read_at)
                                        <span class="rounded-xl bg-blue-500 text-white px-2 py-0 text-sm">New</span>
                                    @else
                                        <span class="text-sm text-gray-400 font-medium">Read at {{$item->read_at->format('F j, Y - h:i a')}}</span>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            readNotfiBeforeRedirect();
        });

        const readNotfiBeforeRedirect = () => {
            const navs = document.querySelectorAll('.notif-nav');

            navs.forEach(item => {
                const url = item.href;
                const id = item.dataset.id;

                item.addEventListener('click', async function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    try {
                        await axios.put(`/set-read/${encodeURIComponent(id)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': window.token
                            }
                        });

                        setTimeout(() => {
                            window.location.href = url;
                        }, 1500);
                    } catch (error) {
                        console.error(error);
                        Toastify({
                            text: 'Server Error, Something went wrong',
                            duration: 2000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: 'left',
                            stopOnFocus: true,
                            style: {
                                background: "rgb(225,100,100)"
                            }
                        }).showToast();
                    }
                });
            });
        };
    </script>
</x-auth-layout>
